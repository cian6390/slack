<?php

namespace Cian\Slack;

use Cian\Slack\Client;
use GuzzleHttp\Client as Guzzle;
use Cian\Slack\SlackMethod;
use Cian\Slack\InteractiveMessage;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/slack.php',
            'slack'
        );

        $this->app->bind(InteractiveMessage::class, function ($app) {
            $token = config('slack.token');
            $client = new Client(app(Guzzle::class));
            return new InteractiveMessage(['token' => $token], $client);
        });

        $this->app->bind(SlackMethod::class, function ($app) {
            $token = config('slack.token');
            $client = new Client(app(Guzzle::class));
            return new SlackMethod(['token' => $token], $client);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/slack.php' => config_path('slack.php'),
        ], 'config');
    }
}
