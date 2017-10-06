<?php

namespace Academe\AuthorizeNet\Response\Model;

/**
 *
 */

use Academe\AuthorizeNet\Response\Collections\TransactionMessages;
use Academe\AuthorizeNet\Response\Model\PrePaidCard;
use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\Response\Collections\Errors;
use Academe\AuthorizeNet\AbstractModel;

class TransactionResponse extends AbstractModel
{
    use HasDataTrait;

    /**
     * @property string $responseCode
     */
    protected $responseCode;

    /**
     * @property string $rawResponseCode
     */
    protected $rawResponseCode;

    /**
     * @property string $authCode
     */
    protected $authCode;

    /**
     * @property string $avsResultCode
     */
    protected $avsResultCode;

    /**
     * @property string $cvvResultCode
     */
    protected $cvvResultCode;

    /**
     * @property string $cavvResultCode
     */
    protected $cavvResultCode;

    /**
     * @property string $transId
     */
    protected $transId;

    /**
     * @property string $refTransID
     */
    protected $refTransID;

    /**
     * @property string $transHash
     */
    protected $transHash;

    /**
     * @property string $testRequest
     */
    protected $testRequest;

    /**
     * @property string $accountNumber
     */
    protected $accountNumber;

    /**
     * @property string $entryMode
     */
    protected $entryMode;

    /**
     * @property string $accountType
     */
    protected $accountType;

    /**
     * @property string $splitTenderId
     */
    protected $splitTenderId;

    /**
     * @property
     * TBC class
     * $prePaidCard
     */
    protected $prePaidCard;

    /**
     * @property
     * TBC collection
     * $messages
     */
    //protected $messages;
    protected $transactionMessages;

    /**
     * @property
     * TBC collection
     * $errors
     */
    protected $errors;

    /**
     * @property
     * TBC collection
     * $splitTenderPayments
     */
    protected $splitTenderPayments;

    /**
     * @property TBC collection
     */
    protected $userFields;

    /**
     * @property TBC class $shipTo
     */
    protected $shipTo;

    /**
     * @property
     * TBC collection
     * $secureAcceptance
     */
    protected $secureAcceptance;

    /**
     * @property
     * TBC collection
     * $emvResponse
     */
    protected $emvResponse;

    /**
     * @property string $transHashSha2
     */
    protected $transHashSha2;

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     */
    protected $profile;

    public function __construct($data)
    {
        $this->setData($data);

        $this->setResponseCode($this->getDataValue('responseCode'));
        $this->setRawResponseCode($this->getDataValue('rawResponseCode'));
        $this->setAuthCode($this->getDataValue('authCode'));
        $this->setAvsResultCode($this->getDataValue('avsResultCode'));
        $this->setCvvResultCode($this->getDataValue('cvvResultCode'));

        $this->setTransId($this->getDataValue('transId'));
        $this->setRefTransId($this->getDataValue('refTransId'));
        $this->setTransHash($this->getDataValue('transHash'));

        $this->setTestRequest($this->getDataValue('testRequest'));

        $this->setAccountNumber($this->getDataValue('accountNumber'));
        $this->setEntryMode($this->getDataValue('entryMode'));
        $this->setAccountType($this->getDataValue('accountType'));
        $this->setSplitTenderId($this->getDataValue('splitTenderId'));

        if ($prePaidCard = $this->getDataValue('prePaidCard')) {
            $this->setPrePaidCard(new PrePaidCard($prePaidCard));
        }

        if ($messages = $this->getDataValue('messages')) {
            $this->setTransactionMessages(new TransactionMessages($messages));
        }

        if ($errors = $this->getDataValue('errors')) {
            $this->setErrors(new Errors($errors));
        }

        // etc.
    }

    public function jsonSerialize()
    {
        $data = [
            'responseCode' => $this->getResponseCode(),
            'rawResponseCode' => $this->getRawResponseCode(),
            'authCode' => $this->getAuthCode(),
            'avsResultCode' => $this->getAvsResultCode(),
            'cvvResultCode' => $this->getCvvResultCode(),
            'transId' => $this->getTransId(),
            'refTransId' => $this->getRefTransId(),
            'transHash' => $this->getTransHash(),
            'testRequest' => $this->getTestRequest(),
            'accountNumber' => $this->getAccountNumber(),
            'entryMode' => $this->getEntryMode(),
            'accountType' => $this->getAccountType(),
            'splitTenderId' => $this->getSplitTenderId(),
            'messages' => $this->getTransactionMessages(),
            'errors' => $this->getErrors(),
        ];

        return $data;
    }

    protected function setResponseCode($value)
    {
        $this->responseCode = $value;
    }

    protected function setRawResponseCode($value)
    {
        $this->rawResponseCode = $value;
    }

    protected function setAuthCode($value)
    {
        $this->authCode = $value;
    }

    protected function setAvsResultCode($value)
    {
        $this->avsResultCode = $value;
    }

    protected function setCvvResultCode($value)
    {
        $this->cvvResultCode = $value;
    }

    protected function setTransId($value)
    {
        $this->transId = $value;
    }

    protected function setRefTransId($value)
    {
        $this->refTransId = $value;
    }

    protected function setTransHash($value)
    {
        $this->transHash = $value;
    }

    protected function setTestRequest($value)
    {
        $this->testRequest = $value;
    }

    protected function setAccountNumber($value)
    {
        $this->accountNumber = $value;
    }

    protected function setEntryMode($value)
    {
        $this->entryMode = $value;
    }

    protected function setAccountType($value)
    {
        $this->accountType = $value;
    }

    protected function setSplitTenderId($value)
    {
        $this->splitTenderId = $value;
    }

    protected function setPrePaidCard(PrePaidCard $value)
    {
        $this->prePaidCard = $value;
    }

    protected function setTransactionMessages(TransactionMessages $value)
    {
        $this->transactionMessages = $value;
    }

    protected function setErrors(Errors $value)
    {
        $this->errors = $value;
    }
}
