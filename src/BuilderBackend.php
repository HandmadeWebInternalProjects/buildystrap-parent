<?php

namespace Buildystrap;

use function add_action;
use function add_filter;
use function config;
use function do_action;
use function get_admin_url;
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

            BuilderMetaBox::boot();

            add_action('admin_enqueue_scripts', [static::class, 'admin_enqueue_scripts'], PHP_INT_MAX);
            add_action('edit_form_after_editor', [static::class, 'admin_edit_form_after_editor'], PHP_INT_MAX);
            add_filter('wp_default_editor', [static::class, 'admin_wp_default_editor'], PHP_INT_MAX);

            do_action('buildy::builder-backend::boot');
        }
    }

    public static function admin_enqueue_scripts()
    {
        if ( ! Builder::isEnabled()) {
            return null;
        }

        if (is_admin()) {
            wp_enqueue_media();
            wp_enqueue_editor();
        }

        $manifest = new ViteManifest(
            'manifest.json',
            get_template_directory() . '/public/builder-gui',
            get_template_directory_uri() . '/public/builder-gui'
        );

        $jsEntryFile = 'src/main.ts';

        // Disable TINYMCE
        // add_filter('user_can_richedit', function () {
        //     return false;
        // }, 50);
        // wp_deregister_style( 'editor-buttons' );

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

        $config = json_encode([
            'is_admin' => current_user_can('administrator'),
            'is_global_module' => $post->post_type === 'buildy-global-module',
            'post_id' => $post->ID,
            'post_type' => $post->post_type,
            'site_url' => get_site_url(),
            'admin_url' => get_admin_url(),
            'theme_url' => get_template_directory_uri(),
            "rest_endpoint" => get_rest_url(),
            'admin_post_edit_url' => get_admin_url(path: 'post.php?action=edit&post='),
            'moduleBlueprints' => Builder::moduleBlueprints(),
            'globalSections' => Builder::getGlobals(),
            'globalModules' => Builder::getGlobalModules(),
            // 'registered_image_sizes' => static::get_all_image_sizes(),
            'registered_post_types' => get_post_types(['_builtin' => false]),
        ]);

        // Module Blueprints
        echo "<script id='config' type='application/json'>{$config}</script>";

        // This Div Loads Vue
        echo '<div id="app"></div>';

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
