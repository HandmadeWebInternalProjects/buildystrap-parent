<?php

namespace Buildystrap\Builder\Extends;

use Illuminate\Support\Collection;

use function collect;

abstract class Field
{
    protected mixed $value;
    protected mixed $raw;

    public function __construct($value)
    {
        $this->value = $value;
        $this->raw = $value;

        $this->augment();
    }

    abstract protected function augment(): void;

    public static function getBlueprint(): Collection
    {
        return collect(static::blueprint());
    }

    abstract protected static function blueprint(): array;

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function raw(): mixed
    {
        return $this->raw;
    }
}
