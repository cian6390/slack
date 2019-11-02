<?php

return [

    /**
     * The slack app token.
     */
    'token' => env('SLACK_APP_TOKEN', ''),


    /**
     * This array contains channel and it's webhook url pair
     */
    'webhooks' => [
        // 'general' => 'https://hooks.slack.com/services ....'
    ], 

    /**
     * This array contains action_id and action_handler pair
     * to enable this feature, you should use ActionManager
     */
    'actions' => [
        // 'mark_message_as_ignore' => 'App\Http\Controllers\Controller@markMessageAsIngore'
    ]
];
