<?php

namespace Zaxxas\NotifyToChatTools\Enums;

enum NotificationTool: string
{
    case Teams = 'teams';
    case Slack = 'slack';
    case Line = 'line';
}
