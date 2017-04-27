<?php

namespace Academe\AuthorizeNetObjects\Payment;

/**
 * TODO: protect the data from var_dump
 */

use Academe\AuthorizeNetObjects\PaymentInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class BankAccount extends AbstractModel implements PaymentInterface
{
    const ACCOUNT_TYPE_CHECKING = 'checking';
    const ACCOUNT_TYPE_SAVINGS = 'savings';
    const ACCOUNT_TYPE_BUSINESSCHECKING = 'businessChecking';

    const ECHECK_TYPE_PPD = 'PPD';
    const ECHECK_TYPE_WEB = 'WEB';
    const ECHECK_TYPE_CCD = 'CCD';
    const ECHECK_TYPE_TEL = 'TEL';
    const ECHECK_TYPE_ARC = 'ARC';
    const ECHECK_TYPE_BOC = 'BOC';

    protected $accountType;
    protected $accountNumber;
    protected $routingNumber;
    // 22-Character Maximum
    protected $nameOnAccount;
    protected $echeckType;
    protected $bankName;
    // required when echeckType is ARC or BOC
    protected $checkNumber;

    public function __construct()
    {
        parent::__construct();
    }

    public function jsonSerialize()
    {
        $data = [];

        if ($this->hasAccountType()) {
            $data['accountType'] = $this->getAccountType();
        }

        if ($this->hasAccountNumber()) {
            $data['accountNumber'] = $this->getAccountNumber();
        }

        if ($this->hasRoutingNumber()) {
            $data['routingNumber'] = $this->getRoutingNumber();
        }

        if ($this->hasNameOnAccount()) {
            $data['nameOnAccount'] = $this->getNameOnAccount();
        }

        if ($this->hasEcheckType()) {
            $data['echeckType'] = $this->getEcheckType();
        }

        if ($this->hasBankName()) {
            $data['bankName'] = $this->getBankName();
        }

        if ($this->hasCheckNumber()) {
            $data['checkNumber'] = $this->getCheckNumber();
        }

        return $data;
    }

    /**
     * The account number with all but the last four digits masked.
     */

    public function getAccountNumberMasked()
    {
        return str_repeat('X', strlen($this->getAccountNumber()) - 4)
            . substr($this->getAccountNumber(), -4);
    }

    /**
     * The routing number with all but the last four digits masked.
     */

    public function getRoutingNumberMasked()
    {
        return str_repeat('X', strlen($this->getRoutingNumber()) - 4)
            . substr($this->getRoutingNumber(), -4);
    }

    // TODO: these setters can include validation.

    protected function setAccountType($value)
    {
        $this->assertAccountType($value);
        $this->accountType = $value;
    }

    protected function setAccountNumber($value)
    {
        $this->accountNumber = $value;
    }

    protected function setRoutingNumber($value)
    {
        $this->routingNumber = $value;
    }

    protected function setNameOnAccount($value)
    {
        $this->nameOnAccount = $value;
    }

    protected function setEcheckType($value)
    {
        $this->assertValueEcheckType($value);
        $this->echeckType = $value;
    }

    protected function setCheckNumber($value)
    {
        $this->checkNumber = $value;
    }
}
