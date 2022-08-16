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
