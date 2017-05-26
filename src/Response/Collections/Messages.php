<?php

namespace Academe\AuthorizeNet\Response\Collections;

/**
 * Collection of response messages, with an overall result code.
 */

use Academe\AuthorizeNet\Request\Model\HostedPaymentSetting;
use Academe\AuthorizeNet\Response\Model\Message;
use Academe\AuthorizeNet\AbstractCollection;

class Messages extends AbstractCollection
{
    /**
     * The overall response result code.
     */
    protected $resultCode;

    public function __construct($data)
    {
        // FIXME: use a helper to get the values of the elements or properties.
        // There is one top-level result code...
        $this->resultCode = $data['resultCode'];

        // ...and an array of message records.
        foreach ($data['message'] as $message_data) {
            $this->push(new Message($message_data));
        }
    }

    protected function hasExpectedStrictType($item)
    {
        // Make sure the item is the correct type, and is not empty.
        return $item instanceof Message;
    }
}
