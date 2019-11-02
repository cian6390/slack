<?php

namespace Cian\Slack\Tests;

use Cian\Slack\Message;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;
use Cian\Slack\Tests\TestCase;

class MessageTest extends TestCase
{
    /** @test */
    public function it_allow_just_text_argument_for_construct_and_markdown_default_it_true()
    {
        $message = new Message('Hello !');

        $this->assertEquals([
            'text' => 'Hello !',
            'mrkdwn' => true
        ], $message->toArray());
    }

    /** @test */
    public function mrkdwn_field_setter_and_getter()
    {
        $message = new Message('Hello !');

        $this->assertTrue($message->getMarkdown());

        $message->setMarkdown(false);

        $this->assertFalse($message->getMarkdown());
    }

    /** @test */
    public function thread_ts_field_setter_and_getter()
    {
        $message = new Message('Hello !');

        $this->assertNull($message->getThreadTs());

        $message->setThreadTs('123456');

        $this->assertEquals('123456', $message->getThreadTs());
    }

    /** @test */
    public function text_field_setter_and_getter()
    {
        $message = new Message('Hello !');

        $this->assertEquals('Hello !', $message->getText());

        $message->setText('World !');

        $this->assertEquals('World !', $message->getText());
    }

    /** @test */
    public function blocks_setter_allow_block_builder_instance()
    {
        $blocker = (new BlockBuilder)->section('HiHi!');
        $message = (new Message)->setBlocks($blocker);

        $this->assertEquals([
            'mrkdwn' => true,
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => 'HiHi!'
                    ]
                ]
            ]
        ], $message->toArray());
    }

    /** @test */
    public function blocks_setter_allow_literal_array()
    {
        $message = (new Message)->setBlocks([
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => 'HiHi!'
                ]
            ]
        ]);

        $this->assertEquals([
            'mrkdwn' => true,
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => 'HiHi!'
                    ]
                ]
            ]
        ], $message->toArray());
    }

    /** @test */
    public function attachments_setter_allow_attachment_builder_instance()
    {
        $message = new Message;
        
        $blocker = (new BlockBuilder)->section('Foo');

        $attachmenter = (new AttachmentBuilder)->add($blocker);

        $message->setAttachments($attachmenter);

        $this->assertEquals([
            'mrkdwn' => true,
            'attachments' => [
                [
                    'blocks' => [
                        [
                            'type' => 'section',
                            'text' => [
                                'type' => 'mrkdwn',
                                'text' => 'Foo'
                            ]
                        ]
                    ]
                ]
            ]
        ], $message->toArray());
    }

    /** @test */
    public function attachments_setter_allow_literal_array()
    {
        $message = new Message;

        $message->setAttachments([
            [
                'color' => 'good',
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => [
                            'type' => 'mrkdwn',
                            'text' => 'Foo'
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertEquals([
            'mrkdwn' => true,
            'attachments' => [
                [
                    'color' => 'good',
                    'blocks' => [
                        [
                            'type' => 'section',
                            'text' => [
                                'type' => 'mrkdwn',
                                'text' => 'Foo'
                            ]
                        ]
                    ]
                ]
            ]
        ], $message->toArray());
    }
}