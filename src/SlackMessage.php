<?php

namespace MoisesK\SlackDispatcherPHP;

use JsonSerializable;
use MoisesK\SlackDispatcherPHP\Collection\MessageAttachmentCollection;

final class SlackMessage implements JsonSerializable
{
    protected string $text;
    protected MessageAttachmentCollection $attachments;

    public function __construct()
    {
        $this->attachments = new MessageAttachmentCollection();
    }

    public function setText(string $text) {
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
}