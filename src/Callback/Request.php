<?php

namespace AvpLab\ViberApi\Callback;

use AvpLab\ViberApi\Exception\BadRequestException;
use AvpLab\ViberApi\Message\Message;

class Request
{
    const WEBHOOK = 'webhook';
    const SUBSCRIBED = 'subscribed';
    const UNSUBSCRIBED = 'unsubscribed';
    const CONVERSATION_STARTED = 'conversation_started';
    const DELIVERED = 'delivered';
    const SEEN = 'seen';
    const FAILED = 'failed';
    const MESSAGE = 'message';

    protected $data;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->data = $this->getCallbackData($token);
    }

    /**
     * @param string $token
     * @return array
     * @throws BadRequestException
     */
    private function getCallbackData(string $token)
    {
        $json = file_get_contents('php://input');
        if (empty($json)) {
            throw new BadRequestException();
        }

        $request = json_decode($json);
        if (empty($request)) {
            throw new BadRequestException();
        }

        $signature = $_SERVER['HTTP_X_VIBER_CONTENT_SIGNATURE'] ?? '';
        if (empty($signature)) {
            throw new BadRequestException();
        }

        if (hash_equals($signature, hash_hmac('sha256', $json, $token)) === false) {
            throw new BadRequestException();
        }

        return $request;
    }

    /**
     * @param string $event
     * @return bool
     */
    private function is(string $event)
    {
        return $this->getEvent() === $event;
    }

    /**
     * @param string $type
     * @return bool
     */
    private function isMessageType(string $type)
    {
        return $this->isMessage() && $this->data->message->type ===  $type;
    }

    /**
     * @return bool
     */
    public function isWebhook()
    {
        return $this->is(self::WEBHOOK);
    }

    /**
     * @return bool
     */
    public function isSubscribed()
    {
        return $this->is(self::SUBSCRIBED);
    }

    /**
     * @return bool
     */
    public function isUnsubscribed()
    {
        return $this->is(self::UNSUBSCRIBED);
    }

    /**
     * @return bool
     */
    public function isConversationStarted()
    {
        return $this->is(self::CONVERSATION_STARTED);
    }

    /**
     * @return bool
     */
    public function isDelivered()
    {
        return $this->is(self::DELIVERED);
    }

    /**
     * @return bool
     */
    public function isSeen()
    {
        return $this->is(self::SEEN);
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return $this->is(self::FAILED);
    }

    /**
     * @return bool
     */
    public function isMessage()
    {
        return $this->is(self::MESSAGE);
    }

    /**
     * @return bool
     */
    public function isMessageText()
    {
        return $this->isMessageType(Message::TEXT);
    }

    /**
     * @return bool
     */
    public function isMessagePicture()
    {
        return $this->isMessageType(Message::PICTURE);
    }

    /**
     * @return bool
     */
    public function isMessageVideo()
    {
        return $this->isMessageType(Message::VIDEO);
    }

    /**
     * @return bool
     */
    public function isMessageFile()
    {
        return $this->isMessageType(Message::FILE);
    }

    /**
     * @return bool
     */
    public function isMessageSticker()
    {
        return $this->isMessageType(Message::STICKER);
    }

    /**
     * @return bool
     */
    public function isMessageUrl()
    {
        return $this->isMessageType(Message::URL);
    }

    /**
     * @return bool
     */
    public function isMessageLocation()
    {
        return $this->isMessageType(Message::LOCATION);
    }

    /**
     * @return bool
     */
    public function isMessageContact()
    {
        return $this->isMessageType(Message::CONTACT);
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->data->event;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->data->timestamp;
    }

    /**
     * @return string
     */
    public function getMessageToken()
    {
        return $this->data->message_token;
    }

    /**
     * @return null|array
     */
    public function getMessage()
    {
        return $this->isMessage() ? $this->data->message : null;
    }

    /**
     * @return null|string
     */
    public function getMessageText()
    {
        return $this->isMessage() ? $this->data->message->text : null;
    }

    /**
     * @return null|string
     */
    public function getMessageTrackingData()
    {
        return $this->isMessage() ? $this->data->message->tracking_data : null;
    }

    /**
     * @return null|array
     */
    public function getMessageSender()
    {
        return $this->isMessage() ? $this->data->sender : null;
    }

    /**
     * @return null|string
     */
    public function getMessageSenderId()
    {
        return $this->isMessage() ? $this->data->sender->id : null;
    }

    /**
     * @return null|string
     */
    public function getConversationContext()
    {
        return $this->isConversationStarted() ? $this->data->context : null;
    }

    /**
     * @return null|array
     */
    public function getConversationUser()
    {
        return $this->isConversationStarted() ? $this->data->user: null;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}