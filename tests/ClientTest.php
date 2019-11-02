<?php

namespace Cian\Slack\Tests;

use Cian\Slack\Client;
use GuzzleHttp\Psr7\Response;
use Cian\Slack\Tests\TestCase;

class ClientTest extends TestCase
{
    /** @test */
    public function it_should_transfer_correct_paramaters_and_return_response_array()
    {
        $expectMethod = 'POST';
        $expectURL = 'https://exmaple.test';
        $expectPayload = [
            'headers' => [
                'X-CUSTOM-HEADER' => 'FOO'
            ],
            'json' => [
                'channel' => 'general'
            ]
        ];
        $expectResponse = ['foo' => 'bar'];

        $guzzle = $this->getMockedGuzzle();

        $guzzle->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectPayload)
            ->andReturn(new Response(200, [], json_encode($expectResponse)));

        $client = new Client($guzzle);

        $response = $client->request($expectMethod, $expectURL, $expectPayload);

        $this->assertEquals($expectResponse, $response);
    }
}
