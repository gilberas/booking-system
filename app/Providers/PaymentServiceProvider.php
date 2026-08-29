<?php

namespace App\Providers;

use App\Repositories\Payment\PaymentRepository;
use App\Services\Payment\Gateways\CashGateway;
use App\Services\Payment\Gateways\CreditCardGateway;
use App\Services\Payment\Gateways\MobileMoneyGateway;
use App\Services\Payment\Gateways\PayPalGateway;
use App\Services\Payment\Gateways\StripeGateway;
use App\Services\Payment\PaymentService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentService::class, function ($app) {
            $service = new PaymentService(
                $app->make(PaymentRepository::class),
                $app->make(DatabaseManager::class),
            );

            $service->registerGateway('stripe', new StripeGateway);
            $service->registerGateway('cash', new CashGateway);
            $service->registerGateway('credit_card', new CreditCardGateway);
            $service->registerGateway('paypal', new PayPalGateway);
            $service->registerGateway('mobile_money', new MobileMoneyGateway);

            return $service;
        });
    }

    public function boot(): void {}
}
