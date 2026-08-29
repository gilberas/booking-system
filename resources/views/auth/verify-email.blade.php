<x-guest-layout>
    <div class="mb-3 text-center">
        <h2 class="auth-heading mb-1">{{ __('Verify your email address') }}</h2>
        <p class="auth-subheading mb-0">{{ __('Thanks for signing up! Before getting started, verify your email address by clicking the link we just sent you.') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small mb-3">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="auth-btn w-100">{{ __('Resend Verification Email') }}</button>
    </form>

    <div class="text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link auth-link text-decoration-none p-0">{{ __('Log Out') }}</button>
        </form>
    </div>
</x-guest-layout>
