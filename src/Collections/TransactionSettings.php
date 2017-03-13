<?php

namespace Academe\AuthorizeNetObjects\Collections;

/**
 * 
 */

use Academe\AuthorizeNetObjects\AbstractCollection;
use Academe\AuthorizeNetObjects\Request\Model\Setting;

class TransactionSettings extends AbstractCollection
{
    protected function hasExpectedStrictType($item)
    {
        // Make sure the item is the correct type, and is not empty.
        return $item instanceof Setting && $item->hasAny();
    }

    /**
     * The array of transaction settings needs to be wrapped by a single setting element.
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        return ['setting' => $data];
    }
}
