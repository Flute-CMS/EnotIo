<?php

namespace Omnipay\Enotio\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Enotio\Traits\Parametrable;

class NotificationRequest extends AbstractRequest implements NotificationInterface
{
    use Parametrable;

    public const SIGN_ERROR = 'sign_error';

    protected $data;

    public function getData()
    {
        if (isset($this->data)) {
            return $this->data;
        }

        return $this->data = $this->httpRequest->request->all();
    }

    public function getTransactionReference()
    {
        return $this->getIntId();
    }

    public function getTransactionStatus(): string
    {
        return self::STATUS_COMPLETED;
    }

    public function getMessage(): ?string
    {
        if (!$this->isValid()) {
            return self::SIGN_ERROR;
        }

        return null;
    }

    public function isValid(): bool
    {
        return $this->getSign2() === $this->buildSignature();
    }

    private function buildSignature()
    {
        $params = [
            $this->getDataItem('merchant'),
            $this->getDataItem('amount'),
            $this->getSecretKey2(),
            $this->getDataItem('merchant_id'),
        ];

        return hash('md5', implode(":", $params));
    }

    public function getMerchantId()
    {
        return $this->getDataItem('merchant');
    }

    public function getOriginalAmount()
    {
        return $this->getDataItem('amount');
    }

    public function getAmount(): string
    {
        return $this->formatCurrency($this->getDataItem('amount', 0));
    }

    public function getCredited(): string
    {
        return $this->formatCurrency($this->getDataItem('credited', 0));
    }

    public function getTransactionId()
    {
        return $this->getDataItem('merchant_id');
    }

    public function getIntId()
    {
        return $this->getDataItem('intid');
    }

    public function getSign()
    {
        return $this->getDataItem('sign');
    }

    public function getSign2()
    {
        return $this->getDataItem('sign_2');
    }

    public function getCurrency()
    {
        return $this->getDataItem('currency');
    }

    public function getPayerDetails()
    {
        return $this->getDataItem('payer_details');
    }

    public function getCommission()
    {
        return $this->getDataItem('commission');
    }

    public function getCommissionPay()
    {
        return $this->getDataItem('commission_pay');
    }

    public function getCustomField()
    {
        return $this->getDataItem('custom_field');
    }

    protected function getDataItem($name, $default = null)
    {
        $data = $this->getData();

        return $data[$name] ?? $default;
    }

    public function sendData($data)
    {
        return $this->response = new NotificationResponse($this, $data);
    }
}