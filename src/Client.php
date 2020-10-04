<?php

namespace AvpLab\ViberApi;

use AvpLab\ViberApi\Exception\ApiException;
use AvpLab\ViberApi\Exception\ServerErrorResponseException;
use AvpLab\ViberApi\Message\Message;

class Client
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $senderName;

    /**
     * @var string
     */
    private $senderAvatar;

    /**
     * @param string $token
     * @param string $senderName
     * @param string $senderAvatar
     */
    public function __construct(string $token, string $senderName, string $senderAvatar = null)
    {
        $this->token = $token;
        $this->senderName = $senderName;
        $this->senderAvatar = $senderAvatar;
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    private function callApi(string $endpoint, array $data): array
    {
        $json = json_encode($data);
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => 'https://chatapi.viber.com/pa' . $endpoint,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $json,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($json),
                    'X-Viber-Auth-Token: ' . $this->token
                ]
            ]
        );

        $responseJson = curl_exec($ch);

        if ($responseJson === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new ServerErrorResponseException($error);
        }

        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($responseCode !== 200) {
            curl_close($ch);
            throw new ServerErrorResponseException();
        }
        curl_close($ch);

        $response = json_decode($responseJson, true);
        if ($response['status'] !== 0) {
            throw new ApiException($response['status'], $response['status_message']);
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @return null|string
     */
    public function getSenderAvatar()
    {
        return $this->senderAvatar;
    }

    /**
     * @param string $receiver
     * @param Message $message
     * @param bool $withSender
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function sendMessage(string $receiver, Message $message, bool $withSender = true): array
    {
        if ($withSender === true) {
            $message->setSender($this->senderName, $this->senderAvatar);
        }
        $data = $message->getData();
        $data['receiver'] = $receiver;

        return $this->callApi('/send_message', $data);
    }

    /**
     * @param string $url
     * @param array $eventTypes
     * @param bool $sendName
     * @param bool $sendPhoto
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function setWebhook(string $url, array $eventTypes = [], bool $sendName = true, bool $sendPhoto = true): array
    {
        $data = [
            'url' => $url,
            'event_types' => $eventTypes,
            'send_name' => $sendName,
            'send_photo' => $sendPhoto
        ];
        return $this->callApi('/set_webhook', $data);
    }

    /**
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function removeWebhook(): array
    {
        return $this->callApi('/set_webhook', ['url' => '']);
    }

    /**
     * @param array $broadcastList
     * @param Message $message
     * @param bool $withSender
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function broadcastMessage(array $broadcastList, Message $message, bool $withSender = true): array
    {
        if ($withSender === true) {
            $message->setSender($this->senderName, $this->senderAvatar);
        }
        $data = $message->getData();
        $data['broadcast_list'] = $broadcastList;

        return $this->callApi('/broadcast_message', $data);
    }

    /**
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function getAccountInfo(): array
    {
        return $this->callApi('/get_account_info', []);
    }

    /**
     * @param string $userId
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function getUserDetails(string $userId): array
    {
        return $this->callApi('/get_user_details', ['id' => $userId]);
    }

    /**
     * @param array $ids
     * @return array
     * @throws ApiException
     * @throws ServerErrorResponseException
     */
    public function getOnline($ids): array
    {
        return $this->callApi('/get_online', ['ids' => $ids]);
    }

    /**
     * @param Message $message
     * @param bool $withSender
     */
    public function responseWelcomeMessage(Message $message, bool $withSender = true)
    {
        if ($withSender === true) {
            $message->setSender($this->senderName, $this->senderAvatar);
        }
        header('content-type: application/json');
        echo json_encode($message->getData());
    }
}