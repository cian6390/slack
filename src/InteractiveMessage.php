<?php

namespace Cian\Slack;

use Cian\Slack\Message;
use Cian\Slack\SlackApp;

class InteractiveMessage extends SlackApp
{
    protected $channel;

    public function __construct($options = [], $client = null)
    {
        parent::__construct($options, $client);

        if (isset($options['channel'])) {
            $this->channel = $options['channel'];
        }
    }

    public function to($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function send($message, $channel = null)
    {
        $payload = is_a($message, Message::class)
            ? $message->toArray()
            : (new Message($message))->toArray();

        $payload['channel'] = is_null($channel) ? $this->channel : $channel;

        $api = $this->getAPI(self::CHAT_POST_MESSAGE_API);

        return $this->client->request($api['method'], $api['url'], [
            'headers' => $api['headers'],
            'json' => $payload
        ]);
    }

    public function update($url, $message)
    {
        $api = $this->getAPI(self::CHAT_UPDATE_API);

        $payload = (new Message($message))->toArray();

        $options = [
            'headers' => $api['headers'],
            'json' => $payload
        ];

        return $this->client->request($api['method'], $url, $options);
    }
}
