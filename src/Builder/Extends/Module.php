<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Builder;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Config;
use Illuminate\Support\Collection;
use stdClass;

use function collect;
use function view;

abstract class Module
{
    use Attributes;
    use Config;

    protected string $uuid;
    protected string $type;
    protected bool $enabled;

    protected Collection $fields;
    protected Collection $values;

    public function __construct(stdClass $module)
    {
        $this->uuid = $module->uuid;
        $this->enabled = $module->enabled ?? false;

        $this->type = $module->type;

        $blueprintFields = static::blueprint()->get('fields');

        $values = $module->values;

        $this->fields = collect($values)->map(function ($value, $handle) use ($blueprintFields, $values) {
            if ( ! empty($blueprintFields[$handle]) && $blueprintField = (object) $blueprintFields[$handle]) {
                if ($field = Builder::getField($blueprintField->type)) {
                    return new $field($value);
                }
            }

            return null;
        })->filter();

        $this->augment();
    }

    abstract public static function blueprint(): Collection;

    abstract protected function augment(): void;

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

    public function field(string $field): mixed
    {
        return $this->fields()->get($field);
    }

    public function fields(): Collection
    {
        return $this->fields;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    // public function __call($name, $arguments): mixed
    // {
    //     if (property_exists($this, $name)) {
    //         return $this->$name;
    //     }

    //     return null;
    // }

    public function render(): string
    {
        $views = [
            "builder-modules::$this->type",
            'builder::moduleNotFound',
        ];

        return view()->first($views)->with('module', $this)->render();
    }
}
