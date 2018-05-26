<?php

namespace Academe\AuthorizeNet\ServerRequest\Payload;

/**
 * The payment notification payload.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractModel;
use Academe\AuthorizeNet\ServerRequest\AbstractPayload;

class Payment extends AbstractPayload
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function jsonSerialize()
    {
        $data = [
            // TODO
        ];

        return $data;
    }
}
