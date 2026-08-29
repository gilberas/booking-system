<x-guest-layout>
    <div class="mb-3 text-center">
        <h2 class="auth-heading mb-1">{{ __('Two-factor authentication') }}</h2>
        <p class="auth-subheading mb-0">{{ __('Enter the authentication code provided by your authenticator application, or one of your recovery codes.') }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger small mb-3" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login.store') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="code">{{ __('Authentication code') }}</label>
            <input id="code" class="auth-input w-100 text-center" type="text" name="code" inputmode="numeric" autocomplete="one-time-code" autofocus maxlength="6" />
        </div>

        <div class="mb-3">
            <label class="auth-label" for="recovery_code">{{ __('Recovery code') }}</label>
            <input id="recovery_code" class="auth-input w-100" type="text" name="recovery_code" autocomplete="one-time-code" />
            <div class="small mt-1" style="color:#64748b;">{{ __('Use the recovery code only if you do not have access to your authenticator app.') }}</div>
        </div>

        <button type="submit" class="auth-btn w-100">{{ __('Continue') }}</button>
    </form>

    <div class="text-center mt-3">
        <a class="auth-link" href="{{ route('login') }}">{{ __('Back to login') }}</a>
    </div>
</x-guest-layout>