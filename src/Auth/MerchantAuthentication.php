<?php

namespace Academe\AuthorizeNetObjects\Auth;

/**
 * TODO: protect this data from var_dump.
 * Also authenticaion methods include:
 *  sessionToken, password, impersonationAuthentication, fingerPrint, clientKey and mobileDeviceId.
 * Whether we need separate objects to support different combinations of mandatory parameters,
 * needs to be looked at.
 */

use Academe\AuthorizeNetObjects\AbstractModel;

class MerchantAuthentication extends AbstractModel
{
    protected $name;
    protected $transactionKey;

    /**
     * string and string
     */
    public function __construct($name, $transactionKey)
    {
        parent::__construct();

        $this->setName($name);
        $this->setTransactionKey($transactionKey);
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'transactionKey' => $this->transactionKey,
        ];
    }

    // TODO: these setters can include validation.

    protected function setName($value)
    {
        $this->name = $value;
    }

    protected function setTransactionKey($value)
    {
        $this->transactionKey = $value;
    }
}
