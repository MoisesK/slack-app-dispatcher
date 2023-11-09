<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

use JsonSerializable;

final class AttachmentAuthor implements JsonSerializable
{
    public function __construct(
        private readonly ?string $authorName,
        private readonly ?string $authorIcon,
    ) {
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

    public function jsonSerialize(): mixed
    {
        return $this->values();
    }
}