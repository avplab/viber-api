<?php

namespace AvpLab\ViberApi\Message;

abstract class Message implements DataEntity
{
    const TEXT = 'text';
    const PICTURE = 'picture';
    const VIDEO = 'video';
    const FILE = 'file';
    const STICKER = 'sticker';
    const CONTACT = 'contact';
    const URL = 'url';
    const LOCATION = 'location';
    const RICH_MEDIA = 'rich_media';

    protected $message = [];

    /**
     * @var Keyboard
     */
    private $keyboard;

    public function setSender($name, $avatar = null)
    {
        $this->message['sender']['name'] = $name;
        if ($avatar) {
            $this->message['sender']['avatar'] = $avatar;
        }
        return $this;
    }

    public function setTrackingData($trackingData)
    {
        $this->message['tracking_data'] = $trackingData;
        return $this;
    }

    public function setMinApiVersion($minApiVersion)
    {
        $this->message['min_api_version'] = $minApiVersion;
        return $this;
    }

    public function setKeyboard(Keyboard $keyboard)
    {
        $this->message['keyboard'] = $keyboard->getData();
        $this->message['keyboard']['Type'] = 'keyboard';
        $this->keyboard = $keyboard;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        return [
            [
                'Message.type is required',
                function(){ return isset($this->message['type']); }
            ],
            [
                'Message.sender.name is required',
                function(){ return isset($this->message['sender']['name']); }
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate($this->getValidationRules(), $this->message);
        if ($this->keyboard instanceof DataEntity) {
            $this->validate($this->keyboard->getValidationRules(), $this->message);
        }
        return $this->message;
    }

    private function validate($rules, $message)
    {
        foreach($rules as $rule) {
            if (call_user_func($rule[1], $message) !== true) {
                throw new \RuntimeException($rule[0]);
            }
        }
    }
}