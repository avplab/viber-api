<?php

namespace AvpLab\ViberApi\Message;

class LocationMessage extends Message
{
    public function __construct(float $lat, float $lon)
    {
        $this->message['type'] = static::LOCATION;
        $this->setLocation($lat, $lon);
    }

    /**
     * @param float $lat
     * @param float $lon
     * @return $this
     */
    public function setLocation(float $lat, float $lon)
    {
        $this->message['location'] = [
            'lat' => $lat,
            'lon' => $lon
        ];
        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'LocationMessage.location.lat is required',
            function(){ return isset($this->message['location']['lat']); }
        ];
        $rules[] = [
            'LocationMessage.location.lat must be between -90 and +90 degrees',
            function(){ return $this->message['location']['lat'] >= -90.0 && $this->message['location']['lat'] <= 90.0; },
        ];
        $rules[] = [
            'LocationMessage.location.lon is required',
            function(){ return isset($this->message['location']['lon']); },
        ];
        $rules[] = [
            'LocationMessage.location.lon must be between -180 and +180 degrees',
            function(){ return $this->message['location']['lon'] >= -180.0 && $this->message['location']['lon'] <= 180.0; },
        ];
        return $rules;
    }
}