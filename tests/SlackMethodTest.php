<?php

namespace Cian\Slack\Tests;

use Mockery;
use Cian\Slack\SlackMethod;
use GuzzleHttp\Psr7\Response;

class SlackMethodTest extends TestCase
{
    /** @test */
    public function it_can_list_team_users()
    {
        $token = 'xoxp-18480229362-213547405250-782294944245-7b2d2218c72dc7f2d10718ff1b8632d7';
        $token = 'foo-123';

        $mock = $this->getMockedGuzzle();

        $mock->shouldReceive('request')
            ->once()
            ->with('GET', "https://slack.com/api/users.list?token={$token}&pretty=1", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]);

        (new SlackMethod)
            ->setClient($mock)
            ->setToken($token)
            ->usersList();
    }

    /** @test */
    public function it_can_find_user_data_by_email()
    {
        $token = 'foo-123';
        $email = 'test@example.com';

        $mock = $this->getMockedGuzzle();

        $mock->shouldReceive('request')
            ->once()
            ->with('GET', "https://slack.com/api/users.lookupByEmail?token={$token}&email={$email}", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]);

        (new SlackMethod)
            ->setClient($mock)
            ->setToken($token)
            ->lookupByEmail($email);
    }
}
