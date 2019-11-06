<?php

namespace Cian\Slack\Tests;

use Cian\Slack\Messages\TextObject;
use Cian\Slack\Tests\TestCase;

class TextObjectTest extends TestCase
{
    public function test_to_array_method()
    {
        $text = (new TextObject)->toArray();

        $this->assertEquals([
            'type' => 'mrkdwn',
            'text' => '',
            'emoji' => true,
            'verbatim' => false
        ], $text);
    }

    public function test_can_use_property_like_array()
    {
        $text = new TextObject;
        $text['type'] = 'plain_text';
        $text['text'] = 'Hello World !';
        $text['emoji'] = false;
        $text['verbatim'] = true;

        $this->assertEquals([
            'type' => 'plain_text',
            'text' => 'Hello World !',
            'emoji' => false,
            'verbatim' => true
        ], $text->toArray());
    }

    public function test_setters()
    {
        $text = new TextObject;

        $text->setType('mrkdwn');
        $this->assertEquals('mrkdwn', $text->type);

        $text->setText('foo');
        $this->assertEquals('foo', $text->text);

        $text->setEmoji(false);
        $this->assertEquals(false, $text->emoji);

        $text->setVerbatim(true);
        $this->assertEquals(true, $text->verbatim);
    }
}