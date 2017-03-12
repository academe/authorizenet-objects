<?php

namespace Academe\AuthorizeNetObjects\Payment;

/**
 * 
 */

use Academe\AuthorizeNetObjects\PaymentInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class OpaqueData extends AbstractModel implements PaymentInterface
{
    protected $dataDescriptor;
    protected $dataValue;

    public function __construct($dataDescriptor, $dataValue)
    {
        parent::__construct();

        $this->setDataDescriptor($dataDescriptor);
        $this->setDataValue($dataValue);
    }

    public function jsonSerialize()
    {
        $data = [
            'dataDescriptor' => $this->getDataDescriptor(),
            'dataValue' => $this->getDataValue(),
        ];

        return $data;
    }

    // TODO: these setters can include validation.

    protected function setDataDescriptor($value)
    {
        $this->dataDescriptor = $value;
    }

    protected function setDataValue($value)
    {
        $this->dataValue = $value;
    }
}
