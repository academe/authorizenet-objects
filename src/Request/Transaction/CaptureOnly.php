<?php

namespace Academe\AuthorizeNet\Request\Transaction;

/**
 * Transaction used to capture a transaction previously authorized through
 * an external channel. All payment details supported by AuthCapturte must
 * be sent through here.
 */

class CaptureOnly extends AuthCapture
{
    protected $objectName = 'transactionRequest';
    protected $transactionType = 'captureOnlyTransaction';

    protected $authCodeSupported = true;

    /*
    protected function setSurcharge($value)
    {
        $this->surcharge = $value;
    }

    protected function setMerchantDescriptor($value)
    {
        $this->merchantDescriptor = $value;
    }

    protected function setTip(AmountInterface $value)
    {
        $this->tip = $value;
    }
    */
}
