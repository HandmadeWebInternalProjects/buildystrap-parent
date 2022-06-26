<?php

use Illuminate\Support\Str;

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

if ( ! function_exists('class_extends')) {
    function class_extends(string $class, string $parent): bool
    {
        if ( ! class_exists($class) || ! class_exists($parent) || ! is_a($class, $parent, true)) {
            return false;
        }

        return true;
    }
}
