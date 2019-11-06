<?php

namespace Cian\Slack\Messages;

use Cian\Slack\Messages\Message;

/**
 * Properties description basically copy from slack document.
 * https://api.slack.com/reference/block-kit/composition-objects#text
 * 
 * if something changed but I dodn't update, feel free to create a PR.
 */

class TextObject extends Message
{
    /**
     * The formatting to use for this text object.
     * Can be one of plain_textor mrkdwn.
     * 
     * @var string $type
     */
    public $type = 'mrkdwn';

    /**
     * The text for the block.
     * This field accepts any of the standard text formatting markup when type is mrkdwn.
     * 
     * @var string $text
     */
    public $text = '';

    /**
     * Indicates whether emojis in a text field should be escaped into the colon emoji format.
     * This field is only usable when type is plain_text.
     * 
     * @var bool $emoji
     */
    public $emoji = true;

    /**
     * When set to false (as is default) URLs will be auto-converted into links,
     * conversation names will be link-ified, and certain mentions will be automatically parsed. 
     * Using a value of true will skip any preprocessing of this nature,
     * although you can still include manual parsing strings.
     * This field is only usable when type is mrkdwn.
     */
    public $verbatim = false;

    /**
     * Property $type setter.
     * 
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Property $text setter.
     * 
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Property $emoji setter.
     * 
     * @return $this
     */
    public function setEmoji($emoji)
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * Property $verbatim setter.
     * 
     * @return $this
     */
    public function setVerbatim($verbatim)
    {
        $this->verbatim = $verbatim;

        return $this;
    }

    /**
     * Return this as key value array.
     * 
     * @return array
     */
    public function toArray() : array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
            'emoji' => $this->emoji,
            'verbatim' => $this->verbatim
        ];
    }
}