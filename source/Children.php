<?php

namespace Pre\Phpx\Html;

use ArrayIterator;
use IteratorAggregate;

class Children implements IteratorAggregate
{
    public function __construct(iterable $children)
    {
        $this->children = $children;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->children);
    }

    public function __toString()
    {
        return $this->value($this->children);
    }

    private function value($child)
    {
        if (is_callable($child) && !is_string($child)) {
            return $child();
        }

        if (is_iterable($child)) {
            $result = "";

            foreach ($child as $value) {
                $result .= $this->value($value);
            }
            
            return $result;
        }

        return $child;
    }
}
