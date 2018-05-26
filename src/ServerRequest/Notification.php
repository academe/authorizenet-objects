<?php

namespace Academe\AuthorizeNet\ServerRequest;

/**
 * The notification message sent by a webhook.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractModel;
use Academe\AuthorizeNet\ServerRequest\AbstractPayload;
use Academe\AuthorizeNet\ServerRequest\Payload\Payment;
use Academe\AuthorizeNet\ServerRequest\Payload\Fraud;

class Notification extends AbstractModel
{
    use HasDataTrait;

    /**
     * The event name prefix indicates the payload type.
     * Note that some prefixes are subsets of others, so be
     * careful what order they are checked.
     */
    const EVENT_PREFIX_FRAUD            = 'net.authorize.payment.fraud';
    const EVENT_PREFIX_PAYMENT          = 'net.authorize.payment';
    const EVENT_PREFIX_PAYMENT_PROFILE  = 'net.authorize.customer.paymentProfile';
    const EVENT_PREFIX_SUBSCRIPTION     = 'net.authorize.customer.subscription';
    const EVENT_PREFIX_CUSTOMER         = 'net.authorize.customer';

    protected $notificationId;
    protected $eventType;
    protected $eventDate;
    protected $webhookId;
    protected $payload;

    // Fetching past notifications returns the deliveryStatus,
    // racking whether the merchant site has received this
    // notification. Also the retryLog.
    // The past notifications do not include the original payload,
    // unless the delivery status shows it has failed to be delivered.
    protected $deliveryStatus; // Failed, Delivered and ??? (maybe not visible until one or the other)
    protected $retryLog;

    /**
     * Feed in the raw data structure (array or nested objects).
     */
    public function __construct($data)
    {
        $this->setData($data);

        $this->setNotificationId($this->getDataValue('notificationId'));
        $this->setEventType($this->getDataValue('eventType'));
        $this->setEventDate($this->getDataValue('eventDate'));
        $this->setWebhookId($this->getDataValue('webhookId'));

        // TODO: retryLog (collection needed)

        if ($payload = $this->getDataValue('payload')) {
            if (strpos($this->eventType, static::EVENT_PREFIX_FRAUD) === 0) {
                $this->setPayload(new Fraud($payload));
            } elseif (strpos($this->eventType, static::EVENT_PREFIX_PAYMENT) === 0) {
                $this->setPayload(new Payment($payload));
            }
        }
    }

    public function jsonSerialize()
    {
        $data = [
            'notificationId' => $this->notificationId,
            'eventType' => $this->eventType,
            'eventDate' => $this->eventDate,
            'webhookId' => $this->webhookId,
        ];

        if ($this->payload) {
            $data['payload'] = $this->payload;
        }

        return $data;
    }

    protected function setNotificationId($value)
    {
        $this->notificationId = $value;
    }

    protected function setEventType($value)
    {
        $this->eventType = $value;
    }

    /**
     * Example: 2017-10-22T15:09:49.0609961Z
     */
    protected function setEventDate($value)
    {
        $this->eventDate = $value;
    }

    protected function setWebhookId($value)
    {
        $this->webhookId = $value;
    }

    protected function setPayload(AbstractPayload $value)
    {
        $this->payload = $value;
    }
}
