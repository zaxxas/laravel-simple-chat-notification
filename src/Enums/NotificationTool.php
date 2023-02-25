<?php

namespace Zaxxas\NotifyToChatTools\Enums;

/**
 * Kinds of Notification Chat Tools.
 */
enum NotificationTool: string
{
    case Teams = 'teams';
    case Slack = 'slack';
    case Line = 'line';
}
