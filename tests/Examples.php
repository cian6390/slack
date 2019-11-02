<?php

namespace Cian\Slack\Tests;

use Cian\Slack\Tests\TestCase;
use Cian\Slack\Message;
use Cian\Slack\IncomingWebhook;
use Cian\Slack\InteractiveMessage;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

class Examples extends TestCase
{
    protected $url = '';

    protected $token = '';

    public function case_1()
    {
        $message = 'HiHi!!';

        (new IncomingWebhook)->send($message, $this->url);
    }

    public function case_2()
    {
        // $channel can be channel_name, channel_id, user_slack_id
        // but slack suggest don't use channel_name.
        $channel = 'development';
        $message = 'Hello Interactive Message!';

        (new InteractiveMessage)
            ->setToken($this->token)
            ->to($channel)
            ->send($message);
    }

    public function case_3()
    {
        $builder = (new BlockBuilder)
            ->section('*A Title Here*')
            ->section('body content ...')
            ->divider()
            ->section('😗😗😗');

        (new IncomingWebhook)->send($builder, $this->url);
    }

    public function case_4()
    {
        $blockBuilder = (new BlockBuilder)->section('How are you?');

        // when you provide block builder as the first argument
        // then the second argument color will be applied
        // the color can be 'good', 'warning', 'danger' or any valid hex color code.
        $attachments = (new AttachmentBuilder($blockBuilder, '#ff0000'));

        $url = 'https://hooks.slack.com/services/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';

        (new IncomingWebhook)->send($attachments, $url);
    }

    public function case_5()
    {
        $attachments = (new AttachmentBuilder)->add([
            'text' => '😗😗😗',
            'fallback' => 'fall back text...',
            'footer' => 'footer text...',
            // ... more legacy fields
        ]);

        $url = 'https://hooks.slack.com/services/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';
        
        (new IncomingWebhook)
            ->send($attachments, $url);
    }

    public function case_6()
    {
        $titleBlocker = (new BlockBuilder)
            ->section('Title row 😗😗😗');

        $bodyBlocker = (new BlockBuilder)
            ->section('body content ...')
            ->divider();

        $attachmenter = (new AttachmentBuilder($bodyBlocker, '#ff00ff'));

        $message = new Message($titleBlocker);

        $message->setAttachments($attachmenter);

        $url = 'https://hooks.slack.com/services/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';

        (new IncomingWebhook)
            ->send($message, $url);
    }
}
