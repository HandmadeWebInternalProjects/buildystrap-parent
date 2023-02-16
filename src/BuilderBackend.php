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
    if (!static::$booted) {
      static::$booted = true;

      BuilderMetaBox::boot();

      add_action('admin_enqueue_scripts', [static::class, 'admin_enqueue_scripts'], PHP_INT_MAX);
      add_action('edit_form_after_editor', [static::class, 'admin_edit_form_after_editor'], PHP_INT_MAX);
      add_filter('wp_default_editor', [static::class, 'admin_wp_default_editor'], PHP_INT_MAX);
      add_filter('script_loader_tag', [static::class, 'admin_add_type_attribute'], 10, 3);

      do_action('buildy::builder-backend::boot');

      if (get_option('blog_public') === '0') {
        add_action('admin_notices', [static::class, 'search_engine_notice'], 1);
        add_action('wp_head', [static::class, 'nofollow_meta'], 1);
        add_action('login_enqueue_scripts', [static::class, 'nofollow_meta'], 1);
      }
    }
  }

  public static function admin_enqueue_scripts()
  {
    if (!Builder::isEnabled()) {
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

    wp_enqueue_style('font-awesome-icons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css', []);


    if ($manifest->has($jsEntryFile)) {
      // Load jQuery in the header rather than footer.
      // wp_dequeue_script('jquery');
      // wp_enqueue_script('jquery', '', [], false, false);

      $jsFile = $manifest->getScriptFor($jsEntryFile);

      if (!config('builder.dev_mode')) {
        foreach ($manifest->getStylesFor($jsEntryFile) as $cssFile) {
          wp_enqueue_style('buildy-editor', $manifest->getUrlFor($cssFile));
          break;
        }

        if ($jsFile) {
          wp_enqueue_script('buildy-editor', $manifest->getUrlFor($jsFile), [], false, true);
        }
      }

      foreach ($backendScripts = Builder::getBackendScripts() as $handle => $script) {
        wp_enqueue_script("buildy-module:$handle", $script, ['buildy-editor'], false, true);
      }

      foreach (Builder::getBackendStyles() as $handle => $style) {
        wp_enqueue_style("buildy-module:$handle", $style, ['buildy-editor']);
      }

      $booterDependancy = 'buildy-editor';

      if (count($backendScripts)) {
        // Load the booter script after the last backend script (plugin)
        $booterDependancy = "buildy-module:" . array_key_last($backendScripts);
      }

      wp_enqueue_script(
        'buildy-boot-module',
        get_template_directory_uri() . '/resources/js/buildy-boot.js',
        [$booterDependancy],
        false,
        true
      );

      wp_enqueue_style('hmw-theme-admin-options', get_stylesheet_directory_uri() . '/public/hmw-theme-admin-options.css', []);
    }
  }

  public static function admin_add_type_attribute($tag, $handle, $src)
  {
    if (str_contains($handle, 'buildy')) {
      return '<script type="module" defer src="' . esc_url($src) . '"></script>';
    }

    return $tag;
  }

  public static function admin_edit_form_after_editor($post)
  {
    if (!Builder::isEnabled()) {
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
      'rest_endpoint' => get_rest_url(),
      'admin_post_edit_url' => get_admin_url(path: 'post.php?action=edit&post='),
      'moduleBlueprints' => Builder::moduleBlueprints(),
      'globalSections' => Builder::getGlobals(),
      'globalModules' => Builder::getGlobalModules(),
      'moduleStyles' => Builder::getModuleStyles(),
      // 'registered_image_sizes' => static::get_all_image_sizes(),
      'registered_post_types' => get_post_types(['_builtin' => false]),
      'builder_options' => array_merge_recursive(static::get_default_options(), static::get_acf_options()),
    ]);

    // Module Blueprints
    echo "<script id='config' type='application/json'>{$config}</script>";

    // This Div Loads Vue
    echo '<div id="app"></div>';

    // This style hides the WordPress text editor.
    echo '<style>#postdivrich { display: none !important; }</style>';

    if (config('builder.dev_mode')) {
      echo '<script type="module" src="http://localhost:3000/src/main.ts"></script>';
      echo '<script defer>window.addEventListener("buildy:ready", () => window.Buildy.start())</script>';
    }
  }

  public static function get_default_options()
  {
    $default_options = [];

    if (class_exists('ACF')) {
      $file = @file_get_contents(get_template_directory() . '/backend-editor/gui/defaults/options.json');
      if ($file === false) {
        return [];
      }
      $json_data = json_decode(
        $file,
        true
      );
      $default_options = $json_data;
    }

    return $default_options;
  }

  public static function get_acf_options()
  {
    $acf_options = [];

    if (class_exists('ACF')) {
      $acf_options['theme_colours'] = get_field('buildystrap_theme_colours_included', 'option') ?? [];
      $acf_options['additional_colours'] = get_field(
        'buildystrap_theme_colours_additional_colours',
        'option'
      ) ?? [];
      $acf_options['structure'] = get_field('buildystrap_structure', 'option') ?? [];
      $acf_options['typography'] = get_field('buildystrap_typography', 'option') ?? [];
      $acf_options['module_styles'] = get_field('buildystrap_module_styles', 'option') ?? [];
    }

    return $acf_options;
  }

  public static function admin_wp_default_editor($r): mixed
  {
    if (!Builder::isEnabled()) {
      return $r;
    }

    return 'html'; // HTML / Text tab in TinyMCE
  }

  public static function search_engine_notice()
  {
    if (get_option('blog_public') === '0') {
      $notice_class = 'notice notice-error';
      $notice_message = '<h2 style="color: red; margin-top: 0; padding-top: 0;" class="blink-2">Search Engine Visibility is disabled!</h2>';
      $notice_message .= 'Please enable it <a href="' . site_url() . '/wp-admin/options-reading.php">here</a>';
      $notice_message .= '<style> .blink-2 { animation: blinker 2s linear infinite; } @keyframes blinker { 50% { opacity: 0; } }</style>';
      $notice_message = __($notice_message);

      printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($notice_class), $notice_message);

      unset($notice_class);
      unset($notice_message);
    }
  }

  public static function nofollow_meta()
  {
    echo "<meta name='robots' content='noindex,nofollow' />\n";
  }
}
