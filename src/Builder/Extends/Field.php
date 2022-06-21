<?php

namespace Buildystrap\Builder\Extends;

abstract class Field
{
    protected mixed $value;

    public function __construct($value)
    {
        $this->value = $value;

        $this->augment();
    }

    abstract protected function augment(): void;

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
