<?php

namespace Pre\Phpx\Html;

use ArrayIterator;
use IteratorAggregate;

class Children implements IteratorAggregate
{
    public function __construct(array $children)
    {
        $this->children = $children;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->children);
    }

    public function __toString()
    {
        $result = "";

        foreach ($this->children as $child) {
            if (is_callable($child) && !is_string($child)) {
                $result .= $child();
            } else {
                $result .= $child;
            }
        }

        return $result;
    }
}
