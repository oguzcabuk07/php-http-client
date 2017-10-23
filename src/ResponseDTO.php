<?php

namespace OguzCabuk\Http\Client;


class ResponseDTO
{
    private $code;
    private $body;
    private $headers;

    public function __construct($code, $body, $headers)
    {
        $this->code = $code;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function isSuccess()
    {
        return $this->code >= 200 && $this->code < 300;
    }
}