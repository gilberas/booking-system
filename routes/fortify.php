<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Passkeys\Http\Controllers\PasskeyConfirmationController;
use Laravel\Passkeys\Http\Controllers\PasskeyLoginController;
use Laravel\Passkeys\Http\Controllers\PasskeyRegistrationController;

/*
|--------------------------------------------------------------------------
| Fortify Routes (non-colliding subset)
|--------------------------------------------------------------------------
|
| Fortify::ignoreRoutes() is called in AppServiceProvider to prevent
| auto-registration of all Fortify routes (which collide with Breeze).
| This file re-registers only the routes Breeze does not provide:
|   - Two-factor authentication routes
|   - Passkey routes
|   - Password confirmation status / store routes
|
*/

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $passkeyLimiter = config('fortify.limiters.passkeys');

    // Password Confirmation Status...
    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirm.store');

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('two-factor.login');

        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:'.config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
            ]))->name('two-factor.login.store');

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::post('/user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');

        Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');

        Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.regenerate-recovery-codes');
    }

    // Passkeys...
    if (Features::enabled(Features::passkeys())) {
        $throttle = $passkeyLimiter ? ['throttle:'.$passkeyLimiter] : [];

        $passkeyAuthMiddleware = [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')];

        $passkeyMiddleware = config('fortify-options.passkeys.confirmPassword', true)
            ? [...$passkeyAuthMiddleware, 'password.confirm']
            : $passkeyAuthMiddleware;

        $passkeyGuestMiddleware = ['guest:'.config('fortify.guard'), ...$throttle];
        $passkeyConfirmMiddleware = [...$passkeyAuthMiddleware, ...$throttle];
        $passkeyManageMiddleware = [...$passkeyMiddleware, ...$throttle];

        Route::get('/passkeys/login/options', [PasskeyLoginController::class, 'index'])
            ->middleware($passkeyGuestMiddleware)
            ->name('passkey.login-options');

        Route::post('/passkeys/login', [PasskeyLoginController::class, 'store'])
            ->middleware($passkeyGuestMiddleware)
            ->name('passkey.login');

        Route::get('/passkeys/confirm/options', [PasskeyConfirmationController::class, 'index'])
            ->middleware($passkeyConfirmMiddleware)
            ->name('passkey.confirm-options');

        Route::post('/passkeys/confirm', [PasskeyConfirmationController::class, 'store'])
            ->middleware($passkeyConfirmMiddleware)
            ->name('passkey.confirm');

        Route::get('/user/passkeys/options', [PasskeyRegistrationController::class, 'index'])
            ->middleware($passkeyManageMiddleware)
            ->name('passkey.registration-options');

        Route::post('/user/passkeys', [PasskeyRegistrationController::class, 'store'])
            ->middleware($passkeyManageMiddleware)
            ->name('passkey.store');

        Route::delete('/user/passkeys/{passkey}', [PasskeyRegistrationController::class, 'destroy'])
            ->middleware($passkeyMiddleware)
            ->name('passkey.destroy');
    }
});
