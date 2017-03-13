<?php

namespace Academe\AuthorizeNetObjects\Request;

/**
 * 
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\Auth\MerchantAuthentication;
use Academe\AuthorizeNetObjects\AbstractModel;

class CreateTransaction extends AbstractModel
{
    protected $objectNameSuffix = 'Request';

    protected $merchantAuthentication;
    protected $employeeId;
    protected $refId;
    protected $transactionRequest;

    public function __construct(MerchantAuthentication $merchantAuthentication, TransactionRequestInterface $transactionRequest)
    {
        parent::__construct();

        $this->setMerchantAuthentication($merchantAuthentication);
        $this->setTransactionRequest($transactionRequest);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data[$this->getMerchantAuthentication()->getObjectName()] = $this->getMerchantAuthentication();

        if ($this->hasEmployeeId()) {
            $data['employeeId'] = $this->getEmployeeId();
        }

        if ($this->hasRefId()) {
            $data['refId'] = $this->getRefId();
        }

        $data[$this->getTransactionRequest()->getObjectName()] = $this->transactionRequest;

        return [
            $this->getObjectName() => $data,
        ];
    }

    // TODO: these setters can include validation.

    // Numeric, 4 digits
    protected function setEmployeeId($value)
    {
        $this->employeeId = $value;
    }

    protected function setRefId($value)
    {
        $this->refId = $value;
    }

    protected function setMerchantAuthentication(MerchantAuthentication $value)
    {
        $this->merchantAuthentication = $value;
    }

    protected function setTransactionRequest(TransactionRequestInterface $value)
    {
        $this->transactionRequest = $value;
    }
}
