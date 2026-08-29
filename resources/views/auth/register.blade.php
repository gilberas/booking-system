<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="name">{{ __('Name') }}</label>
            <input id="name" class="auth-input w-100" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label class="auth-label" for="email">{{ __('Email') }}</label>
            <input id="email" class="auth-input w-100" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label class="auth-label" for="password">{{ __('Password') }}</label>
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

        <div class="d-flex align-items-center justify-content-between gap-2">
            <a class="auth-link" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <button type="submit" class="auth-btn">{{ __('Register') }}</button>
        </div>
    </form>
</x-guest-layout>
