<?php

namespace Zaxxas\NotifyToChatTools\Services;

use GuzzleHttp\Client;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

/**
 * Base service class for notification logic.
 */
abstract class NotificationService implements NotificationServiceInterface
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new \GuzzleHttp\Client();
    }

    /**
     * Send message on specified chat tool.
     * @override
     * @param NotificationMessageContent $content
     * @return bool
     */
    public function send(NotificationMessageContent $content): bool
    {
        if (!$this->canSend()) {
            throw new \Exception(
                "Stop to send a message, because of some reasons, for example, lack of needed parameters."
            );
        }
        $result = $this->http->post($this->url(), [
            "header"  => $this->postHeader(),
            "json" => $this->buildJsonPayload($content),
        ]);
        if ($result->getStatusCode() === Response::HTTP_OK) {
            return true;
        }
        \Log::error('Failed to send a message', [
            'status' => $result->getStatusCode(),
            'result' => $result
        ]);
        return false;
    }

    /**
     * Endpoint's url, basically, We assume a webhook url.
     * @return string|null
     */
    abstract protected function url(): ?string;

    /**
     * Build a json payload according to the specification of target tool.
     * @param array $content
     * @return array|null
     */
    abstract protected function buildJsonPayload(NotificationMessageContent $content): ?array;

    /**
     * Header Content when send a message by Http Client tool.
     * @return array|string
     */
    abstract protected function postHeader(): array|string;

    /**
     * Check if the conditions for sending a message are met.
     * We assume that you may override this function for each notification tool.
     * @return boolean
     */
    protected function canSend(): bool
    {
        return !empty($this->url()) && isset($this->http);
    }
}
