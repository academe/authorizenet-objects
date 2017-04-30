<?php

namespace Academe\AuthorizeNetObjects\Request;

/**
 * 
 */

use Academe\AuthorizeNetObjects\Auth\MerchantAuthentication;
use Academe\AuthorizeNetObjects\AbstractModel;

abstract class AbstractRequest extends AbstractModel
{
    /**
     * All requests require authentication.
     */
    protected $merchantAuthentication;

    /**
     * The suffix applied to the request name when sending the request.
     */
    protected $objectNameSuffix = 'Request';

    /**
     * Set the authentication object.
     */
    public function __construct(MerchantAuthentication $merchantAuthentication)
    {
        parent::__construct();

        $this->setMerchantAuthentication($merchantAuthentication);
    }

    /**
     * API authentication details.
     */
    protected function setMerchantAuthentication(MerchantAuthentication $value)
    {
        $this->merchantAuthentication = $value;
    }
}