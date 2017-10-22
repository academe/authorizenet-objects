<?php

namespace Academe\AuthorizeNet\ServerRequest\Model;

/**
 * The payload detail of a notification sent by a webhook.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractModel;
use Academe\AuthorizeNet\ServerRequest\Model\Payload;

class Payload extends AbstractModel
{
    use HasDataTrait;
}
