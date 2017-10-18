<?php

namespace Academe\AuthorizeNet\Request\Model;

/**
 *
 */

use Academe\AuthorizeNet\TransactionRequestInterface;
use Academe\AuthorizeNet\AmountInterface;
use Academe\AuthorizeNet\AbstractModel;

class HostedPaymentSetting extends AbstractModel
{
    /**
     * @var Names of settings for the hosted payment page, with a common prefix removed
     */
    const SETTING_NAME_RETURN_OPTIONS           = 'ReturnOptions';
    const SETTING_NAME_BUTTON_OPTIONS           = 'ButtonOptions';
    const SETTING_NAME_STYLE_OPTIONS            = 'StyleOptions';
    const SETTING_NAME_PAYMENT_OPTIONS          = 'PaymentOptions';
    const SETTING_NAME_SECURITY_OPTIONS         = 'SecurityOptions';
    const SETTING_NAME_SHIPPING_ADDRESS_OPTIONS = 'ShippingAddressOptions';
    const SETTING_NAME_BILLING_ADDRESS_OPTIONS  = 'BillingAddressOptions';
    const SETTING_NAME_CUSTOMER_OPTIONS         = 'CustomerOptions';
    const SETTING_NAME_ORDER_OPTIONS            = 'OrderOptions';
    const SETTING_NAME_FRAME_COMMUNICATOR_URL   = 'FrameCommunicatorUrl';

    /**
     * @var Name of the setting with a common prefix removed
     */
    protected $settingName;

    /**
     * Each value is a string containing JSON encoded data.
     * Examples and a specification can be found here:
     * https://developer.authorize.net/api/reference/features/accept_hosted.html
     */
    protected $settingValue;

    /**
     * @var The prefix each setting name will have when sent to the gateway.
     */
    protected $optionNamePrefix = 'hostedPayment';

    /**
     * @param string $settingName Name of the setting, one of static::SETTING_NAME_*
     * @param mixed $settingValue Value as array or JSON-encoded string
     */
    public function __construct(
        $settingName,
        $settingValue
    ) {
        parent::__construct();

        $this->setSettingName($settingName);
        $this->setSettingValue($settingValue);
    }

    /**
     * Serialize this object.
     * For convenience, if the value is not already a string, it will
     * be separately serialized to JSON as required by the API, so it
     * is effectively double-encoded.
     */
    public function jsonSerialize()
    {
        $data = [];

        $data['settingName'] = $this->optionNamePrefix . $this->getSettingName();

        $value = $this->getSettingValue();

        if (! is_string($value)) {
            $value = json_encode($value);
        }

        $data['settingValue'] = $value;

        return $data;
    }

    public function hasAny()
    {
        return true;
    }

    protected function setSettingName($value)
    {
        // If the prefix is present, then remove it for now.
        if (strpos($value, $this->optionNamePrefix) === 0) {
            $value = substr($value, strlen($this->optionNamePrefix));
        }

        // Support camelCase for those that may want to use it.
        $value = ucfirst($value);

        $this->assertValueSettingName($value);
        $this->settingName = $value;
    }

    protected function setSettingValue($value)
    {
        $this->settingValue = $value;
    }
}
