<?php

namespace MoisesK\SlackDispatcherPHP\Dto;

final class AttachmentFooter extends AttachmentComponent
{
    public function __construct(
        protected readonly ?string $footer,
        protected readonly ?string $footerIcon,
    ) {
    }
}