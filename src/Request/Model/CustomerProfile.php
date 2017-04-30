<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 * SOme of the results of this object are retuned in JSON as a sting
 * containng a CSV list of lists. Ouch.
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class CustomerProfile extends AbstractModel
{
    protected $merchantCustomerId;
    protected $description;
    protected $email;
    // List of profiles.
    protected $paymentProfiles;

    public function __construct(
    ) {
        parent::__construct();
    }

    // Up to 20 characters.
    // Required only when no description and email supplied.
    protected function setMerchantCustomerId($value)
    {
        $this->merchantCustomerId = $value;
    }

    // Up to 255 characters.
    protected function setDescription($value)
    {
        $this->description = $value;
    }

    // Up to 255 characters.
    protected function setEmail($value)
    {
        $this->email = $value;
    }

    // The documentation examples is not consistent with this item
    // being a list of payment profiles, so some experiments are needed.
    // It is likely this will be a Collections\PaymentProfiles object.
    protected function setPaymentProfiles(TBC $value)
    {
        $this->paymentProfiles = $value;
    }
}
