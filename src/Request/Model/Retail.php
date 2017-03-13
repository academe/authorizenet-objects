<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 *
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class Retail extends AbstractModel implements TransactionRequestInterface
{
    const MARKET_TYPE_ECOMMERCE = 0;
    const MARKET_TYPE_MOTO = 1;
    const MARKET_TYPE_RETAIL = 2;

    // Unknown
    const DEVICE_TYPE_UNKNOWN = 1;
    // Unattended Terminal
    const DEVICE_TYPE_UNATTENDED = 2;
    // Self Service Terminal
    const DEVICE_TYPE_SELF_SERVICE = 3;
    // Electronic Cash Register
    const DEVICE_TYPE_CASH_REGISTER = 4;
    // Personal Computer-Based Terminal
    const DEVICE_TYPE_PC = 5;
    // Wireless POS
    const DEVICE_TYPE_WIRELESS_POS = 7;
    // Website
    const DEVICE_TYPE_WEBSITE = 8;
    // Dial Terminal
    const DEVICE_TYPE_DIAL = 9;
    // Virtual Terminal
    const DEVICE_TYPE_VIRTUAL = 10;

    protected $marketType;
    protected $deviceType;
    protected $customerSignature;

    public function __construct(
        $marketType,
        $deviceType,
        $customerSignature = null
    ) {
        parent::__construct();

        $this->setMarketType($marketType);
        $this->setDeviceType($deviceType);
        $this->setCustomerSignature($customerSignature);
    }

    public function jsonSerialize()
    {
        $data = [];

        $data['marketType'] = $this->getMarketType();
        $data['deviceType'] = $this->getDeviceType();

        if ($this->hasCustomerSignature()) {
            $data['customerSignature'] = $this->getCustomerSignature();
        }

        return $data;
    }

    protected function setMarketType($value)
    {
        $market_types = static::constantList('MARKET_TYPE');

        if (isset($value) && ! in_array($value, $market_types)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid value for Market Type. Valid values are: "%s".',
                implode('", "', $market_types)
            ));
        }

        $this->marketType = (int)$value;
    }

    protected function setDeviceType($value)
    {
        $device_types = static::constantList('DEVICE_TYPE');

        if (isset($value) && ! in_array($value, $device_types)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid value for Device Type.  Valid values are: "%s".',
                implode('", "', $device_types)
            ));
        }

        $this->deviceType = (int)$value;
    }

    /**
     * The signature must be PNG formatted data.
     * It will make sense to support supplying a PNG image as a stream.
     * Also some escaping may be required if this data is effectively binary.
     */
    protected function setCustomerSignature($value)
    {
        $this->customerSignature = $value;
    }
}
