<?php

namespace Cian\Slack\Builders;

use Cian\Slack\Builders\BlockBuilder;

class AttachmentBuilder
{
    protected $attachments = [];

    public function __construct($attachment = null, $color = null)
    {
        if (!is_null($attachment)) {
            $this->add($attachment, $color);
        }
    }

    public function add($attachment, $color = null)
    {
        $blockBuilderClass = BlockBuilder::class;
        if ($attachment instanceof $blockBuilderClass) {
            $attachment = [
                'blocks' => $attachment->toArray()
            ];
            if (!is_null($color)) {
                $attachment['color'] = $color;
            }
            $this->attachments[] = $attachment;
            return $this;
        } elseif (is_array($attachment)) {
            $this->attachments[] = $attachment;
            return $this;
        }

        throw new InvalidArgumentException("add method first argument must be instance of {$blockBuilderClass} or a literal array with valid attachment schema.");
    }

    public function toArray()
    {
        return $this->attachments;
    }

    public function clear()
    {
        $this->attachments = [];

        return $this;
    }

    public function get($index = null)
    {
        if (!is_null($index)) {
            return $this->attachments[$index] ?? null;
        }

        return $this->attachments;
    }

    public function first()
    {
        return $this->get(0);
    }
}
