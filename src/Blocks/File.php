<?php

namespace Cian\Slack\Blocks;

use Block;

class File extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'file';

    /**
     * The external unique ID for this file.
     * 
     * @var string|null Required.
     */
    public $externalId;

    /**
     * At the moment, source will always be remote for a remote file.
     * 
     * @var string Required.
     */
    public $source;

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
            'source' => $this->source,
            'external_id' => $this->externalId
        ];
    }
}
