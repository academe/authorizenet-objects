<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 * Some of the results of this object are retuned in JSON as a sting
 * containng a CSV list of lists. Ouch.
 */

use Academe\AuthorizeNetObjects\Request\Model\NameAddress;
use Academe\AuthorizeNetObjects\PaymentInterface;

class PaymentProfile extends AbstractModel
{
    protected $billTo;
    protected $payment;
    protected $defaultPaymentProfile;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setBillTo(NameAddress $value)
    {
        $this->billTo = $value;
    }

    // Allowed payment types: creditCard, bankAccount, or opaqueData
    // Academe\AuthorizeNetObjects\Payment\CreditCard|BankAccount|OpaqueData
    protected function setPayment(PaymentInterface $value)
    {
        $this->payment = $value;
    }

    // When set to true, this field designates the payment profile as the default 
    protected function setDefaultPaymentProfile($value)
    {
        if ($value !== true) {
            $value = false;
        }

        $this->defaultPaymentProfile = $value;
    }
}
