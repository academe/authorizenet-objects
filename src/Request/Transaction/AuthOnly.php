<?php

namespace Academe\AuthorizeNetObjects\Request\Transaction;

class AuthOnly extends AuthCapture
{
    protected $transactionType = 'authOnlyTransaction';
}
