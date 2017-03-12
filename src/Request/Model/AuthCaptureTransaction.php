<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 * TODO parameters:
 *
 * - [x] amount to be an object (before doing the extended amount objects)
 * - [x] currency to come from the amount (each account supports just one currency)
 * - [x] profile.createProfile (boolean)
 * - [x] solution.id
 * - [x] order (invoiceNumber, description)
 * - [x] lineItems (collection of lineItem objects)
 * - [x] tax (amount, name, description) "extended amount" type
 * - [x] duty (amount, name, description) "extended amount" type
 * - [x] shipping (amount, name, description) "extended amount" type
 * - [x] taxExempt (boolean)
 * - [x] poNumber
 * - [x] customer (type, id, email + others)
 * - [x] billTo (name, company, address object) NameAddress object, also extended to customer version
 * - [x] shipTo (name, company, address object)
 * - [ ] cardholderAuthentication (authenticationIndicator, cardholderAuthenticationValue)
 * - [x] retail (marketType, deviceType, customerSignature)
 * - [x] transactionSettings (collection of setting name/value pairs
 * - [x] userFields (collection of name/value pairs)
 *
 * shipTo seems to include the originating user's IP address, which is a bit bizarre
 */

use Academe\AuthorizeNetObjects\Request\Model\AbstractExtendedAmount;
use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\Request\Model\NameAddress;
use Academe\AuthorizeNetObjects\Request\Model\Customer;
use Academe\AuthorizeNetObjects\Request\Model\Retail;
use Academe\AuthorizeNetObjects\Request\Model\Order;
use Academe\AuthorizeNetObjects\PaymentInterface;
use Academe\AuthorizeNetObjects\AmountInterface;
use Academe\AuthorizeNetObjects\AbstractModel;
use Academe\AuthorizeNetObjects\Collections\LineItems;
use Academe\AuthorizeNetObjects\Collections\TransactionSettings;
use Academe\AuthorizeNetObjects\Collections\UserFields;

class AuthCaptureTransaction extends AbstractModel implements TransactionRequestInterface
{
    protected $objectName = 'transactionRequest';
    protected $transactionType = 'authCaptureTransaction';

    protected $amount;
    protected $payment;
    protected $createProfile;
    protected $solutionId;
    protected $order;
    protected $lineItems;
    protected $tax;
    protected $duty;
    protected $shipping;
    protected $taxExempt;
    protected $poNumber;
    protected $customer;
    protected $billTo;
    protected $shipTo;
    protected $retail;
    protected $transactionSettings;
    protected $userFields;

    /**
     * FIXME: The amount should be a value object.
     */
    public function __construct(AmountInterface $amount)
    {
        parent::__construct();

        $this->setAmount($amount);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['transactionType'] = $this->getTransactionType();

        // TODO: this value object should be formatted according to the currency.
        $data['amount'] = $this->getAmount();

        if ($this->hasPayment()) {
            $data['payment'] = [
                $this->getPayment()->getObjectName() => $this->getPayment(),
            ];
        }

        // CHECKME: The docs do not give examples of how a boolean should be formatted.
        if ($this->hasCreateProfile()) {
            $data['profile']['createProfile'] = $this->getCreateProfile();
        }

        if ($this->hasSolutionId()) {
            $data['solution']['id'] = $this->getSolutionId();
        }

        if ($this->hasOrder()) {
            $order = $this->getOrder();

            // The order needs at least one of the two optional fields.
            if ($order->hasInvoiceNumber() || $order->hasDescription()) {
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
                $data['duty'] = $customer;
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

        if ($this->hasRetail()) {
            $data['shipTo'] = $this->getRetail();;
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

    protected function setPayment(PaymentInterface $value)
    {
        $this->payment = $value;
    }

    protected function setAmount(AmountInterface $value)
    {
        $this->amount = $value;
    }

    protected function setCreateProfile($value)
    {
        if ($value !== null) {
            $value = (bool)$value;
        }

        $this->createProfile = $value;
    }

    protected function setSolutionId($value)
    {
        $this->solutionId = $value;
    }

    protected function setOrder(Order $value)
    {
        $this->order = $value;
    }

    protected function setLineItems(LineItems $value)
    {
        $this->lineItems = $value;
    }

    protected function setTax(ExtendedAmount $value)
    {
        $this->tax = $value;
    }

    protected function setDuty(ExtendedAmount $value)
    {
        $this->duty = $value;
    }

    protected function setShipping(ExtendedAmount $value)
    {
        $this->shipping = $value;
    }

    protected function setTaxExempt($value)
    {
        if ($value !== null) {
            $value = (bool)$value;
        }

        $this->taxExempt = $value;
    }

    protected function setPoNumber($value)
    {
        $this->poNumber = $value;
    }

    protected function setCustomer(Customer $value)
    {
        $this->customer = $value;
    }

    protected function setBillTo(NameAddress $value)
    {
        $this->billTo = $value;
    }

    protected function setShipTo(NameAddress $value)
    {
        $this->shipTo = $value;
    }

    protected function setRetail(Retail $value)
    {
        $this->retail = $value;
    }

    protected function setTransactionSettings(TransactionSettings $value)
    {
        $this->transactionSettings = $value;
    }

    protected function setUserFields(UserFields $value)
    {
        $this->userFields = $value;
    }
}
