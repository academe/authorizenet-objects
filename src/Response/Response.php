<?php

namespace Academe\AuthorizeNet\Response;

/**
 * Generic response class that any response data can be thrown into.
 */

use Academe\AuthorizeNet\Response\Collections\Messages;
use Academe\AuthorizeNet\Response\Model\TransactionResponse;
use Academe\AuthorizeNet\AbstractModel;

class Response extends AbstractModel
{
    use HasDataTrait;

    protected $refId;
    protected $messages;
    protected $transactionResponse;

    /**
     * Feed in the raw data structure (array or nested objects).
     */
    public function __construct($data)
    {
        $this->setData($data);

        $this->setRefId($this->getDataValue('refId'));

        if ($messages = $this->getDataValue('messages')) {
            $this->setMessages(new Messages($messages));
        }

        if ($transactionResponse = $this->getDataValue('transactionResponse')) {
            $this->setTransactionResponse(new TransactionResponse($transactionResponse));
        }
    }

    public function jsonSerialize()
    {
        $data = [
            'refId' => $this->getRefId(),
            'messages' => $this->getMessages(),
            'transactionResponse' => $this->getTransactionResponse(),
        ];

        return $data;
    }

    protected function setRefId($value)
    {
        $this->refId = $value;
    }

    protected function setMessages(Messages $value)
    {
        $this->messages = $value;
    }

    protected function setTransactionResponse(TransactionResponse $value)
    {
        $this->transactionResponse = $value;
    }
}
