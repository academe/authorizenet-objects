<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 *
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\AmountInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class UserField extends AbstractModel implements TransactionRequestInterface
{
    protected $name;
    protected $value;

    public function __construct(
        $name,
        $value
    ) {
        parent::__construct();

        $this->setName($name);
        $this->setValue($value);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['name'] = $this->getName();
        $data['value'] = $this->getValue();

        return $data;
    }

    public function hasAny()
    {
        return true;
    }

    protected function setName($value)
    {
        $this->name = $value;
    }

    protected function setValue($value)
    {
        $this->value = $value;
    }
}
