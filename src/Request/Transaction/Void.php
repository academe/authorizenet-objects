<?php

namespace Academe\AuthorizeNet\Request\Transaction;

/**
 * A refund is nearly identical to an original payment, so we will
 * base this class on the payment (AuthCapture), with some alterations.
 *
 * Void is pretty simplie: void the transaction and go. There is no other context.
 */

use Academe\AuthorizeNet\TransactionRequestInterface;
use Academe\AuthorizeNet\AbstractModel;

class Void extends AbstractModel implements TransactionRequestInterface
{
    protected $objectName = 'transactionRequest';
    protected $transactionType = 'voidTransaction';

    protected $refTransId;

    /**
     * 
     */
    public function __construct($refTransId)
    {
        parent::__construct();

        $this->setRefTransId($refTransId);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['transactionType'] = $this->getTransactionType();

        $data['refTransId'] = $this->getRefTransId();

        return $data;
    }

    /**
     * @param $value string Reference transaction ID
     */
    protected function setRefTransId($value)
    {
        $this->refTransId = $value;
    }
}
