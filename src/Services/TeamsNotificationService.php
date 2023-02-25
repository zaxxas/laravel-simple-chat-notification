<?php

namespace Zaxxas\NotifyToChatTools\Services;

use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use GuzzleHttp\Client;

class TeamsNotificationService extends NotificationService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @override
     * @param NotificationMessageContent $content
     * @return array|null
     */
    public function buildJsonPayload(NotificationMessageContent $content): ?array
    {
        // arrange values according to Teams specification
        $arrangedKeyValues = [];
        foreach ($content->keyValueFields as $key => $value) {
            $arrangedKeyValues[] = [
                'name'  => $key,
                'value' => str_replace("\r\n", "\n\n", $value) // \n一つだけだとTeamsのコメント上改行しなかったので二つに。
            ];
        }
        return [
            'title' => $content->title,
            'text'  => $content->message,
            // TODO: make themeColor changable
            'themeColor' => 'BLUE',
            'sections' => [
                [
                    "facts" => $arrangedKeyValues
                ]
            ]
        ];
    }

    /**
     * @override
     * @return string|null
     */
    public function url(): ?string
    {
        return config('notification.teams.webhook_url');
    }

    /**
     * @override
     * @return array|string
     */
    public function postHeader(): array|string
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }
}
