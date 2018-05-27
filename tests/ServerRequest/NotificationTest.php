<?php

namespace Academe\AuthorizeNet\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Exception\ClientException;
use Academe\AuthorizeNet\Response\Model\TransactionResponse;
use Academe\AuthorizeNet\ServerRequest\Payload\Payment;
use Academe\AuthorizeNet\ServerRequest\Payload\PaymentProfile;
use Academe\AuthorizeNet\ServerRequest\Payload\Fraud;

class NotificationTest extends TestCase
{
    public function setUp()
    {
    }

    public function testCreatePayment()
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

    public function testCreateFraud()
    {
        $data = json_decode('{
            "notificationId": "26024a6c-3b78-4d18-8ce7-53dd020aee72",
            "eventType": "net.authorize.payment.fraud.held",
            "eventDate": "2016-10-24T17:47:39.7740424Z",
            "webhookId": "71400fce-085f-46fe-9758-8311ca01d33e",
            "payload": {
              "responseCode": 4,
              "authCode": "24904A",
              "avsResponse": "Y",
              "authAmount": 50000.0,
              "fraudList": [
                {
                  "fraudFilter": "AmountFilter",
                  "fraudAction": "authAndHold"
                }
              ],
              "entityName": "transaction",
              "id": "2154067719"
            }
        }', true);

        $notification = new Notification($data);

        $this->assertInstanceOf(Fraud::class, $notification->payload);

        $this->assertArraySubset($data, $notification->toData(true));
    }

    public function testCreatePaymentProfile()
    {
        $data = json_decode('{
            "notificationId": "7201C905-B01E-4622-B807-AC2B646A3815",
            "eventType": "net.authorize.customer.paymentProfile.created",
            "eventDate": "2016-03-23T06:19:09.5297562Z",
            "webhookId": "6239A0BE-D8F4-4A33-8FAD-901C02EED51F",
            "payload": {
                "customerProfileId": 394,
                "entityName": "customerPaymentProfile",
                "id": "694",
                "customerType": "business"
            }
        }', true);

        $notification = new Notification($data);

        $this->assertInstanceOf(PaymentProfile::class, $notification->payload);

        $this->assertArraySubset($data, $notification->toData(true));
    }
}
