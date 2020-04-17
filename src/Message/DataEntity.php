<?php

namespace AvpLab\ViberApi\Message;

interface DataEntity
{
    /**
     * @return array
     */
    public function getValidationRules();

    /**
     * @return array
     */
    public function getData();
}