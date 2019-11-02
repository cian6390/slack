# Slack for PHP

This library it not ready, don't use it now.

## Requirements

- PHP7.0

## Installation

```
composer require cian/slack
```

### Laravel 5

```shell
php artisan vendor:publish
```

#### Provider

If your laravel version greater then or equals to 5.5 and you don't need to do this. 

```php
// config/app.php
[
    // register what you need
    'providers' => [
        \Cian\Slack\ServiceProvider::class
    ]
]

```

### Message

Message instance can use for IncomingWebhook, InteractiveMessage

#### Basic

```php

use Cian\Slack\Message;

/**
 * You can just give text and optional argument `$enableMarkdownForText`
 **/
$text = '😗😗😗 Hello world!';
$enableMarkdownForText = false; // default to true, you need give false when you want use emoji.
$message = new Message($text, $enableMarkdownForText);

/** 
 * output:
 * [
 *      'text' => '😗😗😗 Hello world!',
 *      'mrkdwn' => false
 * ]
 **/
$message->toArray();

```

#### Use Block

```php

use Cian\Slack\Message;
use Cian\Slack\Builders\BlockBuilder;

$builder = new BlockBuilder;

$builder
    ->section('*A Title Here*') // block use text type `mrkdwn` by default
    ->section('body content ...')
    ->divider()
    ->disableMarkdown() // You need disable markdown before use emoji 
    ->section('😗😗😗')
    ->actions([ /** array of interactive components */]);

// create a message by given block builder instance.
$message = new Message($builder);

// or give a array
// more https://api.slack.com/reference/messaging/payload
$message = new Message([
    'blocks' => $builder->toArray()
    'text' => '😗 fallback message ...',
    'mrkdwn' => false
]);
```

### Attachment


##### InteractiveMessage

```php

use Cian\Slack\Message;
use Cian\Slack\InteractiveMessage as SIM;

$token = 'my-app-token';

$channel = 'general';
$message = new Message('Hello Interactive Message');

$sim = new SIM
$sim->setToken($token)->setChannel($channel)->send($message);

// or

$sim = new SIM([
    'token' => $token,
    'channel' => $channel
]);

$sim->send($message);
```

##### IncomingWebhook

```php

use Cian\Slack\Message;
use Cian\Slack\IncomingWebhook as SIW;

$token = 'my-app-token';
$url = 'https://api.slack.com/path/to/my/incoming-webhook/url';

$message = new Message('Hello world');

// you can set token by setToken method
// and you don't need give any paramaters to construct
$siw = new SIW(['token' => $token]);

$siw->send($message, $url);

// or

$siw->setURL($url)
    ->send($message);

```
