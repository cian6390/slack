<?php

namespace Cian\Slack\Laravel;

use Cian\Slack\Client;
use GuzzleHttp\Client as GuzzleHttp;
use Cian\Slack\InteractiveMessage;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvide extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/slack.php',
            'slack'
        );

        $this->app->bind(InteractiveMessage::class, function ($app) {
            $token = config('slack.token');
            $client = new Client(app(GuzzleHttp::class));
            return new InteractiveMessage(['token' => $token], $client);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/slack.php' => config_path('slack.php'),
        ], 'config');
    }
}
