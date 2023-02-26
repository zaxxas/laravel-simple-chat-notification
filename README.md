This repository is a library for Laravel to notify business chat tools.
Currently, the following are covered
- Slack (webhook only)
- Teams (webhook only)
- Line ( Line Notify only)

Currently, it can only send notifications synchronously.
Asynchronous support will be added in the future.

## Usage
- Move to root directory of target laravel project.
- Run the commands below
    - Install this library.
        - `composer require zaxxas/laravel-simple-chat-notification`.
    - Publish config file.
        - `php artisan vendor:publish --tag=laravel-simple-chat-notification`
- Change source files below
    - app/ServiceProviders/AppServiceProvider.php
    ```
        'providers' => [
            /*
            * Laravel Framework Service Providers...
            */
            Illuminate\Auth\AuthServiceProvider::class,
            ....
            ....
            \Zaxxas\NotifyToChatTools\Providers\NotificationServiceProvider::class, // -> Add this line
        ],

        'aliases' => Facade::defaultAliases()->merge([
            ....
            'InterventionImage' => Intervention\Image\Facades\Image::class,
            'NotifyToChat' => Zaxxas\NotifyToChatTools\Facades\NotificationToChatToolFacade::class, // -> Add this line
        ])->toArray(),
    ```
- Add environment variables to .env file

    |  variable  |  content  |
    | ---- | ---- |
    |  NOTIFICATION_TOOL* |  Target tool name. One from 'slack', 'teams', 'line'  |
    |  SLACK_WEBHOOK_URL |  Webhook url for slack notification  |
    |  SLACK_NOTIFICATION_CHANNEL |  Channel name for slack notification  |
    |  SLACK_NOTIFICATION_SENDAR_NAME |  Sendar name for slack notification  |
    |  TEAMS_WEBHOOK_URL |  Webhook url for Teams  |
    |  LINE_API_ENDPOINT |  Endpoint url for Line Notify API  |
    |  LINE_API_TOKEN |  Token for Line Notify API |
    
    \* : required

- Add logic of notification (for example, like below.)
    ```
    \NotifyToChat::notify(
        new NotificationMessageContent(
            title: 'sample title',
            message: 'sample message',
            keyValueFields: ['key1' => 'value1', 'key2' => 'value2'],
        )
    );
