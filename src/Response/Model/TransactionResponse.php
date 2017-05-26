<?php

namespace Academe\AuthorizeNet\Response\Model;

/**
 * 
 */

use Academe\AuthorizeNet\Response\HasDataTrait;

class TransactionResponse
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
    protected $messages;

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

        $this->responseCode = $this->getDataValue('responseCode');
        $this->rawResponseCode = $this->getDataValue('rawResponseCode');
        $this->authCode = $this->getDataValue('authCode');
        $this->avsResultCode = $this->getDataValue('avsResultCode');
        $this->cvvResultCode = $this->getDataValue('cvvResultCode');

        $this->transId = $this->getDataValue('transId');
        $this->refTransId = $this->getDataValue('refTransId');
        $this->transHash = $this->getDataValue('transHash');

        $this->testRequest = $this->getDataValue('testRequest');

        // etc.
    }
}
