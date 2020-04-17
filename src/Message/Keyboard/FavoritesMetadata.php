<?php

namespace AvpLab\ViberApi\Message\Keyboard;

use AvpLab\ViberApi\Message\DataEntity;

class FavoritesMetadata implements DataEntity
{

    const TYPE_GIF = 'gif';
    const TYPE_LINK = 'link';
    const TYPE_VIDEO = 'video';

    /**
     * @var array
     */
    private $meta = [];

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->meta['type'] = $type;
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->meta['url'] = $url;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->meta['title'] = $title;
        return $this;
    }

    /**
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail)
    {
        $this->meta['thumbnail'] = $thumbnail;
        return $this;
    }

    /**
     * @param string $domain
     * @return $this
     */
    public function setDomain(string $domain)
    {
        $this->meta['domain'] = $domain;
        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function setThumbnailSize(int $width, int $height)
    {
        $this->meta['width'] = $width;
        $this->meta['height'] = $height;
        return $this;
    }

    /**
     * @param string $alternativeUrl
     * @return $this
     */
    public function setAlternativeUrl(string $alternativeUrl)
    {
        $this->meta['alternativeUrl'] = $alternativeUrl;
        return $this;
    }

    /**
     * @param string $alternativeText
     * @return $this
     */
    public function setAlternativeText(string $alternativeText)
    {
        $this->meta['alternativeText'] = $alternativeText;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $types = [self::TYPE_GIF, self::TYPE_LINK, self::TYPE_VIDEO];

        $rules = [
            [
                'FavoritesMetadata.type is required',
                function () { return isset($this->meta['type']); }
            ],
            [
                sprintf('FavoritesMetadata.type must be one of the %s', implode(', ', $types)),
                function() use ($types) { return in_array($this->meta['type'], $types); }
            ],
            [
                'FavoritesMetadata.url is required',
                function () { return isset($this->meta['url']); }
            ]
        ];

        if (isset($this->meta['width'])) {
            $rules[] = [
                'FavoritesMetadata.width must be positive integer',
                function() { return $this->meta['width'] >= 0; }
            ];
        }
        if (isset($this->meta['height'])) {
            $rules[] = [
                'FavoritesMetadata.height must be positive integer',
                function() { return $this->meta['height'] >= 0; }
            ];
        }

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->meta;
    }

}
