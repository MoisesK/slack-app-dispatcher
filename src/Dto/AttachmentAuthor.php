<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

final class AttachmentAuthor extends AttachmentComponent
{
    public function __construct(
        protected readonly ?string $authorName,
        protected readonly ?string $authorIcon,
    ) {
    }
}