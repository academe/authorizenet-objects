<?php

namespace Academe\AuthorizeNet\Response\Model;

/**
 * Single Response message.
 * This is the top level of the response, not a message you would find
 * within a transacton response.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;

class Message
{
    use HasDataTrait;

    protected $code;
    protected $text;

    public function __construct($data)
    {
        $this->setData($data);

        $this->code = $this->getDataValue('code');
        $this->text = $this->getDataValue('text');
    }
}
