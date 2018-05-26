<?php

namespace Academe\AuthorizeNet\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Exception\ClientException;
use Academe\AuthorizeNet\Response\Model\TransactionResponse;
use Academe\AuthorizeNet\ServerRequest\Payload\Payment;

class NotificationTest extends TestCase
{
    public function setUp()
    {
    }

    public function testCreate()
    {
        $data = json_decode('{
            "notificationId": "d0e8e7fe-c3e7-4add-a480-27bc5ce28a18",
            "eventType": "net.authorize.payment.authcapture.created",
            "eventDate": "2017-03-29T20:48:02.0080095Z",
            "webhookId": "63d6fea2-aa13-4b1d-a204-f5fbc15942b7",
            "payload": {
                "responseCode": 1,
                "authCode": "LZ6I19",
                "avsResponse": "Y",
                "authAmount": 45.00,
                "entityName": "transaction",
                "id": "60020981676"
            }
        }', true);

        $notification = new Notification($data);

        $this->assertSame('d0e8e7fe-c3e7-4add-a480-27bc5ce28a18', $notification->notificationId);
        $this->assertSame('net.authorize.payment.authcapture.created', $notification->eventType);
        $this->assertSame('2017-03-29T20:48:02.0080095Z', $notification->eventDate);
        $this->assertSame('63d6fea2-aa13-4b1d-a204-f5fbc15942b7', $notification->webhookId);

        $this->assertInstanceOf(Payment::class, $notification->payload);

        $this->assertArraySubset($data, $notification->toData(true));
    }
}
