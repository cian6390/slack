<?php

namespace Cian\Slack\Messages;

/**
 * Properties description basically copy from slack document.
 * https://api.slack.com/docs/message-attachments
 * 
 * if something changed but I dodn't update, feel free to create a PR.
 */

class AttachmentField
{
    /**
     * Shown as a bold heading above the value text.
     * It cannot contain markup and will be escaped for you.
     * 
     * @var string $title
     */
    public $title;

    /**
     * Shown as a bold heading above the value text.
     * It cannot contain markup and will be escaped for you.
     * 
     * @var string $value
     */
    public $value;

    /**
     * Shown as a bold heading above the value text.
     * It cannot contain markup and will be escaped for you.
     * 
     * @var string $short
     */
    public $short;

    public function __get($key)
    {
        return $this->$key;
    }

    public function __set($key, $value)
    {
        return $this->$key = $value;
    }
}