<?php

namespace Academe\AuthorizeNet\ServerRequest\Payload;

/**
 *
 */

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Exception\ClientException;

class PaymentTest extends TestCase
{
    public function setUp()
    {
    }

    public function testSimple()
    {
        $data = json_decode('{
            "responseCode": 1,
            "authCode": "LZ6I19",
            "avsResponse": "Y",
            "authAmount": 45.00,
            "entityName": "transaction",
            "id": "60020981676"
        }', true);

        $payload = new Payment($data);

        $this->assertSame('transaction', $payload->entityName);
        $this->assertSame('60020981676', $payload->id);
    }
}
