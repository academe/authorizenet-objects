<?php

namespace Academe\AuthorizeNet\Response\Collections;

/**
 * Collection of response messages, with an overall result code.
 */

use Academe\AuthorizeNet\Request\Model\HostedPaymentSetting;
use Academe\AuthorizeNet\Response\Model\TransactionMessage;
use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractCollection;

class TransactionMessages extends AbstractCollection
{
    use HasDataTrait;

    public function __construct($data)
    {
        $this->setData($data);

        foreach ($this->getDataValue('message') as $message_data) {
            $this->push(new TransactionMessage($message_data));
        }
    }

    protected function hasExpectedStrictType($item)
    {
        // Make sure the item is the correct type, and is not empty.
        return $item instanceof TransactionMessage;
    }

    protected function setMessage($value)
    {
        $this->message = $value;
    }
}
