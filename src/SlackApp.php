<?php

namespace Cian\Slack;

use Cian\Slack\Client;
use Cian\Slack\SlackContract;

abstract class SlackApp implements SlackContract
{
    protected $token;

    protected $client;

    public function __construct($options = [], $client = null)
    {
        $client = is_null($client)
            ? new Client(new \GuzzleHttp\Client)
            : $client;

        $this->client = $client;

        if (isset($options['token'])) {
            $this->token = $options['token'];
        }
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getAPI($api)
    {
        if (isset($api['headers']['Authorization'])) {
            $api['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        }

        return [
            'method' => $api['method'],
            'url' => self::API_ENDPOINT . $api['path'],
            'headers' => $api['headers']
        ];
    }
}