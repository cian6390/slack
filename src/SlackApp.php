<?php

namespace Cian\Slack;

use Cian\Slack\Client;

abstract class SlackApp
{
    const ENDPOINT = 'https://slack.com/api';

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

    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function request(string $method, string $url, $options = [])
    {
        return $this->client->request($method, $url, $options);
    }

    public function postMessage(array $payload)
    {
        return $this->request('POST', self::ENDPOINT . '/chat.postMessage', [
            'headers' => [
                'Content-type' => 'application/json;charset=utf-8',
                'Authorization' => 'Bearer ' . $this->getToken()
            ],
            'json' => $payload
        ]);
    }

    public function updateMessage($payload, $url)
    {
        return $this->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getToken()
            ],
            'json' => $payload
        ]);
    }
}
