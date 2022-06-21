<?php

namespace Buildystrap;

use Buildystrap\Builder\Content;
use Buildystrap\Builder\Extends\Field;
use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Fields\TextField;
use Buildystrap\Builder\Modules\BlurbModule;
use Buildystrap\Builder\Renderer;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Builder
{
    protected static bool $booted = false;

    protected static array $fields = [
        'text-field' => TextField::class,
    ];

    protected static array $modules = [
        'blurb-module' => BlurbModule::class,
    ];

    protected static array $paths = [];
    protected static array $scripts = [];
    protected static array $styles = [];

    /**
     * @throws Exception
     */
    public static function boot(): void
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

    /**
     * @throws Exception
     */
    protected static function bootFields(): void
    {
        foreach (static::$fields as $field) {
            if (!class_extends($field, Field::class)) {
                throw new Exception("$field does not extend ".Field::class);
            }
        }
    }

    /**
     * @throws Exception
     */
    protected static function bootModules(): void
    {
        foreach (static::$modules as $module) {
            if (!class_extends($module, Module::class)) {
                throw new Exception("$module does not extend ".Module::class);
            }
        }
    }

    protected static function bootPaths(): void
    {
        $paths = collect(config('view.paths'))
            ->map(function ($path) {
                return "$path/builder";
            })->toArray();

        view()->addNamespace('builder', $paths);

        static::$paths = collect($paths)
            ->map(function ($path) {
                return "$path/modules";
            })->toArray();

        view()->addNamespace('builder-modules', static::paths());
    }

    public static function paths(): array
    {
        return static::$paths;
    }

    /**
     * @throws Exception
     */
    public static function registerField(string $handle, string $field): array
    {
        if (!class_extends($field, Field::class)) {
            throw new Exception("$field does not extend ".Field::class);
        }

        static::$fields[Str::slug($handle)] = $field;

        return static::fields();
    }

    public static function fields(): array
    {
        return static::$fields;
    }

    public static function getField(string $handle): mixed
    {
        return Arr::get(static::fields(), Str::slug($handle));
    }

    /**
     * @throws Exception
     */
    public static function registerModule(string $handle, string $module): array
    {
        if (!class_extends($module, Module::class)) {
            throw new Exception("$module does not extend ".Module::class);
        }

        static::$modules[Str::slug($handle)] = $module;

        return static::modules();
    }

    public static function modules(): array
    {
        return static::$modules;
    }

    public static function getModule(string $handle): mixed
    {
        return Arr::get(static::modules(), Str::slug($handle));
    }

    public static function registerPath(string $path): void
    {
        if (!in_array($path, static::paths())) {
            view()->addNamespace('builder-modules', $path);
            static::$paths[] = $path;
        }
    }

    public static function getBackendScripts(): array
    {
        return static::$scripts;
    }

    public static function registerBackendScript(string $handle, string $script): void
    {
        static::$scripts[Str::slug($handle)] = $script;
    }

    public static function getBackendStyles(): array
    {
        return static::$styles;
    }

    public static function registerBackendStyle(string $handle, string $style): void
    {
        static::$styles[Str::slug($handle)] = $style;
    }

    public static function the_content($content): mixed
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
                return null; // Stop shortcode render on backend Or via REST.
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

    public static function enabledTypes(): array
    {
        $defaults = ['page'];

        return array_merge($defaults, config('builder.enabled_post_types', []));
    }

    public static function renderFromContent(string $content): Renderer
    {
        $content = new Content($content);

        return new Renderer($content->container());
    }
}
