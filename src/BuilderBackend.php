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
            add_action('edit_form_after_editor', [static::class, 'admin_edit_form_after_editor'], PHP_INT_MAX);
            add_filter('wp_default_editor', [static::class, 'admin_wp_default_editor'], PHP_INT_MAX);

            include 'acf.php';

            do_action('buildy::builder-backend::boot');
        }
    }

    public static function admin_enqueue_scripts()
    {
        if (!Builder::isEnabled()) {
            return;
        }

        $manifest = new ViteManifest('manifest.json', get_template_directory().'/public/builder-gui', get_template_directory_uri().'/public/builder-gui');

        $jsEntryFile = 'src/main.ts';

        if ($manifest->has($jsEntryFile)) {
            // Load jQuery in the header rather than footer.
            // wp_dequeue_script('jquery');
            // wp_enqueue_script('jquery', '', [], false, false);

            if (!config('builder.dev_mode')) {
                foreach ($manifest->getStylesFor($jsEntryFile) as $cssFile) {
                    wp_enqueue_style("buildy-editor:{$cssFile}", $manifest->getUrlFor($cssFile));
                }

                if ($jsFile = $manifest->getScriptFor($jsEntryFile)) {
                    wp_enqueue_script("buildy-editor:{$jsFile}", $manifest->getUrlFor($jsFile), [], false, true);
                }
            }

            $addons = Builder::addons();
            foreach ($addons as $slug => $addon) {
                if (!empty($addon['params']['stylesheet'])) {
                    wp_enqueue_style("buildy-module:{$slug}", $addon['params']['stylesheet'], ['buildy-editor']);
                }

                if (!empty($addon['params']['script'])) {
                    wp_enqueue_script("buildy-module:{$slug}", $addon['params']['script'], ['buildy-editor'], false, true);
                }
            }
        }
    }

    public static function admin_edit_form_after_editor($post)
    {
        if (!Builder::isEnabled()) {
            return;
        }

        // This Div Loads Vue
        echo '<div id="app"></div>';

        // This style hides the Wordpress text editor.
        echo '<style>#postdivrich { display: none !important; }</style>';

        if (config('builder.dev_mode')) {
            echo '<script type="module" src="http://localhost:3000/src/main.ts"></script>';
        }
    }

    public static function admin_wp_default_editor($r)
    {
        if (!Builder::isEnabled()) {
            return $r;
        }

        return 'html'; // HTML / Text tab in TinyMCE
    }
}
