<?php

namespace Cian\Slack;

use Cian\Slack\ArrayObject;

class AttachmentField extends ArrayObject
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