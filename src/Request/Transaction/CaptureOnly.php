<?php

namespace Academe\AuthorizeNet\Request\Transaction;

/**
 * Transaction used to capture a transaction previously authorized through
 * an external channel.
 */

use Academe\AuthorizeNet\TransactionRequestInterface;
use Academe\AuthorizeNet\Request\Model\Order;
use Academe\AuthorizeNet\PaymentInterface;
use Academe\AuthorizeNet\AmountInterface;
use Academe\AuthorizeNet\AbstractModel;

class CaptureOnly extends AbstractModel implements TransactionRequestInterface
{
    protected $objectName = 'transactionRequest';
    protected $transactionType = 'captureOnlyTransaction';

    protected $employeeId;
    protected $amount;
    protected $payment;
    protected $terminalNumber;
    protected $order;
    protected $surcharge;
    protected $merchantDescriptor;
    protected $tip;

    protected $authCode;

    /**
     * CHECKME: it is not clear if the payment is mandatory, i.e. the
     * CC, track etc. I suspect it is, and will need to be initialized here.
     */
    public function __construct(AmountInterface $amount, $authCode)
    {
        parent::__construct();

        $this->setAmount($amount);
        $this->setAuthCode($authCode);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['transactionType'] = $this->getTransactionType();

        // This value object will be formatted according to its currency.
        $data['amount'] = $this->getAmount();

        $data['payment'] = $this->getPayment();

        if ($terminalNumber = $this->getTerminalNumber()) {
            $data['terminalNumber'] = $terminalNumber;
        }

        $data['authCode'] = $this->getAuthCode();

        if ($employeeId = $this->getEmployeeId()) {
            $data['employeeId'] = $employeeId;
        }

        if ($this->hasOrder()) {
            $order = $this->getOrder();

            // The order needs at least one of the two optional fields.
            if ($order->hasAny()) {
                // If the order becames more complex, we may need to pick out the
                // individual fields we need.

                $data[$order->getObjectName()] = $order;
            }
        }

        if ($surcharge = $this->getSurcharge()) {
            if ($surcharge->hasAny()) {
                $data['surcharge'] = $surcharge;
            }
        }

        if ($merchantDescriptor = $this->getMerchantDescriptor()) {
            $data['merchantDescriptor'] = $merchantDescriptor;
        }

        if ($tip = $this->getTip()) {
            $data['tip'] = $tip;
        }

        return $data;
    }

    protected function setAmount(AmountInterface $value)
    {
        $this->amount = $value;
    }

    protected function setPayment(PaymentInterface $value)
    {
        $this->payment = $value;
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

    protected function setEmployeeId($value)
    {
        $this->employeeId = $value;
    }

    protected function setTerminalNumber($value)
    {
        $this->terminalNumber = $value;
    }

    protected function setSurcharge($value)
    {
        $this->surcharge = $value;
    }

    protected function setMerchantDescriptor($value)
    {
        $this->merchantDescriptor = $value;
    }

    protected function setTip(AmountInterface $value)
    {
        $this->tip = $value;
    }
}
