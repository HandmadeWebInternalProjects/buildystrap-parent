<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Arr;
use Buildystrap\Builder;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\InlineAttributes;
use Illuminate\Support\Collection;
use stdClass;

use function array_replace_recursive;
use function collect;
use function view;

abstract class Module
{
    use Attributes;
    use Config;
    use Augment;
    use InlineAttributes;

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

        $blueprintFields = static::getBlueprint()->get('fields');

        $values = $module->values;

        $this->fields = collect($values)->map(function ($value, $handle) use ($blueprintFields) {
            if ( ! empty($blueprintFields[$handle]) && $blueprintField = (object) $blueprintFields[$handle]) {
                if ($field = Builder::getField($blueprintField->type)) {
                    return new $field($value);
                }
            }
        })->filter();

        if (isset($module->config) && $module->config instanceof stdClass) {
            $this->config = Arr::from_stdclass($module->config);
        }

        if (isset($module->attributes) && $module->attributes instanceof stdClass) {
            $this->attributes = Arr::from_stdclass($module->attributes);
        }

        if (isset($module->inline) && $module->inline instanceof stdClass) {
            $this->inline_attributes = Arr::from_stdclass($module->inline);
        }
    }

    public static function getBlueprint(): Collection
    {
        $blueprint = static::blueprint();
        $fields = $blueprint['fields'] ?? [];

        foreach ($fields as $handle => $item) {
            if ($field = Builder::getField($item['type'])) {
                $blueprint['fields'][$handle] = array_replace_recursive($field::getBlueprint()->toArray(), $item);
            }
        }

        return collect($blueprint);
    }

    abstract protected static function blueprint(): array;

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

    public function render(): string
    {
        $this->augmentOnce();

        $views = [
            "builder-modules::$this->type",
            'builder::moduleNotFound',
        ];

        return view()->first($views)->with('module', $this)->render();
    }
}
