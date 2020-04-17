<?php

namespace AvpLab\ViberApi\Message\Keyboard\Button;

use AvpLab\ViberApi\Message\DataEntity;

class Map implements DataEntity
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * @param string $latitude
     * @return $this
     */
    public function setLatitude(string $latitude)
    {
        $this->map['Latitude'] = $latitude;
        return $this;
    }

    /**
     * @param string $longitude
     * @return $this
     */
    public function setLongitude(string $longitude)
    {
        $this->map['Longitude'] = $longitude;
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
        return $this->map;
    }
}