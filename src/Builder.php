<?php

namespace Buildystrap;

use Buildystrap\Builder\Module;
use Buildystrap\Builder\Renderer;
use Buildystrap\Builder\Modules\Text;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Exception;

class Builder
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

            do_action('buildystrap::boot');
        }
    }

    // add_action('buildystrap::boot', function () {
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
            'params' => array_merge(['path' => $path], $params)
        ];

        if (!empty($params['stylesheet'])) {
            wp_enqueue_style("buildystrap-module:{$slug}", $params['stylesheet']);
        }

        if (!empty($params['script'])) {
            wp_enqueue_script("buildystrap-module:{$slug}", $params['script']);
        }

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
            throw new Exception("{$module} does not extend ". Module::class);
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
        return new Renderer($content);
    }
}
