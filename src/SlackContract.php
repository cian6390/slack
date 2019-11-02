<?php

namespace Cian\Slack;

interface SlackContract
{
    const API_ENDPOINT = 'https://slack.com/api';

    const CHAT_POST_MESSAGE_API = [
        'method' => 'POST',
        'path' => '/chat.postMessage',
        'headers' => [
            'Content-type' => 'application/json;charset=utf-8',
            'Authorization' => null
        ]
    ];

    const CHAT_UPDATE_API = [
        'method' => 'POST',
        'path' => '/chat.update',
        'headers' => [
            'Content-type' => 'application/json',
            'Authorization' => null
        ]
    ];
}
