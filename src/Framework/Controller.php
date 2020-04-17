<?php

namespace AvpLab\ViberApi\Framework;

use AvpLab\ViberApi\Client;
use AvpLab\ViberApi\Message\Message;

class Controller
{
    /**
     * @var ControllerRequest
     */
    private $request;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param ControllerRequest $request
     */
    public function setRequest(ControllerRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return ControllerRequest
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Message $message
     * @param null $path
     * @return array
     */
    protected function reply(Message $message, $path = null)
    {
        return $this->client->sendMessage($this->request->getMessageSenderId(), $this->prepareMessage($message, $path));
    }

    /**
     * @param $receiver
     * @param Message $message
     * @param null $path
     * @return array
     */
    protected function send($receiver, Message $message, $path = null)
    {
        return $this->client->sendMessage($receiver, $this->prepareMessage($message, $path));
    }

    /**
     * @param Message $message
     * @param array $broadcastList
     * @param null $path
     * @return array
     */
    protected function broadcast(Message $message, array $broadcastList, $path = null)
    {
        return $this->client->broadcastMessage($broadcastList, $this->prepareMessage($message, $path));
    }

    /**
     * @param Message $message
     * @param $path
     * @return Message
     */
    private function prepareMessage(Message $message, $path)
    {
        $messageData = $message->getData();
        $message->setTrackingData(($messageData['tracking_data'] ?? '') . '__path__'  . ($path ?? $this->request->getPath()));
        return $message;
    }
}