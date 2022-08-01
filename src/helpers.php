<?php

use Buildystrap\Str;

if ( ! function_exists('extendable_layout')) {
    function extendable_layout($post = null, string $default = 'default'): string
    {
        if ($template = get_page_template_slug($post)) {
            $template = Str::replaceLast('.php', '', $template);
            $template = Str::replace('/', '.', $template);
            $template = Str::replaceFirst('page-templates', '', $template);
        } else {
            $template = $default;
        }

        return "layouts.$template";
    }
}

if ( ! function_exists('add_filters')) {
    /**
     * Bind single callback to multiple filters.
     *
     * @param iterable $filters List of filters
     */
    function add_filters(iterable $filters, callable $callback, int $priority = 10, int $args = 1): void
    {
        \Roots\add_filters($filters, $callback, $priority, $args);
    }
}

if ( ! function_exists('add_actions')) {
    /**
     * Bind single callback to multiple actions.
     *
     * @param iterable $actions List of actions
     */
    function add_actions(iterable $actions, callable $callback, int $priority = 10, int $args = 1): void
    {
        \Roots\add_actions($actions, $callback, $priority, $args);
    }
}

if ( ! function_exists('get_registered_image_sizes')) {
    function get_registered_image_sizes(): array
    {
        global $_wp_additional_image_sizes;

        $default_image_sizes = ['thumbnail', 'medium', 'large'];

        foreach ($default_image_sizes as $size) {
            $image_sizes[$size]['width'] = intval(get_option("{$size}_size_w"));
            $image_sizes[$size]['height'] = intval(get_option("{$size}_size_h"));
            $image_sizes[$size]['crop'] = get_option("{$size}_crop") ? get_option("{$size}_crop") : false;
        }

        if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
            $image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
        }

        return $image_sizes;
    }
}

if ( ! function_exists('class_extends')) {
    function class_extends(string $class, string $parent): bool
    {
        if ( ! class_exists($class) || ! class_exists($parent) || ! is_a($class, $parent, true)) {
            return false;
        }

        return true;
    }
}

if ( ! function_exists('getResponsiveClasses')) {
    function getResponsiveClasses(object $module, string $prop, string $classPrefix, string $fallback, mixed $computed = null)
    {
        $has_prop = $module->has($prop);
        if ( ! $has_prop) {
            return $fallback;
        }

        $prop = $module->get($prop);
        if ( ! isset($prop)) {
            return $fallback;
        }

        $class_list = [];
        foreach ($prop->value() as $breakpoint => $value) {
            $val = isset($computed) ? $computed($value) : $value;
            $class_list[] = match ($breakpoint) {
                'xs' => "{$classPrefix}-{$val}",
                default => "{$classPrefix}-{$breakpoint}-{$val}"
            };
        }
        return implode(' ', $class_list);
    }
}
