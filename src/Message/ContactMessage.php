<?php

namespace AvpLab\ViberApi\Message;

class ContactMessage extends Message
{
    public function __construct(string $name, string $phoneNumber)
    {
        $this->message['type'] = static::CONTACT;
        $this->setContact($name, $phoneNumber);
    }

    /**
     * @param string $name
     * @param string $phoneNumber
     * @return $this
     */
    public function setContact(string $name, string $phoneNumber)
    {
        $this->message['contact'] = [
            'name' => $name,
            'phone_number' => $phoneNumber
        ];
        return $this;
    }

    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        $rules[] = [
            'ContactMessage.contact.name is required',
            function(){ return isset($this->message['contact']['name']); }
        ];
        $rules[] = [
            'ContactMessage.contact.name is 28 characters max',
            function(){ return strlen($this->message['contact']['name']) <= 28; }
        ];
        $rules[] = [
            'ContactMessage.contact.phone_number is required',
            function(){ return isset($this->message['contact']['phone_number']); }
        ];
        $rules[] = [
            'ContactMessage.contact.phone_number is 18 characters max',
            function(){ return strlen($this->message['contact']['phone_number']) <= 18; }
        ];
        return $rules;
    }
}