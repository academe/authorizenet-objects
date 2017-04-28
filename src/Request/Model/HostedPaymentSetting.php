<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 *
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\AmountInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class HostedPaymentSetting extends AbstractModel implements TransactionRequestInterface
{
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

    protected $settingName;
    protected $settingValue;

    public function __construct(
        $settingName,
        $settingValue
    ) {
        parent::__construct();

        $this->setSettingName($settingName);
        $this->setSettingValue($settingValue);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['settingName'] = $this->getSettingName();
        $data['settingValue'] = $this->getSettingValue();

        return $data;
    }

    public function hasAny()
    {
        return true;
    }

    protected function setSettingName($value)
    {
        $this->assertValueSettingName($value);
        $this->settingName = $value;
    }

    protected function setSettingValue($value)
    {
        $this->settingValue = $value;
    }
}
