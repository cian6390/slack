<?php

namespace Cian\Slack;

use GuzzleHttp\Client as Guzzle;

class Client
{
    protected $http;

    /**
     * @param \GuzzleHttp\Client $http
     */
    public function __construct(Guzzle $http)
    {
        $this->http = $http;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     *
     * @return array
     */
    public function request(string $method, string $url, array $options)
    {
        $response = $this->http->request($method, $url, $options);

        return $this->parse($response);
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
