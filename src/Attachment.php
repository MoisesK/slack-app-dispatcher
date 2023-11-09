<?php

namespace MoisesK\SlackDispatcherPHP;

use DateTimeInterface;
use Exception;
use JsonSerializable;
use MoisesK\SlackDispatcherPHP\Collection\AttachmentFieldCollection;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentAuthor;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentComponent;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentFooter;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentTitle;

final class Attachment implements JsonSerializable
{
    protected ?string $color = null;
    protected ?string $pretext = null;
    protected ?AttachmentAuthor $author = null;
    protected ?AttachmentTitle $title = null;
    protected ?string $text = null;
    protected ?AttachmentFieldCollection $fields = null;
    protected ?string $imageUrl = null;
    protected ?AttachmentFooter $footer = null;
    protected string | DateTimeInterface | null $ts = null;

    public function __construct(?array $attributes = []
    ) {
        foreach ($attributes as $field => $value) {
            if (!property_exists($this, $field)) {
                continue;
            }

            $this->$field = $value;
        }
    }

    /**
     * Set the color of the attachment.
     * Valid examples of colors:
     * - "#FF0000" for solid red.
     * - "#00FF00" for solid green.
     *
     * @param string|null $color The color to be set. Use null to remove the existing color.
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * Set the preamble text of the attachment.
     * @param string|null $pretext The preamble text to be set. Use null to remove the existing preamble text.
     */
    public function setPretext(?string $pretext): void
    {
        $this->pretext = $pretext;
    }

    /**
     * Set the author of the attachment.
     *
     * @param AttachmentAuthor|null $author The author to be set. Use null to remove the existing author.
     */
    public function setAuthor(?AttachmentAuthor $author): void
    {
        $this->author = $author;
    }

    /**
     * Set the title of the attachment.
     *
     * @param AttachmentTitle|null $title The title to be set. Use null to remove the existing title.
     */
    public function setTitle(?AttachmentTitle $title): void
    {
        $this->title = $title;
    }

    /**
     * Set the text of the attachment.
     *
     * @param string|null $text The text to be set. Use null to remove the existing text.
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * Set the collection of fields of the attachment.
     *
     * @param AttachmentFieldCollection|null $fields The collection of fields to be set. Use null to remove the existing collection of fields.
     */
    public function setFields(?AttachmentFieldCollection $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * Set the image URL of the .
     *
     * @param string|null $imageUrl The image URL to be set. Use null to remove the existing image URL.
     */
    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * Set the footer of the attachment.
     *
     * @param AttachmentFooter|null $footer The footer to be set. Use null to remove the existing footer.
     */
    public function setFooter(?AttachmentFooter $footer): void
    {
        $this->footer = $footer;
    }

    /**
     * Set the timestamp of the attachment.
     *
     * @param string|DateTimeInterface|null $ts The timestamp to be set.
     */
    public function setTs(string | DateTimeInterface | null $ts): void
    {
        $this->ts = $ts;
    }

    public function toArray(): array
    {
        $values = get_object_vars($this);
        foreach ($values as $property => $value) {
            if (is_null($value)) {
                continue;
            }

            unset($values[$property]);
            if ($value instanceof AttachmentComponent) {
                $attributeFields = $value->values();

                foreach ($attributeFields as $newProperty => $newValue) {
                    if (is_null($value)) {
                        continue;
                    }

                    $newPropertyName = mb_strtolower(
                        preg_replace('/(?<!^)[A-Z]/', '_$0', $newProperty)
                    );

                    $values[$newPropertyName] = $newValue;
                }

                continue;
            }

            if ($value instanceof AttachmentFieldCollection) {
                $attributeFields = array_map(fn ($field) => $field->values(), $value->jsonSerialize());
                $values[$property] = $attributeFields;

                continue;
            }

            $newPropertyName = mb_strtolower(
                preg_replace('/(?<!^)[A-Z]/', '_$0', $property)
            );

            $values[$newPropertyName] = $value;
        }

        return $values;
    }

    public function __get(string $property): mixed
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
        return $this->toArray();
    }
}