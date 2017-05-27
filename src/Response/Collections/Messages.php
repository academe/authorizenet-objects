<?php

namespace Academe\AuthorizeNet\Response\Collections;

/**
 * Collection of response messages, with an overall result code.
 */

use Academe\AuthorizeNet\Request\Model\HostedPaymentSetting;
use Academe\AuthorizeNet\Response\Model\Message;
use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractCollection;

class Messages extends AbstractCollection
{
    use HasDataTrait;

    /**
     * The overall response result code.
     */
    protected $resultCode;

    public function __construct($data)
    {
        $this->setData($data);

        // There is one top-level result code...
        $this->setResultCode($this->getDataValue('resultCode'));

        // ...and an array of message records.
        foreach ($this->getDataValue('message') as $message_data) {
            $this->push(new Message($message_data));
        }
    }

    protected function hasExpectedStrictType($item)
    {
        // Make sure the item is the correct type, and is not empty.
        return $item instanceof Message;
    }

    public function setResultCode($value)
    {
        $this->resultCode = $value;
    }
}
