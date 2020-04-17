<?php

namespace AvpLab\ViberApi\Message\Keyboard\Button;

use AvpLab\ViberApi\Message\DataEntity;

class MediaPlayer implements DataEntity
{
    /**
     * @var array
     */
    private $mediaPlayer;

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->mediaPlayer['title'] = $title;
        return $this;
    }

    /**
     * @param string $subtitle
     * @return $this
     */
    public function setSubtitle(string $subtitle)
    {
        $this->mediaPlayer['subtitle'] = $subtitle;
        return $this;
    }

    /**
     * @param string $thumbnailURL
     * @return $this
     */
    public function setThumbnailURL(string $thumbnailURL)
    {
        $this->mediaPlayer['thumbnailURL'] = $thumbnailURL;
        return $this;
    }

    /**
     * @param bool $loop
     * @return $this
     */
    public function setLoop(bool $loop)
    {
        $this->mediaPlayer['loop'] = $loop;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->mediaPlayer;
    }
}
