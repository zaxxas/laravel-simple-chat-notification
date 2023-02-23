<?php

namespace Zaxxas\NotifyToChatTools\Services;

use GuzzleHttp\Client;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;

abstract class NotificationService
{
    protected Client $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @param [type] $content
     * @return void
     */
    public function send(NotificationMessageContent $content)
    {
        if (!$this->canSend()) {
            throw new \Exception("Stop to send a message, because of some reasons, for example, lack of needed parameters");
        }
        return $this->http->post($this->url(), $this->buildJsonPayload($content));
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    protected abstract function url(): ?string;

    /**
     * Undocumented function
     *
     * @param array $content
     * @return array|null
     */
    protected abstract function buildJsonPayload(NotificationMessageContent $content): ?array;

    /**
     * Undocumented function
     *
     * @return array
     */
    protected abstract function postHeader(): array|string;

    /**
     * Undocumented function
     *
     * @return boolean
     */
    protected function canSend(): bool
    {
        return !empty($this->url());
    }
}
