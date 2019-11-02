<?php

namespace Cian\Slack;

use Cian\Slack\Client;
use Cian\Slack\IncomingWebhook;
use Cian\Slack\InteractiveMessage;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/slack.php', 'slack');
        
        $this->app->bind(IncomingWebhook::class, function ($app) {
            $client = $app[Client::class];
            return new IncomingWebhook(['token' => config('slack.token')], $client);
        });
        
        $this->app->bind(InteractiveMessage::class, function ($app) {
            $client = $app[Client::class];
            return new InteractiveMessage(['token' => config('slack.token')], $client);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/slack.php' => config_path('slack.php'),
        ]);
    }
}
