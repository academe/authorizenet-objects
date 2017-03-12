<?php

namespace Academe\AuthorizeNetObjects\Payment;

/**
 * TODO: protect the data from var_dump
 */

use Academe\AuthorizeNetObjects\PaymentInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class CreditCard extends AbstractModel implements PaymentInterface
{
    protected $cardNumber;
    protected $expirationDate;
    protected $cardCode;

    public function __construct($cardNumber, $expirationDate, $cardCode = null)
    {
        parent::__construct();

        $this->setCardNumber($cardNumber);
        $this->setExpirationDate($expirationDate);
        $this->setCardCode($cardCode);
    }

    public function jsonSerialize()
    {
        $data = [
            'cardNumber' => $this->getCardNumber(),
            'expirationDate' => $this->getExpirationDate(),
        ];

        if ($this->hasCardCode()) {
            $data['cardCode'] = $this->getCardCode();
        }

        return $data;
    }

    // TODO: these setters can include validation.

    protected function setCardNumber($value)
    {
        $this->cardNumber = $value;
    }

    protected function setExpirationDate($value)
    {
        $this->expirationDate = $value;
    }

    protected function setCardCode($value)
    {
        $this->cardCode = $value;
    }
}
