<?php

namespace Cian\Slack;

use Cian\Slack\SlackApp;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\ElementBuilder;

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

    public function send($blocks, $channel = null)
    {
        $api = $this->getAPI(self::CHAT_POST_MESSAGE_API);
        return $this->client->request($api['method'], $api['url'], [
            'headers' => $api['headers'],
            'json' => [
                'channel' => is_null($channel) ? $this->channel : $channel,
                'blocks' => $blocks
            ]
        ]);
    }

    public function update($url, $message)
    {
        $api = $this->getAPI(self::CHAT_UPDATE_API);

        $blocks = is_string($message)
            ? [BlockBuilder::makeSection($message)]
            : $message;

        $options = [
            'headers' => $api['headers'],
            'json' => ['blocks' => $blocks]
        ];

        return $this->client->request($api['method'], $url, $options);
    }

    public function blocker($blocks = [])
    {
        return app(BlockBuilder::class, ['blocks' => $blocks]);
    }

    public function elementer()
    {
        return app(ElementBuilder::class);
    }
}
