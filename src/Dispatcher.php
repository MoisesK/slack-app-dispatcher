<?php

namespace MoisesK\SlackDispatcherPHP;

use Exception;
use MoisesK\SlackDispatcherPHP\Dto\SlackMessage;

final class Dispatcher
{
    /**
     * You can get webhook url in https://api.slack.com/apps/{app_id}/incoming-webhooks?
     */
    public function __construct(
        private readonly string $webhookUrl
    ) {
    }

    public function send(SlackMessage $message): void
    {
        $ch = curl_init($this->webhookUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            throw new Exception($error);
        }

        curl_close($ch);
    }
}