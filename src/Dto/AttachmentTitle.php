<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

final class AttachmentTitle extends AttachmentComponent
{
    public function __construct(
        protected readonly ?string $title,
        protected readonly ?string $titleLink,
    ) {
    }
}