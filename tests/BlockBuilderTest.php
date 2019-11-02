<?php

namespace Cian\Slack\Tests;

use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Tests\TestCase;

class BlockBuilderTest extends TestCase
{
    /** @test */
    public function it_can_make_section_block_staticky()
    {
        $this->assertEquals([
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'Hello ~'
            ]
        ], BlockBuilder::makeSection('Hello ~'));
    }

    /** @test */
    public function it_can_make_actions_block_staticky()
    {
        $this->assertEquals([
            'type' => 'actions',
            'elements' => []
        ], BlockBuilder::makeActions([]));
    }

    /** @test */
    public function it_can_make_divider_block_staticky()
    {
        $this->assertEquals([
            'type' => 'divider',
        ], BlockBuilder::makeDivider([]));
    }

    /** @test */
    public function it_can_make_file_block_staticky()
    {
        $this->assertEquals([
            'type' => 'file',
            'external_id' => '111',
            'source' => 'remote'
        ], BlockBuilder::makeFile('111'));
    }

    /** @test */
    public function it_can_make_image_block_staticky()
    {
        $this->assertEquals([
            'type' => 'image',
            'image_url' => 'https://images.example.com/dog.jpg',
            'alt_text' => 'my dog.'
        ], BlockBuilder::makeImage([
            'image_url' => 'https://images.example.com/dog.jpg',
            'alt_text' => 'my dog.'
        ]));
    }

    /** @test */
    public function it_can_make_input_block_staticky()
    {
        $this->assertEquals([
            'type' => 'input',
            'label' => 'Name',
            'element' => [
                'type' => 'button',
                'text' => 'Submit',
                'action_id' => 'form_submit'
            ]
        ], BlockBuilder::makeInput([
            'label' => 'Name',
            'element' => [
                'type' => 'button',
                'text' => 'Submit',
                'action_id' => 'form_submit'
            ]
        ]));
    }

    /** @test */
    public function it_can_make_context_block_staticky()
    {
        $this->assertEquals([
            'type' => 'context',
            'elements' => []
        ], BlockBuilder::makeContext([
            'elements' => []
        ]));
    }

    /** @test */
    public function all_block_can_be_chained()
    {
        $builder = new BlockBuilder;

        $builder->section('hello')
            ->file('111')
            ->context([
                'elements' => []
            ])
            ->image([
                'image_url' => 'https://images.example.com/dog.jpg',
                'alt_text' => 'my dog.'
            ])
            ->input([
                'label' => 'Name',
                'element' => [
                    'type' => 'button',
                    'text' => 'Submit',
                    'action_id' => 'form_submit'
                ]
            ])
            ->divider()
            ->actions([]);

        $this->assertCount(7, $builder->get());
    }

    /** @test */
    public function get_method_will_return_spec_block_when_give_index()
    {
        $builder = new BlockBuilder;

        $block = $builder
            ->section('foo')
            ->section('bar')
            ->section('baz')
            ->get(2);
        
        $this->assertEquals('baz', $block['text']['text']);
    }

    /** @test */
    public function clear_method_will_remove_all_blocks_when_no_spec_index()
    {
        $builder = new BlockBuilder;

        $builder->section('hello')->clear();

        $this->assertCount(0, $builder->get());
    }

    /** @test */
    public function clear_method_will_remove_spec_block_when_give_index()
    {
        $builder = new BlockBuilder;

        $builder->section('hello')->section('world')->clear(0);

        $this->assertEquals('world', $builder->get()[0]['text']['text']);
    }
}