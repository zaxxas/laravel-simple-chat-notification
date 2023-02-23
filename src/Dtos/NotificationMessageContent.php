<?php

namespace Zaxxas\NotifyToChatTools\Dtos;

class NotificationMessageContent
{
    public readonly ?string $title;
    public readonly ?string $message;
    public readonly ?array $keyValueFields;
    public readonly ?array $options;

    public function __construct(?string $title, ?string $message, array $keyValueFields = [], array $options = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->keyValueFields = $keyValueFields;
        $this->options = $options;
    }
}
