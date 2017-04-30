<?php

namespace Academe\AuthorizeNetObjects\Request;

/**
 * 
 */

use Academe\AuthorizeNetObjects\Auth\MerchantAuthentication;
use Academe\AuthorizeNetObjects\AbstractModel;
use Academe\AuthorizeNetObjects\Request\Model\CustomerProfile;

class CreateCustomerProfile extends AbstractRequest
{
    protected $customerProfile;
    protected $refId;

    public function __construct(
        MerchantAuthentication $merchantAuthentication,
        CustomerProfile $customerProfile // TBC
    ) {
        parent::__construct($merchantAuthentication);

        $this->setCustomerProfile($customerProfile);
    }

    protected function setCustomerProfile($value)
    {
        $this->customerProfile = $value;
    }

    protected function setRefId($value)
    {
        $this->refId = $value;
    }
}
