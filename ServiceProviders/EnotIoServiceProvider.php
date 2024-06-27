<?php

namespace Flute\Modules\EnotIo\ServiceProviders;

use Flute\Core\Payments\Events\RegisterPaymentFactoriesEvent;
use Flute\Core\Support\ModuleServiceProvider;
use Flute\Modules\EnotIo\Listeners\PaymentListener;

class EnotIoServiceProvider extends ModuleServiceProvider
{
    public array $extensions = [];

    public function boot(\DI\Container $container): void
    {
        events()->addDeferredListener(RegisterPaymentFactoriesEvent::NAME, [PaymentListener::class, 'registerEnotIo']);
    }

    public function register(\DI\Container $container): void
    {
    }
}