<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MfaVerifyRequest;
use App\Models\MfaChallenge;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use App\Services\MfaService;
use App\Support\Demo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class MfaChallengeController extends Controller
{
    public function __construct(
        private readonly MfaService $mfaService,
    ) {}

    /**
     * Display the OTP verification page.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $challenge = $this->pendingChallenge($request);

        if (! $challenge) {
            return redirect()->route('login')
                ->withErrors(['mfa' => __('Your authentication session has expired. Please sign in again.')]);
        }

        return view('auth.mfa', [
            'challengeToken' => $challenge->challenge_token,
            'demoOtp' => Demo::otpDisplayEnabled() ? $request->session()->get('mfa.demo_otp') : null,
            'resendSeconds' => $this->mfaService->resendCooldownSeconds($challenge),
        ]);
    }

    /**
     * Verify the submitted OTP and, on success, complete authentication.
     */
    public function verify(MfaVerifyRequest $request): RedirectResponse
    {
        $challenge = $this->pendingChallenge($request);

        if (! $challenge) {
            return redirect()->route('login')
                ->withErrors(['mfa' => __('Your authentication session has expired. Please sign in again.')]);
        }

        $rateLimitKey = 'mfa-verify:'.$challenge->challenge_token.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 10)) {
            return back()->withErrors(['mfa' => __('Too many verification requests. Please wait before trying again.')]);
        }

        $result = $this->mfaService->verify($challenge, $request->string('code'));

        if ($result === MfaService::SUCCESS) {
            RateLimiter::clear($rateLimitKey);

            $user = $challenge->user;

            if ($user->is_active === false) {
                $this->mfaService->invalidate($challenge);

                return redirect()->route('login')
                    ->withErrors(['mfa' => __('Your authentication session has expired. Please sign in again.')]);
            }

            $this->mfaService->markUsed($challenge);

            Auth::login($user, (bool) $request->session()->get('mfa.remember', false));

            $request->session()->regenerate();
            $request->session()->forget(['mfa.challenge_token', 'mfa.demo_otp', 'mfa.remember']);

            return $this->redirectForRole($user);
        }

        RateLimiter::hit($rateLimitKey);

        return match ($result) {
            MfaService::EXPIRED => $this->expireChallenge($challenge),
            MfaService::LOCKED => $this->expireChallenge($challenge, __('Too many verification attempts. Please request a new code.')),
            MfaService::USED => back()->withErrors(['mfa' => __('This verification code is no longer valid.')]),
            default => back()->withErrors(['mfa' => __('That verification code is incorrect.')]),
        };
    }

    /**
     * Resend a new OTP for the pending challenge.
     */
    public function resend(Request $request): RedirectResponse
    {
        $challenge = $this->pendingChallenge($request);

        if (! $challenge) {
            return redirect()->route('login')
                ->withErrors(['mfa' => __('Your authentication session has expired. Please sign in again.')]);
        }

        if ($this->mfaService->resendCooldownSeconds($challenge) > 0) {
            return back()->withErrors(['mfa' => __('Too many verification requests. Please wait before trying again.')]);
        }

        $otp = $this->mfaService->generateOtp();
        $challenge = $this->mfaService->refreshChallenge($challenge, $otp);

        if (Demo::otpDisplayEnabled()) {
            $request->session()->put('mfa.demo_otp', $otp);
        }

        $challenge->user->notify(new SendOtpNotification($otp, $challenge->expires_at));

        return redirect()->route('mfa.verify');
    }

    /**
     * Resolve the challenge tied to the current session.
     */
    private function pendingChallenge(Request $request): ?MfaChallenge
    {
        $token = $request->session()->get('mfa.challenge_token');

        return $token
            ? MfaChallenge::where('challenge_token', $token)->first()
            : null;
    }

    /**
     * Invalidate a challenge that can no longer be used and show a message.
     */
    private function expireChallenge(MfaChallenge $challenge, string $message = ''): RedirectResponse
    {
        $this->mfaService->invalidate($challenge);

        return back()->withErrors([
            'mfa' => $message ?: __('This verification code has expired. Please request a new code.'),
        ]);
    }

    /**
     * Redirect the user to the appropriate dashboard based on their role.
     */
    private function redirectForRole(User $user): RedirectResponse
    {
        if ($user->hasRole('administrator')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole(['hotel-manager', 'receptionist'])) {
            return redirect()->route('staff.dashboard');
        }

        return redirect()->route('customer.dashboard');
    }
}
