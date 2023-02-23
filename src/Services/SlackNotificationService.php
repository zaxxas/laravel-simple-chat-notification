<?php

namespace Zaxxas\NotifyToChatTools\Services;

use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use Psr\Http\Client\ClientInterface;

class SlackNotificationService extends NotificationService
{
    private readonly string $defaultChannel;
    private readonly string $username;

    public function __construct(ClientInterface $http)
    {
        parent::__construct($http);

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
        return config('notification.teams.webhook_url');
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
            'Content-Type' => 'application/json'
        ];
    }
}
