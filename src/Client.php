<?php

namespace Cian\Slack;

use GuzzleHttp\Client as Guzzle;

class Client
{
    /**
     * @var \GuzzleHttp\Client $http
     */
    protected $http;

    /**
     * @param \GuzzleHttp\Client $http
     */
    public function __construct(Guzzle $http)
    {
        $this->http = $http;
    }

    /**
     * Wrap GuzzleClient request method, return array of decode response contents.
     * 
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     */
    public function request(string $method, string $url, array $options)
    {
        $response = $this->http->request($method, $url, $options);

        $response = $this->parse($response);

        return is_null($response) ? [] : $response;
    }

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     *
     * @return array
     */
    private function parse($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
