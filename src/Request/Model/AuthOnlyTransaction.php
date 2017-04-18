<?php

namespace Academe\AuthorizeNetObjects\Request\Model;

class AuthOnlyTransaction extends AuthCaptureTransaction
{
    protected $transactionType = 'authOnlyTransaction';
}
