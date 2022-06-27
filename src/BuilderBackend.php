<?php

namespace Buildystrap;

use function add_action;
use function add_filter;
use function config;
use function do_action;
use function get_template_directory_uri;
use function wp_enqueue_script;
use function wp_enqueue_style;

class BuilderBackend
{
    protected static bool $booted = false;

    protected static array $paths = [];

    public static function boot(): void
    {
        if ( ! static::$booted) {
            static::$booted = true;

            add_action('admin_enqueue_scripts', [static::class, 'admin_enqueue_scripts'], PHP_INT_MAX);
            add_action('edit_form_after_editor', [static::class, 'admin_edit_form_after_editor'], PHP_INT_MAX);
            add_filter('wp_default_editor', [static::class, 'admin_wp_default_editor'], PHP_INT_MAX);

            include 'acf.php';

            do_action('buildy::builder-backend::boot');
        }
    }

    public static function admin_enqueue_scripts()
    {
        if ( ! Builder::isEnabled()) {
            return null;
        }

        $manifest = new ViteManifest(
            'manifest.json',
            get_template_directory() . '/public/builder-gui',
            get_template_directory_uri() . '/public/builder-gui'
        );

        $jsEntryFile = 'src/main.ts';

        if ($manifest->has($jsEntryFile)) {
            // Load jQuery in the header rather than footer.
            // wp_dequeue_script('jquery');
            // wp_enqueue_script('jquery', '', [], false, false);

            $jsFile = $manifest->getScriptFor($jsEntryFile);

            if ( ! config('builder.dev_mode')) {
                foreach ($manifest->getStylesFor($jsEntryFile) as $cssFile) {
                    wp_enqueue_style('buildy-editor', $manifest->getUrlFor($cssFile));
                    break;
                }

                if ($jsFile) {
                    wp_enqueue_script("buildy-editor:$jsFile", $manifest->getUrlFor($jsFile), [], false, true);
                }
            }

            foreach (Builder::getBackendScripts() as $handle => $script) {
                wp_enqueue_script("buildy-module:$handle", $script, ['buildy-editor'], false, false);
            }

            foreach (Builder::getBackendStyles() as $handle => $style) {
                wp_enqueue_style("buildy-module:$handle", $style, ['buildy-editor']);
            }
        }
    }

    public static function admin_edit_form_after_editor($post)
    {
        if ( ! Builder::isEnabled()) {
            return null;
        }

        // This Div Loads Vue
        echo '<div id="app"></div>';

        echo "<script id='moduleBlueprints' type='application/json'>".Builder::moduleBlueprints()->toJson()."</script>";

        // This style hides the WordPress text editor.
        echo '<style>#postdivrich { display: none !important; }</style>';

        if (config('builder.dev_mode')) {
            echo '<script type="module" src="http://localhost:3000/src/main.ts"></script>';
        }
    }

    public static function admin_wp_default_editor($r): mixed
    {
        if ( ! Builder::isEnabled()) {
            return $r;
        }

        return 'html'; // HTML / Text tab in TinyMCE
    }
}
