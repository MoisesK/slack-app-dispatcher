<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

use JsonSerializable;

final class AttachmentFooter implements JsonSerializable
{
    public function __construct(
        private readonly ?string $footer,
        private readonly ?string $footerIcon,
    ) {
    }

    public function __get(string $field): mixed
    {
        return $this->$field;
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