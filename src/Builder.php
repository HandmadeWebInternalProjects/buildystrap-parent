<?php

namespace Buildystrap;

use Buildystrap\Builder\Content;
use Buildystrap\Builder\Extends\Field;
use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Renderer;
use Buildystrap\Interfaces\Bootable;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Builder implements Bootable
{
    protected static bool $booted = false;

    protected static array $fields = [
        'text' => \Buildystrap\Builder\Fields\Text::class,
    ];

    protected static array $modules = [
        'blurb' => \Buildystrap\Builder\Modules\Blurb::class,
    ];

    protected static array $paths = [];
    protected static array $scripts = [];
    protected static array $styles = [];

    public static function boot()
    {
        if (!static::$booted) {
            static::$booted = true;

            add_filter('the_content', [static::class, 'the_content'], PHP_INT_MAX);

            static::bootFields();
            static::bootModules();
            static::bootPaths();

            do_action('buildystrap::builder::boot');
        }
    }

    protected static function bootFields()
    {
        foreach (static::$fields as $field) {
            if (!class_extends($field, Field::class)) {
                throw new Exception("{$field} does not extend ".Field::class);
            }
        }
    }

    public static function registerField(string $handle, string $field)
    {
        if (!class_extends($field, Field::class)) {
            throw new Exception("{$field} does not extend ".Field::class);
        }

        static::$fields[Str::slug($handle)] = $field;

        return static::fields();
    }

    public static function fields()
    {
        return static::$fields;
    }

    public static function getField(string $handle)
    {
        return Arr::get(static::fields(), Str::slug($handle));
    }

    protected static function bootModules()
    {
        foreach (static::$modules as $module) {
            if (!class_extends($module, Module::class)) {
                throw new Exception("{$module} does not extend ".Module::class);
            }
        }
    }

    public static function registerModule(string $handle, string $module)
    {
        if (!class_extends($module, Module::class)) {
            throw new Exception("{$module} does not extend ".Module::class);
        }

        static::$modules[Str::slug($handle)] = $module;

        return static::modules();
    }

    public static function modules()
    {
        return static::$modules;
    }

    public static function getModule(string $handle)
    {
        return Arr::get(static::modules(), Str::slug($handle));
    }

    public static function registerPath(string $path)
    {
        if (!in_array($path, static::paths())) {
            view()->addNamespace('builder-modules', $path);
            static::$paths[] = $path;
        }
    }

    protected static function bootPaths()
    {
        $paths = collect(config('view.paths'))
                ->map(function ($path) {
                    return "{$path}/builder";
                })->toArray();

        view()->addNamespace('builder', $paths);

        static::$paths = collect($paths)
                ->map(function ($path) {
                    return "{$path}/modules";
                })->toArray();

        view()->addNamespace('builder-modules', static::paths());
    }

    public static function paths()
    {
        return static::$paths;
    }

    public static function getBackendScripts(): array
    {
        return static::$scripts;
    }

    public static function registerBackendScript(string $handle, string $script)
    {
        static::$scripts[Str::slug($handle)] = $script;
    }

    public static function getBackendStyles(): array
    {
        return static::$styles;
    }

    public static function registerBackendStyle(string $handle, string $style)
    {
        static::$styles[Str::slug($handle)] = $style;
    }

    public static function the_content($content)
    {
        /*
         * Possibly crude way of intercepting the output of the_content()
         * We intercept the_content() via a Wordpress filter.
         * Normally you would modify $content in some way and then return it as normal.
         *
         * However in this case, we want the raw unformatted content.
         */
        if (static::isEnabled()) {
            if (is_admin() || defined('REST_REQUEST') && REST_REQUEST) {
                return; // Stop shortcode render on backend Or via REST.
            }

            // Get the current post.
            $post = get_queried_object();

            return static::renderFromContent($post->post_content)->render();
        }

        /*
         * If the Page Builder was not enabled on this post.
         * Return the content, as is.
         */
        return $content;
    }

    public static function enabledTypes(): array
    {
        $defaults = ['page'];

        return array_merge($defaults, config('builder.enabled_post_types', []));
    }

    public static function isEnabled(int $id = 0): bool
    {
        if (!function_exists('get_field')) {
            return false;
        }

        if (is_admin()) {
            $screen = get_current_screen();

            if (in_array($screen->post_type, static::enabledTypes()) && 'post' === $screen->base) {
                $isEnabled = get_field('buildy::enabled', $id);
            }
        } else {
            $isEnabled = get_field('buildy::enabled', $id);
        }

        return $isEnabled ?? false;
    }

    public static function renderFromContent(string $content)
    {
        $content = new Content($content);

        return new Renderer($content->container());
    }
}
