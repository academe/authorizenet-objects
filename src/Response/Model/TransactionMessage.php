<?php

namespace Academe\AuthorizeNet\Response\Model;

/**
 * Single Transaction Response message.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractModel;

class TransactionMessage extends AbstractModel
{
    use HasDataTrait;

    protected $code;
    protected $description;

    public function __construct($data)
    {
        $this->setData($data);

        $this->setCode($this->getDataValue('code'));
        $this->setDescription($this->getDataValue('description'));
    }

    public function jsonSerialize()
    {
        $data = [
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
        ];

        return $data;
    }

    protected function setCode($value)
    {
        $this->code = $value;
    }

    protected function setDescription($value)
    {
        $this->description = $value;
    }
}
