<?php

namespace Academe\AuthorizeNet\Response\Model;

/**
 * Single Transaction Response Error.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractModel;

class Error extends AbstractModel
{
    use HasDataTrait;

    protected $erroCode;
    protected $errorText;

    public function __construct($data)
    {
        $this->setData($data);

        $this->setErrorCode($this->getDataValue('errorCode'));
        $this->setErrorText($this->getDataValue('errorText'));
    }

    public function jsonSerialize()
    {
        $data = [
            'errorCode' => $this->getErrorCode(),
            'errorText' => $this->getErrorText(),
        ];

        return $data;
    }

    protected function setErrorCode($value)
    {
        $this->errorCode = $value;
    }

    protected function setErrorText($value)
    {
        $this->errorText = $value;
    }
}
