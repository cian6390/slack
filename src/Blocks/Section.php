<?php

namespace Cian\Slack\Blocks;

use Block;

class Section extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'section';

    public $text = '';

    /**
     * A string acting as a unique identifier for a block.
     * You can use this block_id when you receive an interaction payload to identify the source of the action.
     * If not specified, a block_id will be generated.
     * Maximum length for this field is 255 characters.
     * 
     * @var string|null Optional.
     */
    public $blockId;

    public $fields = [];

    public $accessory;

    public function toArray()
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
            'block_id' => $this->blockId,
            'fields' => $this->fields,
            'accessory' => $this->accessory
        ];
    }
}
