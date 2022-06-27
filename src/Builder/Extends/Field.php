<?php

namespace Buildystrap\Builder\Extends;

use Illuminate\Support\Collection;

abstract class Field
{
    protected mixed $value;

    public function __construct($value)
    {
        $this->value = $value;

        $this->augment();
    }

    abstract protected function augment(): void;

    abstract public static function blueprint(): Collection;

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
