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
    // Also defined in the Customer class.
    const CUSTOMER_TYPE_INDIVIDUAL = 'individual';
    const CUSTOMER_TYPE_BUSINESS = 'business';

    protected $customerType;
    protected $billTo;
    protected $payment;
    protected $defaultPaymentProfile;

    public function __construct()
    {
        parent::__construct();
    }

    public function jsonSerialize()
    {
        $data = [];

        if ($this->hasCustomerType()) {
            $data['type'] = $this->getCustomerType();
        }

        if ($this->hasBillTo()) {
            $billTo = $this->getBillTo();

            if ($billTo->hasAny()) {
                $data['billTo'] = $billTo;
            }
        }

        if ($this->hasPayment()) {
            $data['payment'] = [
                $this->getPayment()->getObjectName() => $this->getPayment(),
            ];
        }

        if ($this->hasDefaultPaymentProfile()) {
            $defaultPaymentProfile = $this->getDefaultPaymentProfile();

            if ($defaultPaymentProfile->hasAny()) {
                $data['defaultPaymentProfile'] = $defaultPaymentProfile;
            }
        }

        return $data;
    }

    protected function setCustomerType($value)
    {
        $this->assertValueCustomerType($value);
        $this->customerType = $value;
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
