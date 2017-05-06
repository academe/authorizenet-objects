<?php

namespace Academe\AuthorizeNetObjects\Request;

/**
 * 
 */

use Academe\AuthorizeNetObjects\Auth\MerchantAuthentication;
use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\AbstractModel;
use Academe\AuthorizeNetObjects\Request\Model\Profile;
use Academe\AuthorizeNetObjects\Collections\HostedPaymentSettings;

class GetHostedPaymentPage extends AbstractRequest
{
    protected $refId;
    protected $transactionRequest;
    protected $hostedPaymentSettings;

    public function __construct(
        MerchantAuthentication $merchantAuthentication,
        TransactionRequestInterface $transactionRequest
    ) {
        parent::__construct($merchantAuthentication);

        $this->setTransactionRequest($transactionRequest);
    }

    public function jsonSerialize()
    {
        $data = [];

        // Start with the authentication details.
        $data[$this->getMerchantAuthentication()->getObjectName()] = $this->getMerchantAuthentication();

        if ($this->hasRefId()) {
            $data['refId'] = $this->getRefId();
        }

        // Add the expanded tranasation.
        $data[$this->getTransactionRequest()->getObjectName()] = $this->transactionRequest;

        if ($this->hasHostedPaymentSettings()) {
            $data['hostedPaymentSettings'] = $this->getHostedPaymentSettings();
        }

        return [
            $this->getObjectName() => $data,
        ];
    }

    protected function setRefId($value)
    {
        $this->refId = $value;
    }

    protected function setTransactionRequest(TransactionRequestInterface $value)
    {
        $this->transactionRequest = $value;
    }

    protected function setHostedPaymentSettings(HostedPaymentSettings $value)
    {
        $this->hostedPaymentSettings = $value;
    }
}
