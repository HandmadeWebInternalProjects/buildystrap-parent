<?php

namespace Buildystrap;

use Buildystrap\Builder\Content;
use Buildystrap\Builder\Extends\Field;
use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Fields\AccordionField;
use Buildystrap\Builder\Fields\ButtonField;
use Buildystrap\Builder\Fields\CodeField;
use Buildystrap\Builder\Fields\ColorSelectField;
use Buildystrap\Builder\Fields\ImageField;
use Buildystrap\Builder\Fields\LinkField;
use Buildystrap\Builder\Fields\MediaField;
use Buildystrap\Builder\Fields\RadioButtonsField;
use Buildystrap\Builder\Fields\RelationalField;
use Buildystrap\Builder\Fields\ReplicatorField;
use Buildystrap\Builder\Fields\RichTextField;
use Buildystrap\Builder\Fields\SelectField;
use Buildystrap\Builder\Fields\TabField;
use Buildystrap\Builder\Fields\TextAreaField;
use Buildystrap\Builder\Fields\TextField;
use Buildystrap\Builder\Fields\TitleField;
use Buildystrap\Builder\Fields\ToggleField;
use Buildystrap\Builder\Layout\Container;
use Buildystrap\Builder\Modules\AccordionModule;
use Buildystrap\Builder\Modules\ButtonModule;
use Buildystrap\Builder\Modules\CardModule;
use Buildystrap\Builder\Modules\CodeModule;
use Buildystrap\Builder\Modules\DividerModule;
use Buildystrap\Builder\Modules\GalleryModule;
use Buildystrap\Builder\Modules\HeaderModule;
use Buildystrap\Builder\Modules\ImageModule;
use Buildystrap\Builder\Modules\PostGridModule;
use Buildystrap\Builder\Modules\SliderModule;
use Buildystrap\Builder\Modules\TabModule;
use Buildystrap\Builder\Modules\TextModule;
use Buildystrap\Builder\Modules\VideoModule;
use Buildystrap\Builder\Renderer;
use Exception;
use Illuminate\Support\Collection;

use function add_filter;
use function array_merge;
use function class_extends;
use function collect;
use function config;
use function do_action;
use function get_current_screen;
use function get_post;
use function get_post_meta;
use function get_the_ID;
use function in_array;
use function is_admin;
use function json_decode;
use function view;

use const REST_REQUEST;

class Builder
{
  protected static bool $booted = false;

  protected static array $fields = [
    'accordion-field' => AccordionField::class,
    'tab-field' => TabField::class,
    'text-field' => TextField::class,
    'textarea-field' => TextAreaField::class,
    'link-field' => LinkField::class,
    'toggle-field' => ToggleField::class,
    'code-field' => CodeField::class,
    'color-select-field' => ColorSelectField::class,
    'select-field' => SelectField::class,
    'richtext-field' => RichTextField::class,
    'title-field' => TitleField::class,
    'button-field' => ButtonField::class,
    'media-field' => MediaField::class,
    'image-field' => ImageField::class,
    'radio-buttons-field' => RadioButtonsField::class,
    'relational-field' => RelationalField::class,
    'replicator-field' => ReplicatorField::class,
  ];

  protected static array $modules = [
    'card-module' => CardModule::class,
    'text-module' => TextModule::class,
    'code-module' => CodeModule::class,
    'divider-module' => DividerModule::class,
    'post-grid-module' => PostGridModule::class,
    'gallery-module' => GalleryModule::class,
    'image-module' => ImageModule::class,
    'button-module' => ButtonModule::class,
    'header-module' => HeaderModule::class,
    'tab-module' => TabModule::class,
    'accordion-module' => AccordionModule::class,
    'slider-module' => SliderModule::class,
    'video-module' => VideoModule::class,
  ];

  protected static array $paths = [];
  protected static array $scripts = [];
  protected static array $styles = [];

