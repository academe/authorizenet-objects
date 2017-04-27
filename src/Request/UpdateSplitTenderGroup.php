<?php

namespace Academe\AuthorizeNetObjects\Request;

/**
 * 
 */

use Academe\AuthorizeNetObjects\Auth\MerchantAuthentication;
use Academe\AuthorizeNetObjects\AbstractModel;

class UpdateSplitTenderGroup extends AbstractModel
{
    const SPLIT_TENDER_STATUS_VOIDED = 'voided';
    const SPLIT_TENDER_STATUS_COMPLETED = 'completed';

    protected $objectNameSuffix = 'Request';

    protected $merchantAuthentication;
    protected $splitTenderId;
    protected $splitTenderStatus;
    protected $refId;

    public function __construct(
        MerchantAuthentication $merchantAuthentication,
        $splitTenderId
    ) {
        parent::__construct();

        $this->setMerchantAuthentication($merchantAuthentication);
        $this->setSplitTenderId($splitTenderId);
    }

    public function jsonSerialize()
    {
        $data = [];

        // Start with the authentication details.
        $data[$this->getMerchantAuthentication()->getObjectName()] = $this->getMerchantAuthentication();

        // Then the optional merchant site reference ID (will be returned in the response,
        // useful for multithreaded applications).
        if ($this->hasRefId()) {
            $data['refId'] = $this->getRefId();
        }

        $data['splitTenderId'] = $this->getSplitTenderId();

        if ($this->hasSplitTenderStatus()) {
            $data['splitTenderStatus'] = $this->getSplitTenderStatus();
        }

        // Wrap it all up in a single element.
        // The JSON structure mimics the XML structure, so all the messages will be
        // in an object with a single property.
        return [
            $this->getObjectName() => $data,
        ];
    }

    protected function setMerchantAuthentication(MerchantAuthentication $value)
    {
        $this->merchantAuthentication = $value;
    }

    // Numeric
    protected function setSplitTenderId($value)
    {
        $this->splitTenderId = $value;
    }

    // Value list
    protected function setSplitTenderStatus($value)
    {
        $this->assertValueSplitTenderStatus($value);
        $this->splitTenderStatus = $value;
    }

    protected function setRefId($value)
    {
        $this->refId = $value;
    }
}
