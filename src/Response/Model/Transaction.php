<?php

namespace Academe\AuthorizeNet\Response\Model;

/**
 *
 */

//use Academe\AuthorizeNet\Response\Collections\TransactionMessages;
//use Academe\AuthorizeNet\Response\Model\PrePaidCard;
//use Academe\AuthorizeNet\Response\HasDataTrait;
//use Academe\AuthorizeNet\Response\Collections\Errors;
//use Academe\AuthorizeNet\AbstractModel;

class Transaction extends TransactionResponse
{
    protected $responseReasonCode;
    protected $responseReasonDescription;
    protected $avsResponse;

    public function __construct($data)
    {
        parent::__construct($data);

        if ($responseReasonCode = $this->getDataValue('responseReasonCode')) {
            $this->setResponseReasonCode($responseReasonCode);
        }

        if ($responseReasonDescription = $this->getDataValue('responseReasonDescription')) {
            $this->setResponseReasonDescription($responseReasonDescription);
        }

        if ($avsResponse = $this->getDataValue('AVSResponse')) {
            $this->setAvsResponse($avsResponse);
        }
    }

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize() ?: [];

        if ($responseReasonCode = $this->getResponseReasonCode()) {
            $data['responseReasonCode'] = $responseReasonCode;
        }

        if ($responseReasonDescription = $this->getResponseReasonDescription()) {
            $data['responseReasonDescription'] = $responseReasonDescription;
        }

        if ($avsResponse = $this->getAvsResponse()) {
            $data['avsResponse'] = $avsResponse;
        }

        return $data;
    }

    protected function setResponseReasonCode($value)
    {
        $this->responseReasonCode = $value;
    }

    protected function setResponseReasonDescription($value)
    {
        $this->responseReasonDescription = $value;
    }

    /**
     * This is avsResultCode in the original transaction creation response.
     * There are a few fields like this that change name between APIs.
     */
    protected function setAvsResponse($value)
    {
        $this->avsResponse = $value;
    }

    /**
     * An alias for the AvsResultCode provides some consistency.
     */
    protected function getAvsResultCode()
    {
        return $this->getAvsResponse();
    }
}
