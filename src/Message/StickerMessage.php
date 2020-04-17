<?php

namespace AvpLab\ViberApi\Message;

class StickerMessage extends Message
{
    public function __construct(string $stickerId)
    {
        $this->message['type'] = static::STICKER;
        $this->setStickerId($stickerId);
    }

    /**
     * @param string $stickerId
     * @return $this
     */
    public function setStickerId(string $stickerId)
    {
        $this->message['sticker_id'] = $stickerId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'StickerMessage.sticker_id is required',
            function(){ return !empty($this->message['sticker_id']); }
        ];
        return $rules;
    }
}