  /**
   * @throws Exception
   */
  public static function boot(): void
  {
    if (!static::$booted) {
      static::$booted = true;

      add_filter('the_content', [static::class, 'the_content'], PHP_INT_MAX);

      static::bootFields();
      static::bootModules();
      static::bootPaths();

      do_action('buildystrap::builder::boot');
    }
  }

  /**
   * @throws Exception
   */
  protected static function bootFields(): void
  {
    foreach (static::$fields as $field) {
      if (!class_extends($field, Field::class)) {
        throw new Exception("{$field} does not extend " . Field::class);
      }
    }
  }

  /**
   * @throws Exception
   */
  protected static function bootModules(): void
  {
    foreach (static::$modules as $module) {
      if (!class_extends($module, Module::class)) {
        throw new Exception("{$module} does not extend " . Module::class);
      }
    }
  }

  protected static function bootPaths(): void
  {
    $paths = collect(config('view.paths'))
      ->map(fn ($path) => "$path/builder")->toArray();

    view()->addNamespace('builder', $paths);

    static::$paths = collect($paths)
      ->map(fn ($path) => "$path/modules")->toArray();

    view()->addNamespace('builder-modules', static::paths());
  }

  public static function paths(): array
  {
    return static::$paths;
  }

  /**
   * @throws Exception
   */
  public static function registerField(string $handle, string $field): array
  {
    if (!class_extends($field, Field::class)) {
      throw new Exception("{$field} does not extend " . Field::class);
    }

    static::$fields[Str::slug($handle)] = $field;

    return static::fields();
  }

  public static function fields(): array
  {
    return static::$fields;
  }

  public static function getField(string $handle): mixed
  {
    return Arr::get(static::fields(), Str::slug($handle));
  }

  public static function getModuleStyles(): Collection
  {
    if (!function_exists('get_field')) {
      return collect();
    }

    $shared = get_field('buildystrap_module_styles_shared', 'option') ?: [];
    $modules = get_field('buildystrap_module_styles_modules', 'option') ?: [];

    if ($shared) {
      $shared = ['module_name' => 'shared', 'styles' => $shared];
      array_push($modules, $shared);
    }

    return collect($modules ?? [])->map(fn ($module) => [
      'module_name' => Str::slug($module['module_name']) . '-module',
      'styles' => $module['styles'] ?? [],
    ]);
  }

  public static function getGlobals(): Collection
  {
    global $wpdb;

    $query = $wpdb->prepare(
      "SELECT 
                `ID` AS `id`, 
                `post_title` AS `title` 
            FROM `{$wpdb->prefix}posts` 
            WHERE 
                `post_type` = 'buildy-global' 
                 AND 
                    `post_status` = %s",
      'publish'
    );

    $globals = $wpdb->get_results($query);

    return collect($globals ?? []);
  }

  public static function getGlobalModules(): Collection
  {
    global $wpdb;

    $query = $wpdb->prepare(
      "SELECT 
                `ID` AS `id`, 
                `post_title` AS `title` 
            FROM `{$wpdb->prefix}posts` 
            WHERE 
                `post_type` = 'buildy-global-module' 
                AND 
                    `post_status` = %s",
      'publish'
    );

    $globals = $wpdb->get_results($query);

    return collect($globals ?? []);
  }

  public static function getLibrarySections(): Collection
  {
    global $wpdb;

    $query = $wpdb->prepare(
      "SELECT 
                `ID` AS `id`, 
                `post_title` AS `title` 
            FROM `{$wpdb->prefix}posts` 
            WHERE 
                `post_type` = 'buildy-library' 
                AND 
                    `post_status` = %s",
      'publish'
    );

    $sections = $wpdb->get_results($query);

    return collect($sections ?? []);
  }

  public static function getGlobal(int $post_id, $wrapper = null): ?Container
  {
    global $wpdb;

    $query = $wpdb->prepare(
      "SELECT 
                `ID` AS `id`, 
                `post_title` AS `title`, 
                `post_content` AS `content` 
            FROM `{$wpdb->prefix}posts` 
            WHERE 
                `ID` = %d 
                AND 
                    `post_type` = 'buildy-global' 
                AND 
                    `post_status` = %s 
            LIMIT 1",
      $post_id,
      'publish'
    );

    if ($global = $wpdb->get_row($query)) {
      $content = new Content($global->content, $wrapper);

      return $content->container();
    }

    return null;
  }

