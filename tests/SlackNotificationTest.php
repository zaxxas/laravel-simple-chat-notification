<?php

namespace Illuminate\Tests\Notifications;

use Orchestra\Testbench\TestCase;
use Zaxxas\NotifyToChatTools\Services\NotificationToChatToolsService;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Env;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

class SlackNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('notification.tool', 'slack');
        Config::set('notification.slack.webhook_url', Env::get('SLACK_WEBHOOK_URL'));
        Config::set('notification.slack.channel', Env::get('SLACK_CHANNEL'));
        Config::set('notification.slack.username', Env::get('SLACK_SENDER_NAME'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_No_URL()
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

    public function test_No_Channel()
    {
        Config::set('notification.slack.channel', '');

        $messageContent = new NotificationMessageContent(
            'sample title',
            'sample message',
            ['key1' => 'value1', 'key2' => 'value2'],
            []
        );
        $service = new NotificationToChatToolsService();
        $this->assertFalse($service->notify($messageContent));
    }

    public function test_No_Username()
    {
        Config::set('notification.slack.username', '');

        $messageContent = new NotificationMessageContent(
            'sample title',
            'sample message',
            ['key1' => 'value1', 'key2' => 'value2'],
            []
        );
        $service = new NotificationToChatToolsService();
        $this->assertTrue($service->notify($messageContent));
    }

    public function test_OK()
    {
        Config::set('notification.slack.webhook_url', Env::get('SLACK_WEBHOOK_URL'));
        Config::set('notification.slack.channel', Env::get('SLACK_CHANNEL'));
        Config::set('notification.slack.sender_name', Env::get('SLACK_SENDER_NAME'));

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
