<?php

namespace Omnipay\Enotio\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Enotio\Traits\Parametrable;

class PurchaseRequest extends AbstractRequest
{
    use Parametrable;

    public function getData()
    {
        $this->validate('merchantId', 'amount', 'transactionId', 'secretKey');

        $data = [
            'm' => $this->getMerchantId(),
            'oa' => $this->getAmount(),
            'o' => $this->getTransactionId(),
        ];

        if ($currency = $this->getCurrency()) {
            $data['cr'] = $currency;
        }

        if ($description = $this->getDescription()) {
            $data['c'] = $description;
        }

        $data['success_url'] = $this->getReturnUrl();
        $data['fail_url'] = $this->getCancelUrl();

        $data['s'] = $this->genSignature();

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function genSignature()
    {
        return hash(
            'md5',
            implode(':', [
                $this->getMerchantId(),
                $this->getAmount(),
                $this->getSecretKey(),
                $this->getTransactionId(),
            ])
        );
    }
}
