<?php

namespace OguzCabuk\Http\Client\Tests;


use OguzCabuk\Http\Client\Configuration;
use OguzCabuk\Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    private $testUrl = "https://requestb.in";
    private $testPath = "/1e762wv1";

    public function client() {
        return new HttpClient(new Configuration(
            $this->testUrl,
            ["Auth" => "secret"]
        ));
    }

    public function testPostRequest()
    {
        $response = $this->client()
            ->post($this->testPath, ["a" => 1]);
        $this->assertSame("ok", $response->getBody());
    }

    public function testGetRequest()
    {
        $response = $this->client()
            ->get($this->testPath, ["b" => 2]);
        $this->assertSame("ok", $response->getBody());
    }

    public function testMockPostRequest() {
        $response = $this->client()
            ->mock("hello-mock-response")
            ->post("/not-yet-completed-route");

        $this->assertSame("hello-mock-response", $response->getBody());
        $this->assertTrue($response->isSuccess());
    }

    public function testMockGetRequest404() {
        $response = $this->client()
            ->mock("hello-mock-response2", 404)
            ->get("/not-yet-completed-route-2");

        $this->assertSame("hello-mock-response2", $response->getBody());
        $this->assertEquals(404, $response->getCode());
        $this->assertFalse($response->isSuccess());
    }

    public function testMockAndRealRequest()
    {
        $client = $this->client();

        $mockResponse = $client->mock("mock")->get("uri");
        $realResponse = $client->get($this->testPath);

        $this->assertNotSame($mockResponse, $realResponse);
        $this->assertSame($mockResponse, $mockResponse);
    }

}