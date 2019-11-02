<?php

namespace Cian\Slack;

use Cian\Slack\Message;
use Cian\Slack\SlackApp;

class IncomingWebhook extends SlackApp
{
    protected $url;

    public function to($url)
    {
        $this->url = $url;

        return $this;
    }

    public function send($message, $url = null)
    {
        if (!is_null($url)) {
            $this->to($url);
        }

        $payload = is_a($message, Message::class)
            ? $message->toArray()
            : (new Message($message))->toArray();

        $options = [
            'headers' => [
                'Content-type' => 'application/json;charset=utf-8'
            ],
            'json' => $payload
        ];

        return $this->client->request('POST', $this->url, $options);
    }
}
