<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\SendOtpNotification;
use App\Services\MfaService;
use App\Support\Demo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        private readonly MfaService $mfaService,
    ) {}

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * Credentials are validated but authentication is NOT completed here.
     * A one-time OTP challenge is created and the user is redirected to the
     * MFA verification page. Authentication only completes after the OTP
     * has been verified.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = $request->authenticate();

        $request->session()->regenerate();

        $otp = $this->mfaService->generateOtp();
        $challenge = $this->mfaService->createChallenge($user, $otp);

        $request->session()->put('mfa.challenge_token', $challenge->challenge_token);
        $request->session()->put('mfa.remember', $request->boolean('remember'));

        if (Demo::otpDisplayEnabled()) {
            $request->session()->put('mfa.demo_otp', $otp);
        }

        $user->notify(new SendOtpNotification($otp, $challenge->expires_at));

        return redirect()->route('mfa.verify');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->forget(['mfa.challenge_token', 'mfa.demo_otp']);
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
