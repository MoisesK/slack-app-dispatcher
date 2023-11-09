<?php

namespace MoisesK\SlackDispatcherPHP\Collection;

use ArrayAccess;
use Countable;
use Iterator;
use JsonSerializable;
use MoisesK\SlackDispatcherPHP\Attachment;
use RuntimeException;

final class MessageAttachmentCollection implements ArrayAccess, Countable, Iterator, JsonSerializable
{
    public function __construct(
        protected array $items = [],
    ) {
    }

    protected function className(): string
    {
        return Attachment::class;
    }

    public function offsetExists($offset): bool
    {
        if (!is_numeric($offset) or !isset($this->items[$offset])) {
            return false;
        }

        return true;
    }

    public function offsetGet($offset): mixed
    {
        if (!isset($this->items[$offset])) {
            return null;
        }

        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $className = $this->className();

        if (!$value instanceof $className) {
            throw new RuntimeException("'{$value}' is not type of '{$className}' in collection.");
        }

        if (is_null($offset)) {
            $this->items[] = $value;
            return;
        }

        if (!is_numeric($offset) or (!$offset and $offset !== 0)) {
            return;
        }

        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function key(): int
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        $key = key($this->items);
        return ($key !== null);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }
}