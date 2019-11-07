<?php

namespace Cian\Slack;

use Cian\Slack\Attachment;
use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

use Cian\Slack\ArrayObject;

class Message extends ArrayObject
{
    /**
     * @var string $string
     */
    protected $text = null;

    /**
     * @var bool $mrkdwn
     */
    protected $mrkdwn = true;

    /**
     * @var string|null $thread_ts
     */
    protected $thread_ts = null;

    /**
     * @var array[] $blocks
     */
    protected $blocks = [];

    /**
     * @var array[] $attachments
     */
    protected $attachments = [];

    public function __construct($message = null, $enableMarkdownForText = true)
    {
        if (is_string($message)) {
            $this->text = $message;
            $this->mrkdwn = $enableMarkdownForText;
        } elseif (is_a($message, BlockBuilder::class)) {
            $this->setBlocks($message);
        } elseif (is_a($message, AttachmentBuilder::class)) {
            $this->setAttachments($message);
        } elseif (is_array($message)) {
            foreach ($message as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    public function context(callable $callback)
    {
        $this->blocks[] = $block = new ContextBlock;
        $callback($block);
        return $this;
    }

    public function section(callable $callback)
    {
        $this->blocks[] = $block = new SectionBlock;
        $callback($block);
        return $this;
    }

    public function actions(callable $callback)
    {
        $this->blocks[] = $block = new ActionsBlock;
        $callback($block);
        return $this;
    }

    public function image(callable $callback)
    {
        $this->blocks[] = $block = new ImageBlock;
        $callback($block);
        return $this;
    }

    public function input(callable $callback)
    {
        $this->blocks[] = $block = new InputBlock;
        $callback($block);
        return $this;
    }

    public function divider(callable $callback)
    {
        $this->blocks[] = $block = new Divider;
        $callback($block);
        return $this;
    }

    /**
     * Define an attachment for the message.
     *
     * @param callable  $callback
     * @return $this
     */
    public function attachment(callable $callback)
    {
        $this->attachments[] = $attachment = new SlackAttachment;
        $callback($attachment);
        return $this;
    }

    /**
     * Toggle on/off markdown format.
     * 
     * @param bool $value
     * @return $this
     */
    public function markdown(bool $value)
    {
        $this->mrkdwn = $value;

        return $this;
    }

    /**
     * Property $thread_ts setter.
     * 
     * @param  string|null $value
     * @return $this
     */
    public function threadTs($value)
    {
        $this->thread_ts = $value;

        return $this;
    }

    /**
     * Property $text setter.
     * 
     * @param string|null $text
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Property $attachments setter.
     * 
     * @param \Cian\Slack\Builders\AttachmentBuilder|array $attachable
     * @return $this
     */
    public function attachments($attachable)
    {
        if (is_a($attachable, AttachmentBuilder::class)) {
            $this->attachments = $attachable->toArray();
        } else {
            $this->attachments = $attachable;
        }

        return $this;
    }

    public function blocks($value)
    {
        if (is_a($value, BlockBuilder::class)) {
            $this->blocks = $value->toArray();
        } else {
            $this->blocks = $value;
        }

        return $this;
    }

    /**
     * Convert instance to slack message valid array schame.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'text' => $this->text,
            'mrkdwn' => $this->mrkdwn,
            'thread_ts' => $this->threadTs,
            'attachments' => $this->attachments,
            'blocks' => $this->blocks
        ];
    }
}
