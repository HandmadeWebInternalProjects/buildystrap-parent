<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Traits\Augment;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

use function collect;
use function is_string;

abstract class Field implements Htmlable
{
    use Augment;

    protected mixed $value;
    protected mixed $raw;
    protected string $additional_classes = '';

    public function __construct(mixed $value)
    {
        $this->value = $value;
        $this->raw = $value;
    }

    public static function getBlueprint(): Collection
    {
        return collect(static::blueprint());
    }

    abstract protected static function blueprint(): array;

    public function raw(): mixed
    {
        return $this->raw;
    }

    public function __toString(): string
    {
        $value = $this->value();

        return match (true) {
            is_string($value) => $value,
      default => "<!-- {$this->type()} could not output value as a string -->"
        };
    }

    public function toHtml(): string
    {
        return $this->__toString();
    }

    public function withClass(string $class): self
    {
        $this->additional_classes = $class;
        return $this;
    }

    public function value(): mixed
    {
        return $this->augmented()->value;
    }
}
