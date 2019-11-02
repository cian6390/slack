<?php

namespace Cian\Slack;

use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

class Message
{
    protected $text = null;
    protected $mrkdwn = true;
    protected $thread_ts = null;
    protected $blocks = [];
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

    public function setMarkdown(bool $value)
    {
        $this->mrkdwn = $value;

        return $this;
    }

    public function getMarkdown()
    {
        return $this->mrkdwn;
    }

    public function setThreadTs($value)
    {
        $this->thread_ts = $value;

        return $this;
    }

    public function getThreadTs()
    {
        return $this->thread_ts;
    }

    public function setText($message)
    {
        $this->text = $message;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setAttachments($value)
    {
        if (is_a($value, AttachmentBuilder::class)) {
            $this->attachments = $value->toArray();
        } else {
            $this->attachments = $value;
        }

        return $this;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function setBlocks($value)
    {
        if (is_a($value, BlockBuilder::class)) {
            $this->blocks = $value->toArray();
        } else {
            $this->blocks = $value;
        }

        return $this;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }

    public function toArray()
    {
        $result = [];

        if (count($this->blocks)) {
            $result['blocks'] = $this->blocks;
        }

        if (count($this->attachments)) {
            $result['attachments'] = $this->attachments;
        }

        if ($this->thread_ts) {
            $result['thread_ts'] = $this->thread_ts;
        }

        if ($this->mrkdwn) {
            $result['mrkdwn'] = $this->mrkdwn;
        }

        if ($this->text) {
            $result['text'] = $this->text;
        }

        return $result;
    }
}
