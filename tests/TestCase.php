<?php

namespace Cian\Slack\Tests;

use Mockery;
use GuzzleHttp\Client;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function mock(string $className)
    {
        return Mockery::mock($className);
    }

    public function getMockedGuzzle()
    {
        return $this->mock(Client::class . '[request]');
    }
}
