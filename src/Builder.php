<?php

namespace Buildystrap;

use Buildystrap\Builder\Content;
use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Modules\Text;
use Buildystrap\Builder\Renderer;
use Buildystrap\Interfaces\Bootable;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Builder implements Bootable
{
    protected static bool $booted = false;

    protected static array $addons = [];

    protected static array $modules = [
        'text' => Text::class,
    ];

    protected static array $paths = [];

    public static function boot()
    {
        if (!static::$booted) {
            static::$booted = true;

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

            add_filter('the_content', [static::class, 'the_content'], PHP_INT_MAX);

            do_action('buildystrap::builder::boot');
        }
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
        $isEnabled = false;

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

    // add_action('buildystrap::builder::boot', function () {
    //     Builder::registerAddon(
    //         'markdown',
    //         Markdown::class,
    //         __DIR__.'/resources/views',
    //         [
    //             'stylesheet' => '',
    //             'script' => '',
    //         ]
    //     );
    // });
    public static function registerAddon(string $slug, string $module, string $path, array $params = [])
    {
        $slug = Str::slug($slug);

        static::$addons[$slug] = [
            'module' => $module,
            'params' => array_merge(['path' => $path], $params),
        ];

        if (!in_array($path, static::paths())) {
            view()->addNamespace('builder-modules', $path);
            static::$paths[] = $path;
        }

        static::registerModule($slug, $module);

        return static::addons();
    }

    public static function paths()
    {
        return static::$paths;
    }

    public static function addons()
    {
        return static::$addons;
    }

    public static function registerModule(string $slug, string $module)
    {
        $slug = Str::slug($slug);

        if (!class_extends($module, Module::class)) {
            throw new Exception("{$module} does not extend ".Module::class);
        }

        static::$modules[$slug] = $module;

        return static::modules();
    }

    public static function modules()
    {
        return static::$modules;
    }

    public static function getModule(string $module)
    {
        return Arr::get(static::modules(), Str::slug($module));
    }

    public static function renderFromContent(string $content)
    {
        $container = new Content($content);

        return new Renderer($container->container());
    }
}
