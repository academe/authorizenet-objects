<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

/**
 *
 */

use Academe\AuthorizeNetObjects\TransactionRequestInterface;
use Academe\AuthorizeNetObjects\AmountInterface;
use Academe\AuthorizeNetObjects\AbstractModel;

class Setting extends AbstractModel implements TransactionRequestInterface
{
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
        $this->settingName = $value;
    }

    protected function setSettingValue($value)
    {
        $this->settingValue = $value;
    }
}
