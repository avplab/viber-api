<?php

namespace AvpLab\ViberApi\Message;

class PictureMessage extends Message
{
    public function __construct(string $media, string $photoDescription)
    {
        $this->message['type'] = static::PICTURE;
        $this->setMedia($media);
        $this->setPhotoDescription($photoDescription);
    }

    public function setMedia($media)
    {
        $this->message['media'] = $media;
        return $this;
    }

    public function setPhotoDescription($photoDescription)
    {
        $this->message['text'] = $photoDescription;
        return $this;
    }

    public function setThumbnail($thumbnail)
    {
        $this->message['thumbnail'] = $thumbnail;
        return $this;
    }

    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'PictureMessage.text is required',
            function(){ return !empty($this->message['text']); }
        ];
        $rules[] = [
            'PictureMessage.text length max is 120 characters',
            function(){ return strlen($this->message['text']) <= 120; }
        ];
        $rules[] = [
            'PictureMessage.media is required',
            function(){ return !empty($this->message['media']); }
        ];
        return $rules;
    }
}