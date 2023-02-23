<?php

return [
    'tool' => env('NOTIFICATION_TOOL', 'slack'),
    'teams' => [
        'webhook_url' => env('TEAMS_WEBHOOK_URL'),
    ],
    'slack' => [
        'webhook_url' => env('SLACK_WEBHOOK_URL'),
        'channel' => env('SLACK_CHANNEL'),
        'sender_name' => env('SLACK_SENDER_NAME'),
    ],
    'line' => [
        'url' => env('LINE_API_ENDPOINT'),
        'token' => env('LINE_API_TOKEN'),
    ]
];
