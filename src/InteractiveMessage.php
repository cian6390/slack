<?php

namespace Cian\Slack;

use Cian\Slack\Message;
use Cian\Slack\SlackApp;

class InteractiveMessage extends SlackApp
{
    /**
     * Can be slack_channel_name. slack_channel_id, slack_user_id.
     * 
     * @var string $channel
     */
    protected $channel;

    /**
     * @param array $options
     * @param \Cian\Slack\Client|\GuzzleHttp\Client|null $client
     * @return void
     */
    public function __construct($options = [], $client = null)
    {
        parent::__construct($options, $client);

        if (isset($options['channel'])) {
            $this->channel = $options['channel'];
        }
    }

    /**
     * Set interactive channel
     * Can be slack_channel_name. slack_channel_id, slack_user_id.
     * 
     * @param string $channel
     * @return $this
     */
    public function to($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Sending message.
     * 
     * @param string|array|\Cian\Slack\Message|\Cian\Slack\Builders\BlockBuilder|\Cian\Slack\Builders\AttachmentBuilder $message
     * @param string|null $channel
     * @return array
     */
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

    /**
     * Update a interactive message content.
     * 
     * @param string $url
     * @param string $message
     * @return array
     */
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
