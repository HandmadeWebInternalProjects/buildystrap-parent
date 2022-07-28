<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Arr;
use Buildystrap\Traits\Augment;
use Illuminate\Support\Collection;

use function collect;

abstract class Field
{
    use Augment;

    protected mixed $value;
    protected mixed $raw;

    public function __construct($value)
    {
        $this->value = $value;
        $this->raw = $value;
    }

    public static function getBlueprint(): Collection
    {
        return collect(static::blueprint());
    }

    abstract protected static function blueprint(): array;

    public function __toString(): string
    {
        $this->augmentOnce();

        return $this->value();
    }

    public function get(string $value, mixed $default = null): mixed
    {
        return Arr::get((array) $this->value(), $value, $default);
    }

    public function augmented(): static
    {
        $this->augmentOnce();
        return $this;
    }

    public function value(): mixed
    {
        $this->augmentOnce();

        return $this->value;
    }

    public function raw(): mixed
    {
        return $this->raw;
    }
}
