<?php

namespace Cian\Slack\Blocks;

use Block;

class Image extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'image';

    /**
     * The URL of the image to be displayed.
     * Maximum length for this field is 3000 characters.
     * 
     * @var string Required.
     */
    public $imageUrl;

    /**
     * A plain-text summary of the image.
     * This should not contain any markup.
     * Maximum length for this field is 2000 characters.
     * 
     * @var string Required.
     */
    public $altText;

    /**
     * An optional title for the image in the form of a text object that can only be of type: plain_text.
     * Maximum length for the text in this field is 2000 characters.
     * 
     * @var string Optional.
     */
    public $title;

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
            'alt_text' => $this->altText,
            'title' => $this->title,
            'image_url' => $this->imageUrl,
        ];
    }
}
