<?php

namespace Cian\Slack;

use Cian\Slack\Client;
use Cian\Slack\SlackApp;

class SlackMethod extends SlackApp
{
    public function __construct($options = [], Client $client = null)
    {
        parent::__construct($options, $client);
    }

    public function lookupByEmail(string $email)
    {
        $url = self::API_ENDPOINT . "/users.lookupByEmail?token={$this->token}&email={$email}";
        return $this->client->request('GET', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);
    }

    public function usersList()
    {
        $url = self::API_ENDPOINT . "/users.list?token={$this->token}&pretty=1";
        return $this->client->request('GET', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);
    }
}
