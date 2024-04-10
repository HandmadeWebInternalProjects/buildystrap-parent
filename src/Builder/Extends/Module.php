<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Builder;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\CollectionClass;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\HtmlStyleBuilder;
use Buildystrap\Traits\InlineAttributes;
use Buildystrap\Traits\Visibility;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

use function array_replace_recursive;
use function collect;
use function is_array;
use function optional;
use function view;

abstract class Module
{
  use Attributes;
  use CollectionClass;
  use Config;
  use Augment;
  use InlineAttributes;
  use HtmlStyleBuilder;
  use Visibility;

  protected string $uuid;
  protected string $type;
  protected bool $enabled;
  protected Collection $data;

  protected Collection|LazyCollection $fields;
  protected Collection $values;

  public function __construct(array $module, bool $disable_fields = false)
  {
    $this->uuid = $module['uuid'];
    $this->enabled = $module['enabled'] ?? false;
    $this->type = $module['type'];

    $blueprintFields = static::getBlueprint()->get('fields');

    $values = $module['values'];

    $this->fields = $this->collectionClass([]);

    $this->data = collect([]);



    if (!$disable_fields) {
      $this->fields = $this->collectionClass($values)
        ->map(function ($value, $handle) use ($blueprintFields) {
          if (!empty($blueprintFields[$handle]) && $blueprintField = $blueprintFields[$handle]) {
            if ($field = Builder::getField($blueprintField['type'])) {
              return new $field($value);
            }
          }

          return null;
        })->filter();
    }

    if (isset($module['config']) && is_array($module['config'])) {
      $this->config = $module['config'];
    }

    if (isset($module['attributes']) && is_array($module['attributes'])) {
      $this->attributes = $module['attributes'];
    }

    if (isset($module['inline']) && is_array($module['inline'])) {
      $this->inline_attributes = $module['inline'];
    }

    //Visibility
    if ($visibility = $this->getConfig('visibility')) {
      foreach ($visibility as $breakpoint) {
        $this->visibility_classes[] = "hide-{$breakpoint}";
      }
      array_push($this->html_classes, ...$this->visibility_classes);
    }
  }

  public function get(string $value, mixed $default = null): mixed
  {
    return optional($this->fields()->get($value, $default))->augmented();
  }

  public function fields(): Collection|LazyCollection
  {
    return $this->fields;
  }

  public function with(array $array)
  {
    $this->data = collect($array);
    return $this;
  }

  public function recursifyFieldTypes($values): Collection
  {
    $blueprintFields = static::getBlueprint()->get('fields');

    // Change to $this->collectionClass()
    return collect($values)->map(function ($value, $handle) use ($blueprintFields) {
      if (!empty($blueprintFields[$handle]) && $blueprintField = $blueprintFields[$handle]) {
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

      if (isset($item['type']) && $field = Builder::getField($item['type'])) {
        $parent['fields'][$handle] = array_replace_recursive($field::getBlueprint()->toArray(), $item);
      }

      if (isset($field) && $query = $item['config']['query'] ?? false) {
        // Make sure config exists and is an array
        if (!isset($parent['fields'][$handle]['config'])) {
          $parent['fields'][$handle]['config'] = [];
        }
        $parent['fields'][$handle]['config']['options'] = $field::get_options_from_query($query);
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
    if ($this->hideOnAll()) {
      return '';
    }

    $this->augmentOnce();

    $views = [
      "builder-modules::$this->type",
      'builder::module-not-found',
    ];

    return view()->first($views)->with('module', $this)->with($this->data->toArray())->render();
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
