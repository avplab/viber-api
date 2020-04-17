<?php

namespace AvpLab\ViberApi\Message;

class RichMediaMessage extends Message
{
    /**
     * @var Keyboard
     */
    private $richMedia;

    public function __construct()
    {
        $this->message['type'] = static::RICH_MEDIA;
    }

    /**
     * @param Keyboard $keyboard
     * @return $this
     */
    public function setRichMedia(Keyboard $keyboard)
    {
        $this->message['rich_media'] = $keyboard->getData();
        $this->message['rich_media']['Type'] = 'rich_media';
        $this->richMedia = $keyboard;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'RichMediaMessage.rich_media is required',
            function(){ return isset($this->message['text']); }
        ];
        if ($this->richMedia instanceof DataEntity) {
            array_merge($rules, $this->richMedia->getValidationRules());
        }
        return $rules;
    }
}
