<?php

namespace Cian\Slack\Blocks;

use Block;

class Context extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'context';

    /**
     * A string acting as a unique identifier for a block.
     * You can use this block_id when you receive an interaction payload to identify the source of the action.
     * If not specified, a block_id will be generated.
     * Maximum length for this field is 255 characters.
     * 
     * @var string|null Optional.
     */
    public $blockId;

    /**
     * An array of image elements and text objects.
     * Maximum number of items is 10.
     * 
     * @var array[] Required.
     */
    public $elements = [];

    public function toArray()
    {
        return [
            'type' => $this->type,
            'block_id' => $this->blockId,
            'elements' => $this->elements
        ];
    }
}
