<?php

namespace AvpLab\ViberApi\Framework;

use AvpLab\ViberApi\Callback\Request;

class ControllerRequest extends Request
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $trackingData;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        parent::__construct($token);

        $this->path = '/';
        $this->trackingData = parent::getMessageTrackingData();
        if (preg_match('~__path__(.+)$~', $this->trackingData, $match)) {
            $this->trackingData = str_replace($match[0], '', $this->trackingData);
            $this->path = $match[1];
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMessageTrackingData(): string
    {
        return $this->trackingData;
    }
}