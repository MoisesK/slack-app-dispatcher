<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

use JsonSerializable;

abstract class AttachmentComponent implements JsonSerializable
{
    public function values(): array
    {
        $values = get_object_vars($this);
        foreach ($values as $property => $value) {
            if (is_null($value)) {
                continue;
            }

            $newPropertyName = mb_strtolower(
                preg_replace('/(?<!^)[A-Z]/', '_$0', $property)
            );
            unset($values[$property]);

            $values[$newPropertyName] = $value;
        }

        return $values;
    }

    public function jsonSerialize(): mixed
    {
        return $this->values();
    }

    public function __get(string $field): mixed
    {
        return $this->$field;
    }
}