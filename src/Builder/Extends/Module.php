<?php

namespace Buildystrap\Builder\Extends;

use Exception;
use Illuminate\Support\Collection;
use stdClass;

abstract class Module
{
    protected string $uuid;
    protected string $type;
    protected bool $enabled;

    protected Collection $fields;
    protected Collection $values;

    abstract protected function blueprint(): Collection;

    abstract protected function augment();

    public function __construct(stdClass $module)
    {
        $this->uuid = $module->uuid;
        $this->enabled = $module->enabled ?? false;

        $this->type = $module->type;

        $this->fields = collect($module->fields)->map(function ($item, $handle) {
            if ($blueprintField = (object) $this->blueprint()->get($handle)) {
                $field = $blueprintField->type;

                if (!class_extends($field, Field::class)) {
                    throw new Exception("{$field} does not extend ".Field::class);
                }

                return new $field($item->value);
            }
        })->filter();

        $this->augment();
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function field(string $field)
    {
        return $this->fields()->get($field);
    }

    public function fields(): Collection
    {
        return $this->fields;
    }

    public function render(): string
    {
        $views = [
            "builder-modules::{$this->type}",
            'builder::moduleNotFound',
        ];

        return view()->first($views)->with('module', $this)->render();
    }

    // public function __call($name, $arguments): mixed
    // {
    //     if (property_exists($this, $name)) {
    //         return $this->$name;
    //     }

    //     return null;
    // }

    public function __toString(): string
    {
        return $this->render();
    }
}
