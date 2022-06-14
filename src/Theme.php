<?php

namespace Buildystrap;

use Buildystrap\Interfaces\Bootable;
use Illuminate\Support\Str;
use WP_Upgrader;

class Theme implements Bootable
{
    protected static bool $booted = false;

    protected static array $templates = [];

    public static function boot()
    {
        if (!static::$booted) {
            static::$booted = true;

            add_action('wp_enqueue_scripts', [static::class, 'enqueue_styles']);
            add_action('wp_enqueue_scripts', [static::class, 'enqueue_scripts']);

            add_filters([
                'index_template_hierarchy',
                '404_template_hierarchy',
                'archive_template_hierarchy',
                'author_template_hierarchy',
                'category_template_hierarchy',
                'tag_template_hierarchy',
                'taxonomy_template_hierarchy',
                'date_template_hierarchy',
                'home_template_hierarchy',
                'frontpage_template_hierarchy',
                'page_template_hierarchy',
                'paged_template_hierarchy',
                'search_template_hierarchy',
                'single_template_hierarchy',
                'singular_template_hierarchy',
                'attachment_template_hierarchy',
                'privacypolicy_template_hierarchy',
                'embed_template_hierarchy',
            ], [static::class, 'filter_template_hierarchy'], 100);

            // Clear optimizations when theme has been switched.
            add_actions([
                'switch_theme',
                'after_switch_theme',
                'admin_action_do-theme-upgrade',
                'upgrader_process_complete',
            ], [static::class, 'clear_on_update']);

            do_action('buildystrap::theme::boot');
        }
    }

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
