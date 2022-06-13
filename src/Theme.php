<?php

namespace Buildystrap;

use Illuminate\Support\Str;
use WP_Upgrader;

class Theme
{
    protected static array $templates = [];

    /**
     * Enqueue Theme Styles.
     *
     * @return void
     */
    public static function enqueue_styles()
    {
        $stylesheet = is_plugin_active('woocommerce/woocommerce.php') ? 'parent-style-woocommerce.css' : 'parent-style.css';
        wp_enqueue_style('parent-style', get_template_directory_uri()."/dist/css/{$stylesheet}", [], wp_get_theme('buildystrap-parent')->get('Version'));

        // Font Awesome
        wp_enqueue_style('font-awesome', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css');
    }

    /**
     * Enqueue Theme Scripts.
     *
     * @return void
     */
    public static function enqueue_scripts()
    {
        wp_enqueue_script('parent-script', get_template_directory_uri().'/dist/js/parent-script.js', [], wp_get_theme('buildystrap-parent')->get('Version'));
    }

    /**
     * Set the blade template loading order.
     */
    public static function filter_template_hierarchy(array $files): array
    {
        foreach ($files as $file) {
            $file = Str::replaceLast('.php', '', $file);

            if ('index' === $file || in_array($file, static::$templates)) {
                continue;
            }

            static::$templates[] = $file;
        }

        return $files;
    }

    /**
     * Get the blade template loading order.
     */
    public static function get_template_hierarchy(): array
    {
        return array_merge(static::$templates, ['index']);
    }

    public static function clear_on_update($upgrader = null, $options = [])
    {
        $shouldClear = false;

        if ($upgrader instanceof WP_Upgrader) {
            if (!empty($options['themes']) && in_array('buildystrap-parent', $options['themes'])) {
                $shouldClear = true;
            }
        } else {
            $shouldClear = true;
        }

        if ($shouldClear) {
            static::optimize_clear();
        }
    }

    public static function optimize_clear()
    {
        // view:clear
        static::view_clear();

        // cache:clear
        static::cache_clear();

        // clear-compiled
        static::clear_compiled();
    }

    public static function view_clear()
    {
        $path = config('view.compiled');

        foreach (glob("{$path}/*") as $view) {
            unlink($view);
        }
    }

    public static function cache_clear()
    {
        cache()->clear();
    }

    public static function clear_compiled()
    {
        if (is_file($servicesPath = storage_path('framework/cache/packages.php'))) {
            @unlink($servicesPath);
        }

        if (is_file($packagesPath = storage_path('framework/cache/services.php'))) {
            @unlink($packagesPath);
        }
    }
}
