<?php

namespace Buildystrap;

use Buildystrap\Interfaces\Bootable;

class BuilderBackend implements Bootable
{
    protected static bool $booted = false;

    protected static array $paths = [];

    public static function boot()
    {
        if (!static::$booted) {
            static::$booted = true;

            add_action('admin_enqueue_scripts', [static::class, 'admin_enqueue_scripts']);
            add_action('edit_form_after_editor', [static::class, 'admin_edit_form_after_editor']);
            add_filter('wp_default_editor', [static::class, 'admin_wp_default_editor']);

            do_action('buildy::builder-backend::boot');
        }
    }

    public static function admin_enqueue_scripts()
    {
        // Load jQuery in the header rather than footer.
        // wp_dequeue_script('jquery');
        // wp_enqueue_script('jquery', '', [], false, false);

        wp_enqueue_style('buildy-editor', get_template_directory_uri().'/public/css/buildy-editor.css', [], wp_get_theme('buildystrap-parent')->get('Version'));
        wp_enqueue_script('buildy-editor', get_template_directory_uri().'/public/js/buildy-editor.js', [], wp_get_theme('buildystrap-parent')->get('Version'), true);
    }

    public static function admin_edit_form_after_editor($post)
    {
        // This Div Loads Vue
        echo '<div id="app"></div>';

        // This style hides the Wordpress text editor.
        echo '<style>#postdivrich { display: none !important; }</style>';
    }

    public static function admin_wp_default_editor($r)
    {
        // TODO conditional check if pagebuilder is enabled for this post type
        if (true) {
            return 'html'; // HTML / Text tab in TinyMCE
        }

        return $r;
    }
}
