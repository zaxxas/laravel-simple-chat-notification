<?php

namespace Zaxxas\NotifyToChatTools\Services;

use Zaxxas\NotifyToChatTools\Enums\NotificationTool;
use Zaxxas\NotifyToChatTools\Dtos\NotificationMessageContent;
use Log;
use Illuminate\Support\Facades\Config;

class NotificationToChatToolsService
{
    /**
     * Notify to the given tool.
     * @param NotificationMessageContent $messageContent
     * @return boolean
     */
    public function notify(NotificationMessageContent $messageContent): bool
    {
        $notificationTool = NotificationTool::tryFrom(config('notification.tool'));
        if (empty($notificationTool)) {
            throw new \Exception("Invalid Notification Tool is specified. Please check values of .env file.");
        }

        $toolService = $this->createNotificationInstance($notificationTool);
        try {
            return $toolService->send($messageContent);
        } catch (\Exception $e) {
            Log::error("Failed to notfy.", [
                "tool" => $notificationTool,
                "messageContent" => $messageContent,
                "e" => $e
            ]);
            return false;
        }
    }

    /**
     * Create Service Instance corresponding to the given tool.
     * @param NotificationTool $tool
     * @return NotificationServiceInterface
     */
    private function createNotificationInstance(NotificationTool $tool): NotificationServiceInterface
    {
        switch ($tool->value) {
            case NotificationTool::Slack->value:
                return new SlackNotificationService();
            case NotificationTool::Teams->value:
                return new TeamsNotificationService();
            case NotificationTool::Line->value:
                return new LineNotificationService();
            default:
                throw new \Exception("Invalid Notification Tool");
        }
    }
}
