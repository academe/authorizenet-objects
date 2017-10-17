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

    /**
     * Top-level response result code values.
     */
    const RESULT_CODE_OK    = 'Ok';
    const RESULT_CODE_ERROR = 'Error';

    protected $refId;
    protected $messages;
    protected $transactionResponse;
    protected $token;

    /**
     * The overall response result code.
     * 'Ok' or 'Error'.
     */
    protected $resultCode;

    /**
     * Feed in the raw data structure (array or nested objects).
     */
    public function __construct($data)
    {
        $this->setData($data);

        $this->setRefId($this->getDataValue('refId'));

        // There is one top-level result code, but dropped one
        // level down into the messages.
        $this->setResultCode($this->getDataValue('messages.resultCode'));

        if ($messages = $this->getDataValue('messages')) {
            $this->setMessages(new Messages($messages));
        }

        if ($transactionResponse = $this->getDataValue('transactionResponse')) {
            $this->setTransactionResponse(new TransactionResponse($transactionResponse));
        }

        if ($token = $this->getDataValue('token')) {
            $this->setToken($token);
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

    public function setResultCode($value)
    {
        $this->resultCode = $value;
    }

    /**
     * The token identifies a Hosted Page.
     */
    public function setToken($value)
    {
        $this->token = $value;
    }
}
