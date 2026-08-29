<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="email">{{ __('Email') }}</label>
            <input id="email" class="auth-input w-100" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

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

        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label small" style="color:var(--lp-text);" for="remember_me">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex align-items-center justify-content-between gap-2">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <button type="submit" class="auth-btn">{{ __('Log in') }}</button>
        </div>
    </form>

    @if (\App\Support\Demo::loginUiEnabled())
        <div class="mt-4 pt-3 border-top">
            <div class="small fw-semibold mb-2" style="color:var(--lp-text);">{{ __('Demo Accounts') }}</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach (App\Models\Role::orderBy('id')->pluck('name', 'slug') as $slug => $roleName)
                    <button type="button" class="btn btn-sm btn-outline-secondary demo-account-btn" data-demo-email="{{ \App\Support\Demo::emailFor($slug) }}">
                        {{ $roleName }}
                    </button>
                @endforeach
            </div>
            <div class="small mt-2" style="color:#64748b;">
                {{ __('Password') }}: <code>Password123!</code>
            </div>
        </div>

        <script>
            document.querySelectorAll('.demo-account-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const email = btn.dataset.demoEmail;
                    const emailInput = document.getElementById('email');
                    const passwordInput = document.getElementById('password');
                    if (email && emailInput) {
                        emailInput.value = email;
                        emailInput.focus();
                    }
                    if (passwordInput) {
                        passwordInput.value = 'Password123!';
                    }
                });
            });
        </script>
    @endif
</x-guest-layout>
