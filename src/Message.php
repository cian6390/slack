<?php

namespace Cian\Slack;

use Cian\Slack\Builders\BlockBuilder;
use Cian\Slack\Builders\AttachmentBuilder;

class Message
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

    /**
     * Set enable markdown or not.
     * 
     * @param bool $value
     * @return $this
     */
    public function setMarkdown(bool $value)
    {
        $this->mrkdwn = $value;

        return $this;
    }

    /**
     * Enable markdown value getter.
     * 
     * @return bool
     */
    public function getMarkdown()
    {
        return $this->mrkdwn;
    }

    /**
     * Property $thread_ts setter.
     * 
     * @param  string|null $value
     * @return $this
     */
    public function setThreadTs($value)
    {
        $this->thread_ts = $value;

        return $this;
    }

    /**
     * Property $thread_ts getter.
     * 
     * @return string|null
     */
    public function getThreadTs()
    {
        return $this->thread_ts;
    }

    /**
     * Property $text setter.
     * 
     * @param string|null $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Property $text getter.
     * 
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Property $attachments setter.
     * 
     * @param \Cian\Slack\Builders\AttachmentBuilder|array $attachable
     * @return $this
     */
    public function setAttachments($attachable)
    {
        if (is_a($attachable, AttachmentBuilder::class)) {
            $this->attachments = $attachable->toArray();
        } else {
            $this->attachments = $attachable;
        }

        return $this;
    }

    /**
     * Property $attachments getter.
     * 
     * @return $this 
     */
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

    /**
     * Convert instance to slack message valid array schame.
     * 
     * @return array
     */
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
