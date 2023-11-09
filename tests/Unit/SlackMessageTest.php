<?php

use Faker\Factory as Faker;
use Faker\Generator;
use MoisesK\SlackDispatcherPHP\Attachment;
use MoisesK\SlackDispatcherPHP\Collection\AttachmentFieldCollection;
use MoisesK\SlackDispatcherPHP\Collection\MessageAttachmentCollection;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentAuthor;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentField;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentFooter;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentTitle;
use MoisesK\SlackDispatcherPHP\SlackMessage;
use PHPUnit\Framework\TestCase;

class SlackMessageTest extends TestCase
{
    protected static Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        self::$faker = Faker::create('pt_BR');
    }

    public function testItShoudReturnCorrectSlackMessageJsonStructure()
    {
        $correctString = '{"text":"Alerta Teste","attachments":[{"color":"#36a64f","pretext":"Texto de introdu\u00e7\u00e3o","author_name":"testCase","author_icon":"https:\/\/example.com","title":"testTitle","title_link":"https:\/\/example.com","text":"Texto do anexo. Voc\u00ea pode usar *negrito*, _it\u00e1lico_, e [links](https:\/\/example.com) no texto.","fields":[{"title":"campo 1","value":"valor 1","short":false}],"image_url":"https:\/\/example.com","footer":"Rodap\u00e9","footer_icon":"https:\/\/example.com","ts":"123456789"}]}';
        $attachment = new Attachment([
                'color' => '#36a64f',
                'pretext' => 'Texto de introdução',
                'author' => new AttachmentAuthor(
                    authorName: 'testCase',
                    authorIcon: "https://example.com"
                ),
                'title' => new AttachmentTitle(
                    title: 'testTitle',
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
                    footer: 'Rodapé',
                    footerIcon: "https://example.com"
                ),
                'ts' => '123456789'
            ]);

        $slackMessage = new SlackMessage();
        $slackMessage->setText('Alerta Teste');
        $slackMessage->addAttachment($attachment);

        $this->assertJsonStringEqualsJsonString($correctString, json_encode($slackMessage));
    }
}