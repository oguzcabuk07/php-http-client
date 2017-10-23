<?php

namespace OguzCabuk\Http\Client;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class HttpClient
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    private $mockResponse;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->client = new Client([
            "base_uri" => $this->configuration->getUrl(),
            "headers" => $this->configuration->getHeaders(),
        ]);
    }

    /**
     * @param $uri
     * @param array $params
     * @return ResponseDTO
     */
    public function post($uri, $params = []) {
        return $this->convertResponseDTO($this->request("POST", $uri, $params));
    }

    public function get($uri, $params = []) {
        return $this->convertResponseDTO($this->request("GET", $uri, $params));
    }

    public function mock($mockResponse, $statusCode = 200) {
        $_this = clone $this;
        $_this->mockResponse = sprintf("%s|%s", $statusCode, $mockResponse);
        return $_this;
    }

    private function request($method, $uri, $params) {
        if ($this->mockResponse) {
            return $this->buildMockResponse();
        }
        return $this->client->request($method, $uri, ["json" => $params]);
    }

    private function convertResponseDTO(Response $response) {
        return new ResponseDTO($response->getStatusCode(), $response->getBody()->getContents(), $response->getHeaders());
    }

    private function buildMockResponse() {
        list($status, $body) = explode("|", $this->mockResponse);
        return new Response($status, [], $body);
    }
}