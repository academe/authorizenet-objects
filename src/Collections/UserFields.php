<?php

namespace Academe\AuthorizeNetObjects\Collections;

/**
 * 
 */

use Academe\AuthorizeNetObjects\AbstractCollection;
use Academe\AuthorizeNetObjects\Request\Model\UserField;

class UserFields extends AbstractCollection
{
    protected function hasExpectedStrictType($item)
    {
        // Make sure the item is the correct type, and is not empty.
        return $item instanceof UserField && $item->hasAny();
    }

    /**
     * The array of userFields needs to be wrapped by a single userField element.
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        return ['userField' => $data];
    }
}
