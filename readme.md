# SLACK MESSAGE DISPATCHER

##### Publicador de mensagem para canal no SLACK

## Instalação

#### Para realizar a instalação desta dependência basta executar o seguinte comando:
```shell
composer require moises-kalebe/slack-dispatcher-php
```

## Utilização
#### Antes de tudo você precisara se direcionar ao site do slack e pegar a url do seu app.

exemplo de onde encontrar a url:

<img height="" src="assets/readme/token_locale_example.png" width=""/>

Link exemplo:
```
https://api.slack.com/apps/{APP_ID}/incoming-webhooks?success=1
```

#### Apos obter este link do webhook do app você podera prosseguir definindo apenas a conexão e os detalhes da mensagem a ser enviada.


```php
<?php

declare(strict_types=1);

use MoisesK\SlackDispatcherPHP\Attachment;
use MoisesK\SlackDispatcherPHP\Collection\AttachmentFieldCollection;
use MoisesK\SlackDispatcherPHP\MessageDispatcher;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentAuthor;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentField;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentFooter;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentTitle;
use MoisesK\SlackDispatcherPHP\SlackMessage;

require __DIR__ . '/vendor/autoload.php';

$attachment = new Attachment([
    'color' => '#36a64f',
    'pretext' => 'Este e o Pretexto do anexo',
    'author' => new AttachmentAuthor(
        authorName: 'Nome do Autor',
        authorIcon: "https://example.com"
    ),
    'title' => new AttachmentTitle(
        title: 'Titulo do anexo',
        titleLink: "https://example.com"

    ),
    'text' => 'Texto do anexo. Você pode usar *negrito*, _itálico_, e [links](https://example.com) no texto.',
    'fields' => new AttachmentFieldCollection([
        new AttachmentField(
            title: 'campo 1',
            value: 'valor 1',
            short: false
        )
    ]),
    'imageUrl' => "https://example.com",
    'footer' => new AttachmentFooter(
        footer: 'Rodapé do anexo',
        footerIcon: "https://example.com"
    ),
    'ts' => '123456789'
]);

// CRIE UMA INSTÂNCIA DE MENSAGEM
$slackMessage = new SlackMessage();

// DEFINA O TEXTO DE TITULO DA MENSAGEM
$slackMessage->setText('Texto da Mensagem');

// ADICIONE UM ANEXO/ATTACHMENT
$slackMessage->addAttachment($attachment);

// DEFINA A CONEXÃO COM A URL DO HOOK DO APP
$dispatcher = new MessageDispatcher('https://hooks.slack.com/services/.....');

// ENVIE A MENSAGEM PARA O CANAL DO SLACK
$dispatcher->send($slackMessage);
```

#### Veja um exemplo de como sua mensagem ira ficar:

<img src="assets/readme/message_example.png" title="exemplo do corpo final da mensagem:"/>

## Requisitos

Necessario PHP 8.1+