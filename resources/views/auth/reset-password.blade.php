<x-guest-layout>
    <div class="mb-3 text-center">
        <h2 class="auth-heading mb-1">{{ __('Set a new password') }}</h2>
        <p class="auth-subheading mb-0">{{ __('Choose a strong password you haven\'t used before.') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="auth-label" for="email">{{ __('Email') }}</label>
            <input id="email" class="auth-input w-100" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label class="auth-label" for="password">{{ __('New Password') }}</label>
            <div class="position-relative">
                <input id="password" class="auth-input w-100 pe-5" type="password" name="password" required autocomplete="new-password" />
                <span class="password-toggle-icon position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password', this)">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label class="auth-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <div class="position-relative">
                <input id="password_confirmation" class="auth-input w-100 pe-5" type="password" name="password_confirmation" required autocomplete="new-password" />
                <span class="password-toggle-icon position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password_confirmation', this)">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="auth-btn w-100">{{ __('Reset Password') }}</button>
    </form>

    <div class="text-center mt-3">
        <a class="auth-link" href="{{ route('login') }}">{{ __('Back to login') }}</a>
    </div>
</x-guest-layout>