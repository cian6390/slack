<?php

namespace Cian\Slack\Blocks;

use Block;
use Cian\Slack\Builders\ElementBuilder;

class Actions extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'actions';

    /**
     * An array of interactive element objects - buttons,
     * select menus, overflow menus,
     * or date pickers. There is a maximum of 5 elements in each action block.
     * 
     * @var array[] Required.
     */
    public $elements = [];
    
    /**
     * A string acting as a unique identifier for a block.
     * You can use this block_id when you receive an interaction payload to identify the source of the action.
     * If not specified, a block_id will be generated.
     * Maximum length for this field is 255 characters.
     * 
     * @var string|null Optional.
     */
    public $blockId;

    public function toArray()
    {
        return [
            'type' => $this->type,
            'block_id' => $this->blockId,
            'elements' => $this->elements
        ];
    }

    /**
     * @param string $text
     * @param string $actionId
     * @param string|number|array $value
     * @param string $style 'default' | 'primary' | 'danger'
     * @param string $type
     */
    public function button(string $text, string $actionId, $value = '', string $style = 'primary', string $type = 'plain_text')
    {
        return ElementBuilder::button($text, $actionId, $value, $style, $type);
    }
}
