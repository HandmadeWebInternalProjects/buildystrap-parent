<?php

namespace Buildystrap\Builder\Extends;

abstract class Field
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;

        $this->augment();
    }

    abstract protected function augment();

    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
