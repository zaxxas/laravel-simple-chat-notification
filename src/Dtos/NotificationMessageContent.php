<?php

namespace Zaxxas\NotifyToChatTools\Dtos;

class NotificationMessageContent
{
    readonly ?string $title;
    readonly ?string $message;
    readonly ?array $keyValueFields;
    readonly ?array $options;

    public function __construct(?string $title, ?string $message, array $keyValueFields = [], array $options = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->keyValueFields = $keyValueFields;
        $this->options = $options;
    }
}
