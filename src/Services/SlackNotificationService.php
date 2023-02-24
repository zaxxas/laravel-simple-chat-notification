<?php

namespace Zaxxas\NotifyToChatTools\Services;

use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use GuzzleHttp\Client;

class SlackNotificationService extends NotificationService
{
    private readonly ?string $defaultChannel;
    private readonly ?string $username;

    public function __construct()
    {
        parent::__construct();
        $this->defaultChannel = config('notification.slack.channel');
        $this->username = config('notification.slack.username');
    }

    /**
     * @override
     * @param NotificationMessageContent $content
     * @return array|null
     */
    protected function buildJsonPayload(NotificationMessageContent $content): ?array
    {
        $arrangedKeyValues = collect($content->keyValueFields)->map(function ($value, $key) {
            return [
                'title' => $key,
                'value' => $value,
            ];
        });
        return [
            'channel' => $this->defaultChannel,
            // Display "System" if username is not set
            'username' => $this->username || "System",
            'attachments' => [
                [
                    'text'   => $content->message,
                    // TODO: Make color changable
                    'color'  => 'good',
                    "fields" => $arrangedKeyValues
                ]
            ]
        ];
    }

    /**
     * @override
     * @return boolean
     */
    protected function canSend(): bool
    {
        return parent::canSend() && isset($this->defaultChannel);
    }

    /**
     * Undocumented function
     *
     * @override
     * @return string|null
     */
    protected function url(): ?string
    {
        return config('notification.slack.webhook_url');
    }

    /**
     * Undocumented function
     *
     * @override
     * @return array
     */
    protected function postHeader(): array|string
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
    }
}
