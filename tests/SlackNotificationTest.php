<?php

namespace Illuminate\Tests\Notifications;

use PHPUnit\Framework\TestCase;
use Zaxxas\NotifyToChatTools\Services\NotificationToChatToolsService;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;

class SlackNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        putenv("NOTIFICATION_TOOL=slack");
    }

    public function test_No_Webhook_Url()
    {
        putenv("SLACK_WEBHOOK_URL=https://hogehoge.example.com");
        putenv("SLACK_CHANNEL=example-channel");
        putenv("SLACK_SENDER_NAME=example");

        var_dump(config('notification.tool'));

        $messageContent = new NotificationMessageContent(
            'sample title',
            'sample message',
            ['key1' => 'value1', 'key2' => 'value2'],
            []
        );
        $service = new NotificationToChatToolsService();
        try {
            $service->notify($messageContent);
        } catch (\Exception $e) {
        }
    }
}
