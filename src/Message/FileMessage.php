<?php

namespace AvpLab\ViberApi\Message;

class FileMessage extends Message
{
    public function __construct(string $media, int $size, string $fileName)
    {
        $this->message['type'] = static::FILE;
        $this->setMedia($media);
        $this->setSize($size);
        $this->setFileName($fileName);
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
     * @param int $size
     * @return $this
     */
    public function setSize(int $size)
    {
        $this->message['size'] = $size;
        return $this;
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName(string $fileName)
    {
        $this->message['file_name'] = $fileName;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        $rules[] = [
            'FileMessage.media is required',
                function(){ return isset($this->message['media']); }
        ];
        $rules[] = [
            'FileMessage.size is required',
            function(){ return isset($this->message['size']); }
        ];
        $rules[] = [
            'FileMessage.file_name is required',
            function(){ return isset($this->message['file_name']); }
        ];

        $rules[] = [
            'FileMessage.file_name length is 256 characters max',
            function(){ return strlen($this->message['file_name']) <= 256; }
        ];

        return $rules;
    }
}