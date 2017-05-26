<?php

namespace Academe\AuthorizeNet\Response;

/**
 * Generic response class that any response data can be thrown into.
 */

use Academe\AuthorizeNet\Response\Collections\Messages;
use Academe\AuthorizeNet\Response\Model\TransactionResponse;

class Response // extends AbstractResponse
{
    use HasDataTrait;

    protected $messages;
    protected $transactionResponse;

    /**
     * Feed in the raw data structure (array or nested objects).
     */
    public function __construct($data)
    {
        $this->setData($data);

        if ($messages = $this->getDataValue('messages')) {
            $this->messages = new Messages($messages);
        }

        if ($transactionResponse = $this->getDataValue('transactionResponse')) {
            $this->transactionResponse = new TransactionResponse($transactionResponse);
        }
    }
}
