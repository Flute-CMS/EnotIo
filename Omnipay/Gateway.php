<?php

namespace Omnipay\Enotio;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Enotio\Message\NotificationRequest;
use Omnipay\Enotio\Message\PurchaseRequest;
use Omnipay\Enotio\Traits\Parametrable;

class Gateway extends AbstractGateway
{
    use Parametrable;

    public function getName()
    {
        return 'Enotio';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'secretKey'  => '',
            'secretKey2' => '',
        ];
    }

    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Enotio\Message\NotificationRequest
     */
    public function acceptNotification(array $options = [])
    {
        return $this->createRequest(NotificationRequest::class, $options);
    }

}
