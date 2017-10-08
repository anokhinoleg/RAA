<?php

namespace Service;

class Request
{
    private $requestedArray;

    public function __construct($requestedArray = array())
    {
        $this->requestedArray = $requestedArray;
    }

    public function getRequestedArray()
    {
        return $this->requestedArray;
    }
}