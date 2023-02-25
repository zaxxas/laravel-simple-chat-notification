<?php

use Zaxxas\NotifyToChatTools\Enums\NotificationTool;

return [
    'tool' => env('NOTIFICATION_TOOL', NotificationTool::Slack->value),
    'teams' => [
        'webhook_url' => env('TEAMS_WEBHOOK_URL'),
    ],
    'slack' => [
        'webhook_url' => env('SLACK_WEBHOOK_URL'),
        'channel'     => env('SLACK_NOTIFICATION_CHANNEL'),
        'sender_name' => env('SLACK_NOTIFICATION_SENDAR_NAME'),
    ],
    'line' => [
        'url' => env('LINE_API_ENDPOINT'),
        'token' => env('LINE_API_TOKEN'),
    ]
];
