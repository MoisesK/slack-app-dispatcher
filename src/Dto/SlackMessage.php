<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

use JsonSerializable;
use MoisesK\SlackDispatcherPHP\Collection\MessageAttachmentCollection;

final class SlackMessage implements JsonSerializable
{
    protected string $message;

    public function __construct(
        protected readonly string $text,
        protected readonly MessageAttachmentCollection $attachments
    ){
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