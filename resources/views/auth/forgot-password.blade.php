<x-guest-layout>
    <div class="mb-3 text-center">
        <h2 class="auth-heading mb-1">{{ __('Reset your password') }}</h2>
        <p class="auth-subheading mb-0">{{ __("Enter your email address and we'll send you a password reset link.") }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="email">{{ __('Email') }}</label>
            <input id="email" class="auth-input w-100" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="auth-btn w-100">{{ __('Send Password Reset Link') }}</button>
    </form>

    <div class="text-center mt-3">
        <a class="auth-link" href="{{ route('login') }}">{{ __('Back to login') }}</a>
    </div>
</x-guest-layout>
