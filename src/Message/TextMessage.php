<?php

namespace AvpLab\ViberApi\Message;

class TextMessage extends Message
{
    public function __construct(string $text)
    {
        $this->message['type'] = static::TEXT;
        $this->setText($text);
    }

    public function setText($text)
    {
        $this->message['text'] = $text;
        return $this;
    }

    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        $rules[] = [
            'TextMessage.text is required',
            function() { return !empty($this->message['text']); }
        ];
        return $rules;
    }
}