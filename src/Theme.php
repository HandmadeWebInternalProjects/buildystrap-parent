<?php

namespace Buildystrap;

use WP_Upgrader;

use function add_action;
use function add_actions;
use function add_filters;
use function array_merge;
use function cache;
use function config;
use function do_action;
use function get_template_directory_uri;
use function glob;
use function is_file;
use function is_plugin_active;
use function storage_path;
use function unlink;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_get_theme;

class Theme
{
  protected static bool $booted = false;

  protected static array $templates = [];

  public static function boot(): void
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
   */
  public static function enqueue_styles(): void
  {
    $stylesheet = is_plugin_active(
      'woocommerce/woocommerce.php'
    ) ? 'parent-style-woocommerce.css' : 'parent-style.css';

    if (bs_get_field('buildystrap_structure_use_bootstrap_bundle', 'option')) {
      wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css');
      wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
      wp_enqueue_style('defaults', get_template_directory_uri() . '/public/defaults.css', []);

      wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js', [], '5.2.1', true);
      wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', [], '', true);
      wp_enqueue_script('defaults', get_template_directory_uri() . '/public/defaults.js', [], '', true);
    }

    wp_enqueue_style(
      'parent-style',
      get_template_directory_uri() . "/public/{$stylesheet}",
      [],
      wp_get_theme('buildystrap-parent')->get('Version')
    );

    wp_enqueue_style('hmw-theme-options', get_stylesheet_directory_uri() . '/public/hmw-theme-options.css', []);

    // Font / Line Awesome
    if (bs_get_field('buildystrap_typography_enable_font_awesome', 'option')) {
      wp_enqueue_style('font-awesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css");
    }
    if (bs_get_field('buildystrap_typography_enable_line_awesome', 'option')) {
      wp_enqueue_style('line-awesome', "https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css");
    }
  }

  /**
   * Enqueue Theme Scripts.
   */
  public static function enqueue_scripts(): void
  {
    wp_enqueue_script(
      'parent-script',
      get_template_directory_uri() . '/public/parent-script.js',
      [],
      wp_get_theme('buildystrap-parent')->get('Version')
    );
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

  public static function clear_on_update($upgrader = null, $options = []): void
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

  public static function optimize_clear(): void
  {
    // view:clear
    static::view_clear();

    // cache:clear
    static::cache_clear();

    // clear-compiled
    static::clear_compiled();
  }

  public static function view_clear(): void
  {
    $path = config('view.compiled');

    foreach (glob("{$path}/*") as $view) {
      unlink($view);
    }
  }

  public static function cache_clear(): void
  {
    cache()->clear();
  }

  public static function clear_compiled(): void
  {
    if (is_file($servicesPath = storage_path('framework/cache/packages.php'))) {
      @unlink($servicesPath);
    }

    if (is_file($packagesPath = storage_path('framework/cache/services.php'))) {
      @unlink($packagesPath);
    }
  }
}
