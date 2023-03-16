<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Builder;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\HtmlStyleBuilder;
use Buildystrap\Traits\InlineAttributes;
use Illuminate\Support\Collection;

use function array_replace_recursive;
use function collect;
use function is_array;
use function optional;
use function view;

abstract class Module
{
    use Attributes;
    use Config;
    use Augment;
    use InlineAttributes;
    use HtmlStyleBuilder;

    protected string $uuid;
    protected string $type;
    protected bool $enabled;

    protected Collection $fields;
    protected Collection $values;

    public function __construct(array $module)
    {
        $this->uuid = $module['uuid'];
        $this->enabled = $module['enabled'] ?? false;
        $this->type = $module['type'];

        $blueprintFields = static::getBlueprint()->get('fields');

        $values = $module['values'];

        $this->fields = collect($values)->map(function ($value, $handle) use ($blueprintFields) {
            if ( ! empty($blueprintFields[$handle]) && $blueprintField = $blueprintFields[$handle]) {
                if ($field = Builder::getField($blueprintField['type'])) {
                    return new $field($value);
                }
            }
        })->filter();

        if (isset($module['config']) && is_array($module['config'])) {
            $this->config = $module['config'];
        }

        if (isset($module['attributes']) && is_array($module['attributes'])) {
            $this->attributes = $module['attributes'];
        }

        if (isset($module['inline']) && is_array($module['inline'])) {
            $this->inline_attributes = $module['inline'];
        }
    }

    public function get(string $value, mixed $default = null): mixed
    {
        return optional($this->fields()->get($value, $default))->augmented();
    }

    public function fields(): Collection
    {
        return $this->fields;
    }

    public function recursifyFieldTypes($values): Collection
    {
        $blueprintFields = static::getBlueprint()->get('fields');

        return collect($values)->map(function ($value, $handle) use ($blueprintFields) {
            if ( ! empty($blueprintFields[$handle]) && $blueprintField = $blueprintFields[$handle]) {
                if ($field = Builder::getField($blueprintField['type'])) {
                    $fieldValue = $value;

                    if (is_array($fieldValue)) {
                        $fieldValue = collect($fieldValue)->map(function ($subField) use ($blueprintFields, $handle) {
                            if (is_array($subField)) {
                                foreach ($subField as $subHandle => $subValue) {
                                    if (
                    isset($blueprintFields[$handle]['fields'][$subHandle]['type']) &&
                    $subFieldType = Builder::getField($blueprintFields[$handle]['fields'][$subHandle]['type'])
                  ) {
                                        $subField[$subHandle] = new $subFieldType($subValue);
                                    }
                                }
                            }
                            return $subField;
                        })->toArray();
                    }
                    return new $field($fieldValue);
                }
            }
        })->filter();
    }

    // public static function getBlueprint(): Collection
    // {
    //     $blueprint = static::blueprint();
    //     $fields = $blueprint['fields'] ?? [];

    //     foreach ($fields as $handle => $item) {
    //         if ($field = Builder::getField($item['type'])) {
    //             if( isset($item['fields']) ) {
    //                 foreach ($item['fields'] as $sub_handle => $sub_item) {
    //                     if ($sub_field = Builder::getField($sub_item['type'])) {
    //                         $item['fields'][$sub_handle] = array_replace_recursive($sub_field::getBlueprint()->toArray(), $sub_item);
    //                     }
    //                 }
    //             }
    //             $blueprint['fields'][$handle] = array_replace_recursive($field::getBlueprint()->toArray(), $item);
    //         }
    //     }

    //     return collect($blueprint);
    // }

    public static function getBlueprint(): Collection
    {
        $blueprint = static::blueprint();
        $fields = $blueprint['fields'] ?? [];

        $blueprint = static::matchConfigs($blueprint, $fields);

        return collect($blueprint);
    }

    public static function matchConfigs($parent, $fields): array
    {
        foreach ($fields as $handle => $item) {
            if (isset($item['fields'])) {
                $item = static::matchConfigs($item, $item['fields']);
            }

            if ($field = Builder::getField($item['type'])) {
                $parent['fields'][$handle] = array_replace_recursive($field::getBlueprint()->toArray(), $item);
            }
        }
        return $parent;
    }

    abstract protected static function blueprint(): array;

    public function type(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->augmented()->render();
    }

    public function render(): string
    {
        $this->augmentOnce();

        $views = [
      "builder-modules::$this->type",
      'builder::module-not-found',
    ];

        return view()->first($views)->with('module', $this)->render();
    }

    public function augment(): void
    {
        $this->generateClasses();
    }

    public function has(string $value): bool
    {
        return $this->fields()->has($value);
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
