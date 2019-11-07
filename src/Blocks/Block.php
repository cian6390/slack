<?php

namespace Cian\Slack\Blocks;

use Cian\Slack\ArrayObject;

abstract class Block extends ArrayObject
{
    public function getType()
    {
        return $this->type;
    }
}
