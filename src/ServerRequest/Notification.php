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

        if ($payload = $this->getDataValue('payload')) {
            $this->setPayload(new Payload($payload));
        }
    }
}
