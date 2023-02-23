<?php

namespace Zaxxas\NotifyToChatTools\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationToChatToolFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'notificationToChatTool';
    }
}
