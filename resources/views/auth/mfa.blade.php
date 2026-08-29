<x-guest-layout>
    <div class="mb-3 text-center">
        <h2 class="auth-heading mb-1">{{ __('Verify your identity') }}</h2>
        <p class="auth-subheading mb-0">{{ __("We've sent a 6-digit verification code to your email.") }}</p>
    </div>

    @if ($demoOtp)
        <div class="alert alert-warning small text-center fw-semibold mb-3">
            DEVELOPMENT ONLY — OTP: {{ $demoOtp }}
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success small mb-3">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger small mb-3" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('mfa.verify.store') }}" id="mfa-form" autocomplete="off">
        @csrf

        <div class="otp-group mb-3" id="otp-group" aria-label="{{ __('Verification code') }}">
            @for ($i = 0; $i < 6; $i++)
                <input type="text"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    maxlength="1"
                    autocomplete="one-time-code"
                    class="otp-input"
                    data-otp-index="{{ $i }}"
                    aria-label="{{ __('Digit') }} {{ $i + 1 }}" />
            @endfor
        </div>

        <input type="hidden" name="code" id="otp-code" value="" />

        <button type="submit" class="auth-btn w-100" id="mfa-submit" disabled>
            <span class="spinner-border spinner-border-sm d-none me-1" id="mfa-submit-spinner" aria-hidden="true"></span>
            {{ __('Verify') }}
        </button>
    </form>

    <form method="POST" action="{{ route('mfa.resend') }}" class="text-center mt-3" id="mfa-resend-form">
        @csrf
        <button type="submit" class="btn btn-link auth-link text-decoration-none" id="mfa-resend-btn" {{ $resendSeconds > 0 ? 'disabled' : '' }}>
            <span id="mfa-resend-label">
                @if ($resendSeconds > 0)
                    {{ __('Resend code in :seconds seconds', ['seconds' => $resendSeconds]) }}
                @else
                    {{ __('Resend Code') }}
                @endif
            </span>
        </button>
    </form>

    <div class="text-center mt-2">
        <a class="auth-link" href="{{ route('login') }}">{{ __('Use a different account') }}</a>
    </div>

    @push('scripts')
        <script>
            (function () {
                const group = document.getElementById('otp-group');
                const codeInput = document.getElementById('otp-code');
                const form = document.getElementById('mfa-form');
                const submitBtn = document.getElementById('mfa-submit');
                const spinner = document.getElementById('mfa-submit-spinner');
                const inputs = Array.from(group.querySelectorAll('.otp-input'));
                const resendBtn = document.getElementById('mfa-resend-btn');
                const resendLabel = document.getElementById('mfa-resend-label');
                let countdown = {{ (int) $resendSeconds }};

                function currentCode() {
                    return inputs.map(i => i.value).join('');
                }

                function syncSubmit() {
                    const code = currentCode();
                    const complete = code.length === inputs.length;
                    submitBtn.disabled = !complete;
                    codeInput.value = code;
                }

                function focusInput(index) {
                    if (index >= 0 && index < inputs.length) {
                        inputs[index].focus();
                    }
                }

                function handleInput(index) {
                    const input = inputs[index];
                    let value = input.value.replace(/\D/g, '');
                    input.value = value;

                    if (value.length > 0) {
                        const remaining = value.split('').slice(1);
                        let cursor = index + 1;
                        remaining.forEach(digit => {
                            if (cursor < inputs.length) {
                                inputs[cursor].value = digit;
                                cursor++;
                            }
                        });
                        focusInput(Math.min(index + 1, inputs.length - 1));
                    }

                    syncSubmit();
                }

                function handlePaste(startIndex, pastedText) {
                    const digits = pastedText.replace(/\D/g, '').split('');
                    let cursor = startIndex;
                    digits.forEach(digit => {
                        if (cursor < inputs.length) {
                            inputs[cursor].value = digit;
                            cursor++;
                        }
                    });
                    focusInput(Math.min(cursor, inputs.length - 1));
                    syncSubmit();
                }

                inputs.forEach((input, index) => {
                    input.addEventListener('input', () => handleInput(index));

                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Backspace') {
                            if (input.value === '' && index > 0) {
                                e.preventDefault();
                                inputs[index - 1].value = '';
                                focusInput(index - 1);
                                syncSubmit();
                            } else {
                                syncSubmit();
                            }
                        }
                    });

                    input.addEventListener('paste', (e) => {
                        e.preventDefault();
                        const text = (e.clipboardData || window.clipboardData).getData('text');
                        handlePaste(index, text);
                    });

                    input.addEventListener('focus', () => input.select());
                });

                function tickResend() {
                    if (countdown <= 0) {
                        resendBtn.disabled = false;
                        resendLabel.textContent = '{{ __('Resend Code') }}';
                        return;
                    }
                    resendLabel.textContent = '{{ __('Resend code in :seconds seconds', ['seconds' => '__SECONDS__']) }}'.replace('__SECONDS__', countdown);
                    countdown--;
                    setTimeout(tickResend, 1000);
                }

                if (countdown > 0) {
                    resendBtn.disabled = true;
                    tickResend();
                }

                form.addEventListener('submit', () => {
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                });

                syncSubmit();
                inputs[0].focus();
            })();
        </script>
    @endpush
</x-guest-layout>
