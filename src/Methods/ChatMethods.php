<?php

namespace Cian\Slack\Methods;


trait ChatMethods
{
    public function postMessage(array $message)
    {
        return $this->request('POST', '/chat.postMessage', [
            'headers' => [
                'Content-type' => 'application/json;charset=utf-8',
                'Authorization' => null
            ],
            'json' => $message
        ]);
    }

    public function updateMessage()
    {
        return [
            'method' => 'POST',
            'path' => '/chat.update',
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => null
            ]
        ];
    }
}