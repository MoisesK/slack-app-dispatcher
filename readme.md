# SLACK MESSAGE DISPATCHER

Simples dispatch para mensagens do slack adaptado para melhor manuseio.

## Instalação

Para realizar a instalação desta dependência basta executar o seguinte comando:
```shell
composer require moises-kalebe/slack-dispatcher-php
```

## Utilização

```php
<?php

declare(strict_types=1);

use MoisesK\SlackDispatcherPHP\Collection\AttachmentFieldCollection;
use MoisesK\SlackDispatcherPHP\Collection\MessageAttachmentCollection;
use MoisesK\SlackDispatcherPHP\Dispatcher;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentAuthor;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentField;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentFooter;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentTitle;
use MoisesK\SlackDispatcherPHP\Dto\MessageAttachment;
use MoisesK\SlackDispatcherPHP\Dto\SlackMessage;

require __DIR__ . '/vendor/autoload.php';

$attachments = new MessageAttachmentCollection([
    new MessageAttachment(
        color: '#36a64f',
        pretext: 'Texto de introdução',
        author: new AttachmentAuthor(
            authorName: 'testCase',
            authorIcon: "https://example.com"
        ),
        title: new AttachmentTitle(
            title: 'testTitle',
            titleLink: "https://example.com"

        ),
        text: 'Texto do anexo. Você pode usar *negrito*, _itálico_, e [links](https://example.com) no texto.',
        fields: new AttachmentFieldCollection([
            new AttachmentField(
                title: 'campo 1',
                value: 'valor 1',
                short: false
            )
        ]),
        imageUrl: "https://example.com",
        footer: new AttachmentFooter(
            footer: 'Rodapé',
            footerIcon: "https://example.com"
        ),
        ts: '123456789'
    )
]);

$slackMessage = new SlackMessage('Titulo da Mensagem', $attachments);

// Defina a conexão
$dispatcher = new Dispatcher('https://hooks.slack.com/services/.....');

// Dispare a mensagem para o canal
$dispatcher->send($slackMessage);
```

## Requisitos

Necessario PHP 8.1+