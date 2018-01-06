<?php

namespace Academe\AuthorizeNet\ServerRequest;

/**
 * The notification message sent by a webhook.
 */

use Academe\AuthorizeNet\Response\HasDataTrait;
use Academe\AuthorizeNet\AbstractModel;
use Academe\AuthorizeNet\ServerRequest\Model\Payload;

class Notification extends AbstractModel
{
    use HasDataTrait;

    protected $notificationId;
    protected $eventType;
    protected $eventDate;
    protected $webhookId;
    protected $payload;

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

        // TODO: retryLog

        if ($payload = $this->getDataValue('payload')) {
            $this->setPayload(new Payload($payload));
        }
    }

    public function jsonSerialize()
    {
        // TODO
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

    protected function setPayload(Payload $value)
    {
        $this->payload = $value;
    }
}
