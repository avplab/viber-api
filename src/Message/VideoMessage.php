<?php

namespace AvpLab\ViberApi\Message;

class VideoMessage extends Message
{
    public function __construct(string $media, int $size)
    {
        $this->message['type'] = static::VIDEO;
        $this->setMedia($media);
        $this->setSize($size);
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
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail)
    {
        $this->message['thumbnail'] = $thumbnail;
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
     * @param int $duration
     * @return $this
     */
    public function setDuration(int $duration)
    {
        $this->message['duration'] = $duration;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'VideoMessage.media is required',
            function(){ return isset($this->message['media']); }
        ];
        $rules[] = [
            'VideoMessage.size is required',
            function(){ return isset($this->message['size']); }
        ];
        if (isset($this->message['duration'])) {
            $rules[] = [
                'VideoMessage.size max is 180 seconds',
                function(){ return $this->message['duration'] <= 180; }
            ];
        }
        return $rules;
    }
}