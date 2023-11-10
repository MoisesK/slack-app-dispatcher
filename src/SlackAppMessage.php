<?php

namespace MoisesK\SlackDispatcherPHP;

use Exception;
use JsonSerializable;
use MoisesK\SlackDispatcherPHP\Collection\MessageAttachmentCollection;

final class SlackAppMessage implements JsonSerializable
{
    protected string $text;
    protected MessageAttachmentCollection $attachments;

    /**
     * For get our app webhook url:
     * @see https://api.slack.com/apps
     * @param string $webhookUrl
     */
    public function __construct(
        private readonly string $webhookUrl
    ) {
        $this->attachments = new MessageAttachmentCollection();
    }

    public function setHeaderText(string $text) {
        $this->text = $text;
    }

    public function addAttachment(Attachment $attachment): void
    {
        $this->attachments->offsetSet(null, value: $attachment);
    }

    public function jsonSerialize(): array
    {
        return $this->values();
    }

    public function values(): array
    {
        $values = get_object_vars($this);
        foreach ($values as $property => $value) {
            if (is_null($value)) {
                unset($values[$property]);
                continue;
            }

            $newPropertyName = mb_strtolower(
                preg_replace('/(?<!^)[A-Z]/', '_$0', $property)
            );

            if ($newPropertyName !== $property) {
                $values[$newPropertyName] = $value;
                unset($values[$property]);
            }
        }

        return $values;
    }

    public function dispatch(): void
    {
        $ch = curl_init($this->webhookUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this));
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