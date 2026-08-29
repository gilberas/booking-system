<x-guest-layout>
    <div class="mb-3 small text-center" style="color:var(--lp-text);">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="password">{{ __('Password') }}</label>
            <div class="position-relative">
                <input id="password" class="auth-input w-100 pe-5" type="password" name="password" required autocomplete="current-password" />
                <span class="password-toggle-icon position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password', this)">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="auth-btn w-100">{{ __('Confirm') }}</button>
    </form>
</x-guest-layout>
