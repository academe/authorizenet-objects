<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 *
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\PaymentInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class Order extends AbstractModel implements TransactionRequestInterface
{
    protected $invoiceNumber;
    protected $description;

    public function __construct($invoiceNumber = null, $description = null)
    {
        parent::__construct();

        $this->setInvoiceNumber($invoiceNumber);
        $this->setDescription($description);
    }

    public function hasAny()
    {
        return $this->hasInvoiceNumber() || $this->hasDescription();
    }

    public function jsonSerialize()
    {
        $data = [];

        if ($this->hasInvoiceNumber()) {
            $data['invoiceNumber'] = $this->getInvoiceNumber();
        }

        if ($this->hasDescription()) {
            $data['description'] = $this->getDescription();
        }

        return $data;
    }

    protected function setInvoiceNumber($value)
    {
        $this->invoiceNumber = $value;
    }

    protected function setDescription($value)
    {
        $this->description = $value;
    }
}
