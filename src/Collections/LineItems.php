<?php

namespace Academe\AuthorizeNetObjects\Collections;

/**
 * 
 */

use Academe\AuthorizeNetObjects\AbstractCollection;
use Academe\AuthorizeNetObjects\Request\Model\ListItem;

class LineItems extends AbstractCollection
{
    protected function hasExpectedStrictType($item)
    {
        // Make sure the item is the correct type, and is not empty.
        return $item instanceof ListItem && $item->hasAny();
    }

    /**
     * The array of lineItems needs to be wrapped by a single lineItem element.
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        return ['lineItem' => $data];
    }
}
