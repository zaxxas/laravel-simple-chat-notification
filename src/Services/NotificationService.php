<?php

namespace Zaxxas\NotifyToChatTools\Services;

use GuzzleHttp\Client;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

abstract class NotificationService
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new \GuzzleHttp\Client();
    }

    /**
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
     * Undocumented function
     *
     * @return string|null
     */
    abstract protected function url(): ?string;

    /**
     * Undocumented function
     *
     * @param array $content
     * @return array|null
     */
    abstract protected function buildJsonPayload(NotificationMessageContent $content): ?array;

    /**
     * Undocumented function
     *
     * @return array
     */
    abstract protected function postHeader(): array|string;

    /**
     * Undocumented function
     *
     * @return boolean
     */
    protected function canSend(): bool
    {
        return !empty($this->url()) && isset($this->http);
    }
}
