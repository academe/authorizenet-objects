<?php

namespace Academe\AuthorizeNet\Response;

/**
 * Generic response class that any response data can be thrown into.
 *
 * TODO: fields:
 * [ ] clientId
 */

use Academe\AuthorizeNet\Response\Collections\Messages;
use Academe\AuthorizeNet\Response\Model\TransactionResponse;
use Academe\AuthorizeNet\Response\Model\Transaction;
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
    protected $transaction;
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

        // Messages should always be at the top level.
        if ($messages = $this->getDataValue('messages')) {
            $this->setMessages(new Messages($messages));
        }

        // Response to creating an authorisation (authOnly), purchase (authCapture)
        // or capture (priorAuthCapture).
        if ($transactionResponse = $this->getDataValue('transactionResponse')) {
            $this->setTransactionResponse(new TransactionResponse($transactionResponse));
        }

        if ($transaction = $this->getDataValue('transaction')) {
            $this->setTransactionResponse(new Transaction($transaction));
        }

        // Response to the Hosted Payment Page Request.
        if ($token = $this->getDataValue('token')) {
            $this->setToken($token);
        }
    }

    /**
     * Note this does not attempt to rebuild the response data in its
     * original form, but instead aims to collect all the data in the
     * class structure for logging.
     */
    public function jsonSerialize()
    {
        $data = [
            'refId' => $this->getRefId(),
            'resultCode' => $this->getResultCode(),
        ];

        if ($messages = $this->getMessages()) {
            $data['messages'] = $messages;
        }

        if ($transaction = $this->getTransactionResponse()) {
            $data['transaction'] = $transaction;
        }

        if ($token = $this->getToken()) {
            $data['token'] = $token;
        }

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

    protected function setTransaction(TransactionResponse $value)
    {
        $this->transaction = $value;
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
