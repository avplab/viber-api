<?php

namespace AvpLab\ViberApi\Message;

class UrlMessage extends Message
{
    public function __construct(string $media)
    {
        $this->message['type'] = static::URL;
        $this->setMedia($media);
    }

    /**
     * @param string $media
     * @return $this
     */
    public function setMedia(string $media)
    {
        $this->message['media'] = $media;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'UrlMessage.media is required',
            function(){ return isset($this->message['media']); }
        ];
        $rules[] = [
            'UrlMessage.media length is 2000 characters max',
            function(){ return strlen($this->message['media']) <= 2000; }
        ];
        return $rules;
    }
}
