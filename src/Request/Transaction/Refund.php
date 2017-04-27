<?php

namespace Academe\AuthorizeNetObjects\Request\Transaction;

/**
 * A refund is nearly identical to an original payment, so we will
 * base this class on the payment (AuthCapture), with some alterations.
 *
 * A refund can only be provided after the transaction has been settled,
 * which can take up to 24 hours. Until that point, use void to void the
 * transaction before it is settled..
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\Payment\BankAccount;
use Academe\AuthorizeNetObjects\Payment\CreditCard;
use Academe\AuthorizeNetObjects\AmountInterface;

class Refund extends AuthCapture implements TransactionRequestInterface
{
    protected $objectName = 'transactionRequest';
    protected $transactionType = 'refundTransaction';

    protected $refTransId;

    /**
     * The amount to refund and the original transaction reference ID are required..
     */
    public function __construct(AmountInterface $amount, $refTransId)
    {
        parent::__construct($amount);

        //$this->setAmount($amount);
        $this->setRefTransId($refTransId);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['transactionType'] = $this->getTransactionType();

        // This value object will be formatted according to its currency.
        $data['amount'] = $this->getAmount();

        // The currencyCode is optional, but serves as an extra check that we are sending
        // the correct currency to the account. Each account will support just one
        // currency at present, so this also offers some future-proofing.
        $data['currencyCode'] = $this->getAmount()->getCurrencyCode();

        if ($this->hasPayment()) {
            // For a refund, only partial payment method details are sent.
            // This is dependant on the payment method (CC, Bank etc).
            // CHECKME: it does not appear that opaqueData is supported for refunds.

            $payment = $this->getPayment();

            if ($payment instanceof CreditCard) {
                // The documentation lists the expirationDate as "optional for card present",
                // which implies there is something missing here (card present will include
                // one of the tracks, but they aren't in the spec).

                $data['payment'] = [
                    'creditCard' => [
                        'cardNumber' => $payment->getLastFourDigits(),
                        'expirationDate' => 'XXXX',
                    ]
                ];
            }

            if ($payment instanceof BankAccount) {
                // The masked account number will have all digits but the last four replaced
                // with an "X".

                $data['payment'] = [
                    'bankAccount' => [
                        'accountNumber' => $payment->getAccountNumberMasked(),
                    ]
                ];
            }
        }

        $data['refTransId'] = $this->getRefTransId();

        if ($this->hasOrder()) {
            $order = $this->getOrder();

            // The order needs at least one of the two optional fields.
            if ($order->hasAny()) {
                // If the order becames more complex, we may need to pick out the
                // individual fields we need.

                $data[$order->getObjectName()] = $order;
            }
        }

        if ($this->hasLineItems()) {
            $lineItems = $this->getLineItems();

            if (count($lineItems)) {
                $data[$lineItems->getObjectName()] = $lineItems;
            }
        }

        if ($this->hasTax()) {
            $tax = $this->getTax();

            if ($tax->hasAny()) {
                $data['tax'] = $tax;
            }
        }

        if ($this->hasDuty()) {
            $duty = $this->getDuty();

            if ($duty->hasAny()) {
                $data['duty'] = $duty;
            }
        }

        if ($this->hasShipping()) {
            $shipping = $this->getShipping();

            if ($shipping->hasAny()) {
                $data['shipping'] = $shipping;
            }
        }

        if ($this->hasTaxExempt()) {
            $data['taxExempt'] = $this->getTaxExempt();
        }

        if ($this->hasPoNumber()) {
            $data['poNumber'] = $this->getPoNumber();
        }

        if ($this->hasCustomer()) {
            $customer = $this->getCustomer();

            if ($customer->hasAny()) {
                $data['customer'] = $customer;
            }
        }

        if ($this->hasBillTo()) {
            $billTo = $this->getBillTo();

            if ($billTo->hasAny()) {
                $data['billTo'] = $billTo;
            }
        }

        if ($this->hasShipTo()) {
            $shipTo = $this->getShipTo();

            if ($shipTo->hasAny()) {
                $data['shipTo'] = $shipTo;
            }
        }

        if ($this->hasCustomerIP()) {
            $data['customerIP'] = $this->getCustomerIP();;
        }

        if ($this->hasTransactionSettings()) {
            $transactionSettings = $this->getTransactionSettings();

            if (count($transactionSettings)) {
                $data[$transactionSettings->getObjectName()] = $transactionSettings;
            }
        }

        if ($this->hasUserFields()) {
            $userFields = $this->getUserFields();

            if (count($userFields)) {
                $data[$userFields->getObjectName()] = $userFields;
            }
        }

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
