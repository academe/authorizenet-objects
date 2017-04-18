<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 * Transaction used to capture a previously authorized transaction.
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\Request\Model\Order;
use Academe\AuthorizeNetObjects\AmountInterface;

class CaptureOnlyTransaction extends AbstractModel implements TransactionRequestInterface
{
    protected $objectName = 'transactionRequest';
    protected $transactionType = 'captureOnlyTransaction';

    protected $amount;
    protected $authCode;
    protected $order;

    /**
     * Identical to PriorAuthCaptureTransaction except for a field name change (authCode
     * instead of refTransId).
     */
    public function __construct(AmountInterface $amount, $authCode)
    {
        parent::__construct();

        $this->setAmount($amount);
        $this->setRefTransId($authCode);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['transactionType'] = $this->getTransactionType();

        // This value object will be formatted according to its currency.
        $data['amount'] = $this->getAmount();

        $data['authCode'] = $this->getAuthCode();

        if ($this->hasOrder()) {
            $order = $this->getOrder();

            // The order needs at least one of the two optional fields.
            if ($order->hasAny()) {
                // If the order becames more complex, we may need to pick out the
                // individual fields we need.

                $data[$order->getObjectName()] = $order;
            }
        }

        return $data;
    }

    protected function setAmount(AmountInterface $value)
    {
        $this->amount = $value;
    }

    protected function setOrder(Order $value)
    {
        $this->order = $value;
    }

    /**
     * authCode string
     */
    protected function setAuthCode($value)
    {
        $this->authCode = $value;
    }
}
