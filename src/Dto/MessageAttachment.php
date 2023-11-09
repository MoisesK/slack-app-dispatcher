<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

use DateTimeInterface;
use Exception;
use JsonSerializable;
use MoisesK\SlackDispatcherPHP\Collection\AttachmentFieldCollection;

final class MessageAttachment implements JsonSerializable
{
    public function __construct(
        protected readonly ?string $color,
        protected readonly ?string $pretext,
        protected readonly ?AttachmentAuthor $author,
        protected readonly ?AttachmentTitle $title,
        protected readonly ?string $text,
        protected readonly ?AttachmentFieldCollection $fields,
        protected readonly ?string $imageUrl,
        protected readonly ?AttachmentFooter $footer,
        protected readonly string | DateTimeInterface | null $ts,
    ) {
    }

    public function values(): array
    {
        $values = get_object_vars($this);
        foreach ($values as $property => $value) {
            if ($value instanceof JsonSerializable && $property !== 'fields') {
                $newFields = $value->values();
                unset($values[$property]);
                foreach ($newFields as $newProperty => $newValue) {
                    $values[$newProperty] = $newValue;
                }
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

    public function get(string $property): mixed
    {
        $getter = "get" . ucfirst($property);

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        if (!property_exists($this, $property)) {
            throw new Exception("Property Not Exists {$property}");
        }

        return $this->{$property};
    }

    public function jsonSerialize(): mixed
    {
        return $this->values();
    }
}