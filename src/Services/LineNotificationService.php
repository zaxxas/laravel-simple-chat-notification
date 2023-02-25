<?php

namespace Zaxxas\NotifyToChatTools\Services;

use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;

class LineNotificationService extends NotificationService
{
    private readonly string $token;

    public function __construct()
    {
        parent::__construct();
        $this->token = config('notification.line.token');
    }

    /**
     * @override
     * @param NotificationMessageContent $content
     * @return array|null
     */
    public function buildJsonPayload(NotificationMessageContent $content): ?array
    {
        return [
            'content' => $content->message,
        ];
    }

    /**
     * @override
     * @return boolean
     */
    protected function canSend(): bool
    {
        return parent::canSend() && !empty($this->token);
    }

    /**
     * Undocumented function
     *
     * @override
     * @return string|null
     */
    public function url(): ?string
    {
        return config('notification.line.endpoint');
    }

    /**
     * Undocumented function
     *
     * @override
     * @return array
     */
    public function postHeader(): array
    {
        $token = config('notification.line.token');
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            "Authorization" => `Bearer ${token}`,
        ];
    }
}
