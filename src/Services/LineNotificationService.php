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
     * @return string|null
     */
    public function buildJsonPayload(NotificationMessageContent $content): array
    {
        return [
            'message' => $content->message,
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
     * @override
     * @return string|null
     */
    public function url(): ?string
    {
        return config('notification.line.endpoint_url');
    }

    /**
     * @override
     * @return array
     */
    public function postHeader(): array|string
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            "Authorization" => "Bearer {$this->token}",
        ];
    }
}
