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

If your laravel version `<= 5.4`, don't forget register service provider.  

```php
// /config/app.php
[
    "providers" => [
        // other providers ...
        Cian\Slack\LaravelServiceProvider::class
    ]
]
```

## Message

### Blocks chaining

```php
use Cian\Slack\Slack;

$message = (new Slack)->message();

$message

    // if provide string as first argument,
    // second argument will be apply to text type.
    // text type value can be 'plain_text' or 'mrkdwn', default is 'mrkdwn'
    ->section('A basic text section.', 'plain_text')

    // each block method accept function as first argument
    // it will always provide block instance for you.
    ->section(function ($block) { // Instance of SectionBlock.
        $block->type = 'plain_text';    // update block property.
        $block['text'] => 'Hello!!';    // each block has been implemented ArrayAccess interface. 
    })


    ->divider(function ($block) {

        // DividerBlock do not have any property
        // but you still can use this callback to do something you want.
        // or just ->divider()

    })

    ->actions(function ($block) { // Instance of ActionsBlock.

        // button text
        $text = 'Apporve';

        // button action_id
        $actionId = 'apporve_request';

        // button color (optional) default is 'default', can be 'default', 'primary', 'danger'
        $color = 'primary';

        // button value (optional) default is empty string.
        $value = [
            'post' => [
                'id' => 1,
                'content' => 'blablabla.....'
            ]
        ];

        // button text type (optional),
        // default is 'mrkdwn', can be 'plain_text', 'mrkdwn'
        $type = 'mrkdwn'

        $block->button($text, $actionId, $color, $value, $type);

        $block->button('Ignore', 'ignore_request');
    })

    // `to` method will detect value
    // if you provide value is not url,
    // it will send by chat.postMessage method.
    // otherwise it will send request to url.
    ->to('development')

    // if you provide `to` method a channel id or user id
    // you need provide app token to setToken method,
    // and make sure it has correct OAuth scope.
    ->setToken($token)

    // send message.
    ->send();
```

### Attachment

You can use block and attachment togeter.

```php

use Cian\Slack\Slack;

$message = (new Slack)->message();

$message

    // chain some blocks ....

    ->attachment(function ($attachment) {

        // Attachment implemented ArrayAccess interface too !!
        $attachment['title'] = 'Title ..';

        $attachment
            ->color('#ff0000')
            ->section('Content ....')
            ->divider()
            ->actions(function ($block) {
                // do something...
            });
    })

    ->to($channel)

    ->send();
```

### Update Message

```php
use Cian\Slack\Slack;

$message = (new Slack)->message()
    
    // the same as block and attachment ..

    ->update($response_url);

```

## Method

### Users

```php
use Cian\Slack\Method;

$response = (new Method)
            ->setToken($token)
            ->lookupByEmail($email);

// or use laravel Facade

$response = Method::lookupByEmail($email);
```

### Chat