  public static function getGlobalModule(int $post_id, $wrapper = null): ?Module
  {
    global $wpdb;

    $query = $wpdb->prepare(
      "SELECT 
                `ID` AS `id`, 
                `post_title` AS `title`, 
                `post_content` AS `content` 
            FROM `{$wpdb->prefix}posts` 
            WHERE 
                `ID` = %d 
                AND 
                    `post_type` = 'buildy-global-module' 
                AND 
                    `post_status` = %s
            LIMIT 1",
      $post_id,
      'publish'
    );

    if ($global = $wpdb->get_row($query)) {
      $module = json_decode($global->content, true);
      $_module = static::getModule($module['type']);

      return new $_module($module, $wrapper = null);
    }

    return null;
  }

  public static function getModule(string $handle): mixed
  {
    return Arr::get(static::modules(), Str::slug($handle));
  }

  public static function modules(): array
  {
    return static::$modules;
  }

  /**
   * @throws Exception
   */
  public static function registerModule(string $handle, string $module): array
  {
    if (!class_extends($module, Module::class)) {
      throw new Exception("$module does not extend " . Module::class);
    }

    static::$modules[Str::slug($handle)] = $module;

    return static::modules();
  }

  public static function moduleBlueprints(): Collection
  {
    return collect(static::modules())->map(fn ($module): Collection => $module::getBlueprint());
  }

  public static function registerPath(string $path): void
  {
    if (!in_array($path, static::paths())) {
      view()->addNamespace('builder-modules', $path);
      static::$paths[] = $path;
    }
  }

  public static function getBackendScripts(): array
  {
    return static::$scripts;
  }

  public static function registerBackendScript(string $handle, string $script): void
  {
    static::$scripts[Str::slug($handle)] = $script;
  }

  public static function getBackendStyles(): array
  {
    return static::$styles;
  }

  public static function registerBackendStyle(string $handle, string $style): void
  {
    static::$styles[Str::slug($handle)] = $style;
  }

  public static function the_content(string $content): string
  {
    /*
                 * Possibly crude way of intercepting the output of the_content()
                 * We intercept the_content() via a Wordpress filter.
                 * Normally you would modify $content in some way and then return it as normal.
                 *
                 * However in this case, we want the raw unformatted content.
                 */
    if (static::isEnabled() && $post = get_post()) {
      if (is_admin() || defined('REST_REQUEST') && REST_REQUEST) {
        return ''; // Stop render on backend Or via REST.
      }

      return !empty($post->post_content) ? static::renderFromContent($post->post_content)->render() : $content;
    }

    /*
                 * If the Page Builder was not enabled on this post.
                 * Return the content, as is.
                 */
    return $content;
  }

  public static function isEnabled(int $post_id = 0): bool
  {
    $isEnabled = false;

    if ($post_id === 0) {
      $post_id = get_the_ID();
    }

    if (is_admin()) {
      $screen = get_current_screen();

      if ($screen && $screen->base === 'post') {
        // Buildy globals are always enabled
        if (in_array($screen->post_type, ['buildy-global', 'buildy-library', 'buildy-global-module'])) {
          return true;
        }

        if (in_array($screen->post_type, static::enabledTypes())) {
          $isEnabled = !empty(get_post_meta($post_id, '_buildy_enabled', true));
        }
      }
    } else {
      $isEnabled = !empty(get_post_meta($post_id, '_buildy_enabled', true));
    }

    return $isEnabled;
  }

  public static function enabledTypes(): array
  {
    $defaults = ['page', 'buildy-library'];

    return array_merge($defaults, config('builder.enabled_post_types', []));
  }

  public static function renderFromContent(string $content): Renderer
  {
    $content = new Content($content);

    return new Renderer($content->container());
  }
}
