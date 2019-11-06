<?php

namespace Cian\Slack\Blocks;

use Block;

class Divider extends Block
{
    /**
     * The type of block.
     *
     * @var string Required.
     */
    protected $type = 'divider';

    public function toArray()
    {
        return [
            'type' => $this->type
        ];
    }
}
