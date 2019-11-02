<?php

namespace Cian\Slack\Tests;

use Mockery;
use GuzzleHttp\Client;
use Cian\Slack\Tests\TestCase;
use Cian\Slack\IncomingWebhook;
use Cian\Slack\Builders\BlockBuilder;

class IncomingWebhookTest extends TestCase
{
    public function test_text_message_case()
    {
        $url = 'https://hooks.slack.com/services/ABCDEFG';

        $message = 'Hello world.';

        $mock = Mockery::mock(Client::class);

        $mock->shouldReceive('request')
            ->once()
            ->with('POST', $url, [
                'headers' => [
                    'Content-type' => 'application/json;charset=utf-8'
                ],
                'json' => [
                    'text' => $message,
                    'mrkdwn' => true
                ]
            ])
            ->andReturn(null);

        $webhook = new IncomingWebhook([], $mock);

        $response = $webhook->send($message, $url);

        $this->assertNull($response);
    }

    public function test_array_message_case()
    {
        $message = [
            'mrkdwn' => true,
            'text' => 'fallback text ...',
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => 'Danny Torrence left the following review for your property:'
                    ]
                ]
            ]
        ];

        $url = 'https://hooks.slack.com/services/ABCDEFG';

        $mock = Mockery::mock(Client::class);

        $mock->shouldReceive('request')
            ->once()
            ->with('POST', $url, [
                'headers' => [
                    'Content-type' => 'application/json;charset=utf-8'
                ],
                'json' => $message
            ])
            ->andReturn(null);

        $webhook = new IncomingWebhook([], $mock);

        $response = $webhook->send($message, $url);

        $this->assertNull($response);
    }

    public function test_block_builder_message_case()
    {
        $message = new BlockBuilder;

        $message->section('Hello world')->divider();

        $url = 'https://hooks.slack.com/services/ABCDEFG';

        $mock = Mockery::mock(Client::class);

        $mock->shouldReceive('request')
            ->once()
            ->with('POST', $url, [
                'headers' => [
                    'Content-type' => 'application/json;charset=utf-8'
                ],
                'json' => [
                    'mrkdwn' => true,
                    'blocks' => [
                        [
                            'type' => 'section',
                            'text' => [
                                'type' => 'mrkdwn',
                                'text' => 'Hello world'
                            ]
                        ], [
                            'type' => 'divider'
                        ]
                    ]
                ]
            ])
            ->andReturn(null);

        $webhook = new IncomingWebhook([], $mock);

        $response = $webhook->send($message, $url);

        $this->assertNull($response);
    }
}
