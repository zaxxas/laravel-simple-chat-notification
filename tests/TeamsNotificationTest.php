<?php

namespace Illuminate\Tests\Notifications;

use Orchestra\Testbench\TestCase;
use Zaxxas\NotifyToChatTools\Services\NotificationToChatToolsService;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Env;
use Zaxxas\NotifyToChatTools\Enums\NotificationTool;

class TeamsNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('notification.tool', NotificationTool::Teams->value);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_failed_to_send_a_message_when_not_specified_webhook_url()
    {
        Config::set('notification.slack.webhook_url', '');

        $messageContent = new NotificationMessageContent(
            'sample title',
            'sample message',
            ['key1' => 'value1', 'key2' => 'value2'],
            []
        );
        $service = new NotificationToChatToolsService();
        $this->assertFalse($service->notify($messageContent));
    }

    public function test_succeeded_to_send_a_message()
    {
        Config::set('notification.teams.webhook_url', Env::get('TEAMS_WEBHOOK_URL'));

        $messageContent = new NotificationMessageContent(
            'sample title',
            'sample message',
            ['key1' => 'value1', 'key2' => 'value2'],
            []
        );
        $service = new NotificationToChatToolsService();
        $this->assertTrue($service->notify($messageContent));
    }
}
