<?php

namespace Zaxxas\NotifyToChatTools\Services;

use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;

interface NotificationServiceInterface
{
    public function send(NotificationMessageContent $content): bool;
}
