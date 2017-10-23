<?php

namespace OguzCabuk\Http\Client;


class Configuration
{
    private $url;
    private $headers = [];

    public function __construct($url, $headers = [])
    {
        $this->url = $url;
        $this->headers = $headers;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getHeaders()
    {
        return $this->headers ? $this->headers : [];
    }
}