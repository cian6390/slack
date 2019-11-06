<?php

namespace Cian\Slack;

use Cian\Slack\Message;
use Cian\Slack\SlackApp;

class IncomingWebhook extends SlackApp
{
    /**
     * Incoming Webhook URL.
     * 
     * @var string $url
     */
    protected $url;

    /**
     * Incoming Webhook URL setter.
     * 
     * @param string $url
     * @return $this
     */
    public function to($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Sending message.
     * 
     * @param string|array|\Cian\Slack\Message|\Cian\Slack\Builders\BlockBuilder|\Cian\Slack\Builders\AttachmentBuilder $message
     * @return array
     */
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

        $response = $this->client->request('POST', $this->url, $options);

        return $response;
    }
}
