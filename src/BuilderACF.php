<?php

namespace Buildystrap;

class BuilderACF
{
  public static function boot()
  {
    if (!class_exists('ACF_Pro')) {
      add_action('admin_notices', function () {
        echo '<div class="error"><p>ACF is not installed. Please install it to use this plugin.</p></div>';
      });
      return;
    }

    add_action('acf/init', [BuilderACF::class, 'register_buildy_acf_options_page']);

    // Keep it in sync when saved
    add_filter("acf/settings/save_json/key=group_62ce4dc3dd60d", [BuilderACF::class, 'custom_acf_json_save_point']); // Fix the undefined constant error

    // Auto load it when needed
    add_filter('acf/settings/load_json', [BuilderACF::class, 'custom_acf_json_load_point']);
  }

  public static function register_buildy_acf_options_page()
  {
    if (function_exists('acf_add_options_page')) {
      acf_add_options_page([
        'page_title' => __('Buildystrap Settings'),
        'menu_title' => __('Settings'),
        'menu_slug' => 'buildystrap-settings',
        'parent_slug' => 'buildystrap',
      ]);
    }
  }

  public static function custom_acf_json_save_point($path)
  {
    // Check if folder exists and if not, make it
    if (!is_dir(get_stylesheet_directory() . '/acf-json')) {
      mkdir(get_stylesheet_directory() . '/acf-json');
    }
    return get_stylesheet_directory() . '/acf-json';
  }

  public static function custom_acf_json_load_point($paths)
  {
    // Remove the original path (optional).
    unset($paths[0]);

    // Append the new path and return it.
    $paths[] = get_stylesheet_directory() . '/acf-json';

    $paths[] = get_template_directory() . '/acf-json';

    return $paths;
  }
}
