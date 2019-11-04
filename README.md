# Slack for PHP

[![Build Status](https://travis-ci.com/cian6390/slack.svg?branch=master)](https://travis-ci.com/cian6390/slack)
[![Latest Stable Version](https://poser.pugx.org/cian/slack/v/stable)](https://packagist.org/packages/cian/slack)
[![Total Downloads](https://poser.pugx.org/cian/slack/downloads)](https://packagist.org/packages/cian/slack)
[![License](https://poser.pugx.org/cian/slack/license)](https://packagist.org/packages/cian/slack)

## Requirements

- PHP 7.0+

## Installation

```
composer require cian/slack
```

### Laravel

```shell
php artisan vendor:publish --provider="Cian\Slack\LaravelServiceProvider"
```

If your laravel version `<= 5.4`, don't forget to add a service provider.  

```php
// /config/app.php
[
    "providers" => [
        // other providers ...
        Cian\Slack\LaravelServiceProvider::class
    ]
]
```

### Slack Methods

Slack has a lot of [useful methods](https://api.slack.com/methods).  

**Available methods**

- users.list
- users.lookupByEmail

More methods will be added in this library.

#### users.list

```php
use Cian\Slack\SlackMethod;

$token = 'your-app-token';

$response = (new SlackMethod)
    ->setToken($token)
    ->usersList();
```

#### users.lookupByEmail

```php
use Cian\Slack\SlackMethod;

$token = 'your-app-token';

$response = (new SlackMethod)
    ->setToken($token)
    ->usersLookupByEmail($email);
```

> Note that if you get SlackMethod, InteractiveMessage from LaravelServiceProvider,  
> you don't need to call `setToken` before api call.  

### IncomingWebhook

This is an example for sending a basic incoming webhook.  
For more complex scenarios you will need to use `BlockBuilder` or `AttachmentBuilder`.

```php
use Cian\Slack\IncomingWebhook;

$url = 'https://hooks.slack.com/services/path/to/your/incoming-webhook/url';

(new IncomingWebhook)->send($message, $url);
```

### Interactive Message

To use interactive message, you need to set up `OAuth & Permissions` of your app. After that, you can send the message like below.  

```php
use Cian\Slack\InteractiveMessage;

$token = 'your-app-token';

// $channel can be channel_name, channel_id, user_slack_id
// but Slack suggests not to use channel_name.
$channel = 'development';

$message = 'Hello Interactive Message!';

(new InteractiveMessage([
    'token' => $token,
    'channel' => $channel
]))->send($message);

// or

(new InteractiveMessage)
    ->setToken($token)
    ->to($channel)
    ->send($message);
```

### Block

Slack suggests to use `Block` instead of `Attachment`  
because `Block` is more flexible than `Attachment`.  

```php
use Cian\Slack\IncomingWebhook;
use Cian\Slack\Builders\BlockBuilder;

$url = 'https://hooks.slack.com/services/path/to/your/incoming-webhook/url';

$builder = (new BlockBuilder)
    ->section('*A Title Here*')
    ->section('body content ...')
    ->divider()
    ->section('😗😗😗');

(new IncomingWebhook)->send($builder, $url)
```

### Attachment

Even Slack suggests to use `Block` instead of `Attachment`,  
it won't remove the `Attachment`.  

`Attachment` has a lot of fields, but they are all legacy.  
[check slack attachment document to know more](https://api.slack.com/reference/messaging/attachments)  

The best way of using Attachment is keep only two fields, `blocks` and `color`.  

```php
use Cian\Slack\IncomingWebhook;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

$blockBuilder = (new BlockBuilder)->section('How are you?');

// when you provide block builder as the first argument
// the second argument color will be applied
// the color can be 'good', 'warning', 'danger' or any valid hex color code.
$attachments = (new AttachmentBuilder($blockBuilder, '#ff0000'));

$url = 'https://hooks.slack.com/services/path/to/your/incoming-webhook/url';

(new IncomingWebhook)
    ->send($attachments, $url);
```

Let's say if you still need legacy fields,  
you can do it like below.  

```php
use Cian\Slack\IncomingWebhook;
use Cian\Slack\Builders\AttachmentBuilder;

$attachments = (new AttachmentBuilder)->add([
    'text' => '😗😗😗',
    'fallback' => 'fall back text...',
    'footer' => 'footer text...',
    'color' => 'danger'
    // ... more legacy fields
]);

$url = 'https://hooks.slack.com/services/path/to/your/incoming-webhook/url';

(new IncomingWebhook)
    ->send($attachments, $url);
```

Let's say you are facing a very complex scenario,    
you would need to use blocks and attachments together.  

```php
use Cian\Slack\Message;
use Cian\Slack\IncomingWebhook;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

$titleBlocker = (new BlockBuilder)
    ->section('Title row 😗😗😗');

$bodyBlocker = (new BlockBuilder)
    ->section('body content ...')
    ->divider();

$attachmenter = (new AttachmentBuilder($bodyBlocker, '#ff00ff'));

$message = new Message($titleBlocker);

$message->setAttachments($attachmenter);

$url = 'https://hooks.slack.com/services/path/to/your/incoming-webhook/url';

(new IncomingWebhook)
    ->send($message, $url);
```

Although I use `IncomingWebhook` in document examples,  
it can be replaced by `InteractiveMessage`.  

## Interactive Component

### Button

```php
use Cian\Slack\IncomingWebhook;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\ElementBuilder;

$text = 'Approve';
$actionId = 'approve_request';
$value = ['foo' => 'bar'];  // optional default ''
$style = 'primary';         // optional default 'primary'
$type = 'plain_text';       // optional default `plain_text`
$button = ElementBuilder::makeButton($text, $actionId, $value, $style, $type);
// or $button = (new ElementBuilder)->button(/** same as makeButton */);

$blocker = (new BlockBuilder)
    ->section('*Can I buy a toy ?*')
    ->divider()
    ->actions([$button]);

$url = 'https://hooks.slack.com/services/path/to/your/incoming-webhook/url';

(new IncomingWebhook)->to($url)->send($blocker);
// or (new IncomingWebhook)->send($blocker, $url);
```
