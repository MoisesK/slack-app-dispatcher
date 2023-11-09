<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

final class AttachmentField extends AttachmentComponent
{
    public function __construct(
        protected readonly ?string $title,
        protected readonly ?string $value,
        protected readonly bool $short = false,
    ) {
    }
}