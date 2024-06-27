<?php

namespace Omnipay\Enotio\Message;

use Omnipay\Common\Message\AbstractResponse;

class NotificationResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->request->isValid();
    }

    public function getMessage()
    {
        return $this->request->getMessage();
    }

    public function getTransactionReference()
    {
        return $this->request->getTransactionReference();
    }

    public function getTransactionStatus()
    {
        return $this->request->getTransactionStatus();
    }
}
