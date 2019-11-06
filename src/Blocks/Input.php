<?php

namespace Cian\Slack\Blocks;

use Block;

class Input extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'input';

    /**
     * A label that appears above an input element in the form of a text object
     * that must have type of plain_text.
     * Maximum length for the text in this field is 2000 characters.
     *
     * @var string Required.
     */
    public $label;

    /**
     * An plain-text input element, a select menu element,
     * a multi-select menu element, or a datepicker.
     *
     * @var string Required.
     */
    public $element;

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
     * An optional hint that appears below an input element in a lighter grey.
     * It must be a a text object with a type of plain_text.
     * Maximum length for the text in this field is 2000 characters.
     * 
     * @var array|null Optional.
     */
    public $hint;

    /**
     * A boolean that indicates whether the input element may be empty when a user submits the modal.
     * Defaults to false.
     * 
     * @var bool Optional.
     */
    public $optional = false;

    public function toArray()
    {
        return [
            'type' => $this->type,
            'block_id' => $this->blockId,
            'label' => $this->label,
            'element' => $this->element,
            'hint' => $this->hint,
            'optional' => $this->optional
        ];
    }
}
