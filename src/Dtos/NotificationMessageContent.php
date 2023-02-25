<?php

namespace Zaxxas\NotifyToChatTools\Dtos;

/**
 * This is a dto class of message content.
 */
class NotificationMessageContent
{
    /**
     * title of message.
     * @var string|null
     */
    public readonly ?string $title;
    /**
     * body content of message.
     * @var string|null
     */
    public readonly ?string $message;
    /**
     * key value fields, such as below.
     * - name => 'John Smith',
     * - email => 'john.smith@example.com
     * @var array|null
     */
    public readonly ?array $keyValueFields;

    public function __construct(?string $title, ?string $message, array $keyValueFields = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->keyValueFields = $keyValueFields;
    }
}
