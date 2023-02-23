<?php

namespace Zaxxas\NotifyToChatTools\Providers;

use Zaxxas\NotifyToChatTools\Services\NotificationToChatToolsService;
use Zaxxas\NotifyToChatTools\Services\SlackNotificationService;
use Zaxxas\NotifyToChatTools\Services\TeamsNotificationService;
use Zaxxas\NotifyToChatTools\Services\LineNotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/notification.php' => config_path('notification.php'),
        ]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("notificationToChatTool", function () {
            return new NotificationToChatToolsService();
        });
        $this->app->bind(SlackNotificationService::class, function ($app) {
            return new SlackNotificationService(new \GuzzleHttp\Client());
        });
        $this->app->bind(TeamsNotificationService::class, function ($app) {
            return new TeamsNotificationService(new \GuzzleHttp\Client());
        });
        $this->app->bind(LineNotificationService::class, function ($app) {
            return new LineNotificationService(new \GuzzleHttp\Client());
        });
    }
}
