<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Builder\Interfaces\ModuleInterface;
use stdClass;

abstract class Module implements ModuleInterface
{
    protected bool $enabled;

    protected string $type;

    protected mixed $value;
    protected string $raw;

    public function __construct(stdClass $module)
    {
        $this->enabled = $module->enabled ?? false;

        $this->type = $module->type;

        $this->value = $module->value;
        $this->raw = $module->value;
    }

    public function augment(): static
    {
        $this->value = $this->value();

        return $this;
    }

    public function render(): string
    {
        $views = [
            "builder-modules::{$this->type}",
            'builder::moduleNotFound',
        ];

        return view()->first($views)->with('module', $this->augment())->render();
    }

    public function __call($name, $arguments): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
