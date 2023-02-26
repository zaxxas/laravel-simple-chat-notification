<?php

namespace Illuminate\Tests\Notifications;

use Orchestra\Testbench\TestCase;
use Zaxxas\NotifyToChatTools\Services\NotificationToChatToolsService;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Env;
use Zaxxas\NotifyToChatTools\Enums\NotificationTool;

class LineNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('notification.tool', NotificationTool::Line->value);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_failed_to_send_a_message_when_not_specified_webhook_url()
    {
        Config::set('notification.line.endpoint_url', '');
        Config::set('notification.line.token', '');

        $messageContent = new NotificationMessageContent(
            title: '',
            message: 'sample message',
            keyValueFields: []
        );
        $service = new NotificationToChatToolsService();
        $this->assertFalse($service->notify($messageContent));
    }

    public function test_failed_to_send_a_message_when_not_specified_token()
    {
        Config::set('notification.line.endpoint_url', Env::get('LINE_API_ENDPOINT'));
        Config::set('notification.line.token', '');

        $messageContent = new NotificationMessageContent(
            title: '',
            message: 'sample message',
            keyValueFields: []
        );
        $service = new NotificationToChatToolsService();
        $this->assertFalse($service->notify($messageContent));
    }

    public function test_succeeded_to_send_a_message()
    {
        Config::set('notification.line.endpoint_url', Env::get('LINE_API_ENDPOINT'));
        Config::set('notification.line.token', Env::get('LINE_API_TOKEN'));

        $messageContent = new NotificationMessageContent(
            title: '',
            message: 'sample message',
            keyValueFields: []
        );
        $service = new NotificationToChatToolsService();
        $this->assertTrue($service->notify($messageContent));
    }
}
