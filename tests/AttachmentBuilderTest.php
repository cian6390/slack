<?php

namespace Cian\Slack\Tests;

use Cian\Slack\Tests\TestCase;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

class AttachmentBuilderTest extends TestCase
{
    /** @test */
    public function add_method_allow_block_builder_instance()
    {
        $blockBuilder = (new BlockBuilder)->section('a message');

        $attachmentBuilder = (new AttachmentBuilder)->add($blockBuilder);

        $this->assertEquals([
            [
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => [
                            'type' => 'mrkdwn',
                            'text' => 'a message'
                        ]
                    ]
                ]
            ]
        ], $attachmentBuilder->toArray());
    }

    /** @test */
    public function add_method_allow_literal_array()
    {
        $attachments = (new AttachmentBuilder)
            ->add([
                'color' => 'good',
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => [
                            'type' => 'mrkdwn',
                            'text' => 'a message'
                        ]
                    ]
                ]
            ])->toArray();

        $this->assertEquals([
            [
                'color' => 'good',
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => [
                            'type' => 'mrkdwn',
                            'text' => 'a message'
                        ]
                    ]
                ]
            ]
        ], $attachments);
    }

    /** @test */
    public function clear_method_can_remove_all_attachments()
    {
        $blockBuilder = (new BlockBuilder)->section('a message');

        $attachmentBuilder = (new AttachmentBuilder)->add($blockBuilder);

        $attachments = $attachmentBuilder->toArray();

        $this->assertCount(1, $attachments);

        $attachmentBuilder->clear();

        $attachments = $attachmentBuilder->toArray();

        $this->assertCount(0, $attachments);
    }

    /** @test */
    public function get_method_can_take_specific_index_item()
    {
        $block = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'HiHi~'
            ]
        ];

        $builder = new AttachmentBuilder([
            'blocks' => [$block]
        ]);

        $this->assertEquals([
            'blocks' => [$block]
        ], $builder->get(0));
    }

    /** @test */
    public function get_method_should_return_null_when_index_item_not_exist()
    {
        $builder = new AttachmentBuilder;

        $this->assertNull($builder->get(0));
    }

    /** @test */
    public function first_method_will_return_index_0_item()
    {
        $block = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'HiHi~'
            ]
        ];

        $builder = new AttachmentBuilder([
            'blocks' => [$block]
        ]);

        $this->assertEquals([
            'blocks' => [$block]
        ], $builder->first());
    }
}
