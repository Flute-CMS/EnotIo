<?php

namespace Flute\Modules\EnotIo\Listeners;

class PaymentListener
{
    public static function registerEnotIo()
    {
        app()->getLoader()->addPsr4('Omnipay\\Enotio\\', module_path('EnotIo', 'Omnipay/'));
        app()->getLoader()->register();
    }
}