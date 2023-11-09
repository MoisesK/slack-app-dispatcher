<?php

namespace Tests\Unit;

use Faker\Factory as Faker;
use Faker\Generator;
use MoisesK\SlackDispatcherPHP\Collection\AttachmentFieldCollection;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentAuthor;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentField;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentFooter;
use MoisesK\SlackDispatcherPHP\Dto\AttachmentTitle;
use MoisesK\SlackDispatcherPHP\Dto\MessageAttachment;
use PHPUnit\Framework\TestCase;

class MessageAttachmentTest extends TestCase
{
    protected static Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        self::$faker = Faker::create('pt_BR');
    }

    public function testItShoudReturnCorrectAttachmentAuthorStringStructure()
    {
        $author = new AttachmentAuthor(
            authorName: 'testCase',
            authorIcon: 'IconeUrl.com'
        );

        $this->assertEquals([
            'author_name' => 'testCase',
            'author_icon' => 'IconeUrl.com'
        ],$author->values());
    }

    public function testItShoudReturnCorrectAttachmentTitleStringStructure()
    {
        $title = new AttachmentTitle(
            title: 'testTitle',
            titleLink: 'IconeUrl.com'
        );

        $this->assertEquals([
            'title' => 'testTitle',
            'title_link' => 'IconeUrl.com'
        ],$title->values());
    }

    public function testItShoudReturnCorrectAttachmentFieldStringStructure()
    {
        $field = new AttachmentField(
            title: 'testField',
            value: 'field',
            short: false
        );

        $this->assertEquals([
            'title' => 'testField',
            'value' => 'field',
            'short' => false
        ],$field->values());
    }

    public function testItShoudReturnCorrectAttachmentFooterStringStructure()
    {
        $footer = new AttachmentFooter(
            footer: 'footerTest',
            footerIcon: 'IconeUrl.com'
        );

        $this->assertEquals([
            'footer' => 'footerTest',
            'footer_icon' => 'IconeUrl.com',
        ],$footer->values());
    }

    public function testItShoudReturnCorrectAttachmentJsonStructure()
    {
        $correctJson = '{"color":"#36a64f","pretext":"Texto de introdução","author_name":"testCase","author_icon":"https://example.com","title":"testTitle","title_link":"https://example.com","text":"Texto do anexo. Você pode usar *negrito*, _itálico_, e [links](https://example.com) no texto.","fields":[{"title":"campo 1","value":"valor 1","short":false}],"image_url":"https://example.com","footer":"Rodapé","footer_icon":"https://example.com","ts":"123456789"}';

        $attachment = new MessageAttachment(
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
        );

        $this->assertJsonStringEqualsJsonString($correctJson, json_encode($attachment));
    }
}