<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Traits\Augment;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

use function collect;
use function is_string;

abstract class Field implements Htmlable
{
  use Augment;

  protected mixed $value;
  protected mixed $raw;
  protected string $additional_classes = '';

  public function __construct(mixed $value)
  {
    $this->value = $value;
    $this->raw = $value;
  }

  public static function getBlueprint(): Collection
  {
    return collect(static::blueprint());
  }

  abstract protected static function blueprint(): array;

  public function raw(): mixed
  {
    return $this->raw;
  }

  public function __toString(): string
  {
    $value = $this->value();

    return match (true) {
      is_string($value) => $value,
      default => "<!-- {$this->type()} could not output value as a string -->"
    };
  }

  public function toHtml(): string
  {
    return $this->__toString();
  }

  public function withClass(string $class): self
  {
    $this->additional_classes = $class;
    return $this;
  }

  public function value(): mixed
  {
    return $this->augmented()->value;
  }

  public function set(string $key, mixed $value): self
  {
    $this->augmented()->$key = $value;
    return $this;
  }

  public static function process_merge_tags($input_string)
  {
    preg_match_all('/{([^}|]+)(\|[^}]+)?}/', $input_string, $matches);

    foreach ($matches[1] as $index => $match) {
      $id = get_the_ID();
      $match = trim($match);
      $parts = explode(':', $match);
      $function_type = trim($parts[0]);
      $function_name = "";
      $params = isset($matches[2][$index]) ? explode(',', trim($matches[2][$index], '| ')) : [];

      if (count($parts) > 1) {
        $field = $parts[1];
      }

      if ($function_type === 'acf') {
        $function_name = 'bs_get_field';
        array_unshift($params, $field, $id);
      } elseif ($function_type === 'meta') {
        $function_name = 'get_post_meta';
        array_unshift($params, $id, $field, true);
      } elseif ($function_type === 'thumbnail') {
        $function_name = 'get_the_post_thumbnail';
        $size = isset($params[0]) ? trim($params[0]) : 'full';
        $params = array($id, $size);
      } elseif ($function_type == 'date') {
        $function_name = 'get_the_date';
        $params = [];
      } else {
        $function_name = "get_the_{$match}";
        array_unshift($params, $id);
      }

      // Call the appropriate WordPress function with the spread args.
      if (function_exists($function_name)) {
        // json_decode each param to allow for passing arrays as params.
        $result = call_user_func_array($function_name, array_map('convert_param_value', $params));
        $input_string = str_replace($matches[0][$index], $result, $input_string);
      }
    }

    return $input_string;
  }

  /**
   * Populate from wp_query
   */
  public static function get_options_from_query($query = array())
  {
    $select     = array();
    $query      = (isset($query)) ? $query : array();
    $query_args = array();
    $type = $query['type'] ?? null;

    /**
     * Make possible to have different args for different pages.
     */
    if (isset($query['args']) && is_array($query['args'])) {

      // Check if multi_query is set
      if (isset($query['args']['multi_query']) && true === $query['args']['multi_query']) {

        foreach ($query['args'] as $args) {

          // Skip if not an array (eg. 'multi_query' => true )
          if (!is_array($args)) {
            continue;
          }
          global $post;
          $display_on = $args['display_on'];

          // 'disply_on' is the post slog or id
          if ((is_array($display_on) && in_array($post->post_name, $display_on)) ||
            (!is_array($display_on) && $display_on == $post->post_name) ||
            (is_array($display_on) && in_array($post->ID, $display_on)) ||
            (!is_array($display_on) && $display_on == $post->ID)
          ) {

            // remove 'display_on'
            unset($args['display_on']);
            // set args
            $query_args = $args;
          }
        }
      } else {
        $query_args = $query['args'];
      }
    }

    switch ($type) {

      case 'pages':
      case 'page':

        $pages = get_pages($query_args);

        if (!is_wp_error($pages) && !empty($pages)) {
          foreach ($pages as $page) {
            $select[$page->post_title] = $page->ID;
          }
        }

        break;

      case 'posts':
      case 'post':

        $posts = get_posts($query_args);

        if (!is_wp_error($posts) && !empty($posts)) {
          foreach ($posts as $post) {
            $select[$post->post_title] = $post->ID;
          }
        }

        break;

      case 'categories':
      case 'category':

        $categories = get_categories($query_args);

        if (!is_wp_error($categories) && !empty($categories) && !isset($categories['errors'])) {
          foreach ($categories as $category) {
            $select[$category->name] = $category->term_id;
          }
        }

        break;

      case 'tags':
      case 'tag':

        $taxonomies = (isset($query_args['taxonomies'])) ? $query_args['taxonomies'] : 'post_tag';
        $tags       = get_terms($taxonomies, $query_args);

        if (!is_wp_error($tags) && !empty($tags)) {
          foreach ($tags as $tag) {
            $select[$tag->name] = $tag->term_id;
          }
        }

        break;

      case 'menus':
      case 'menu':

        $menus = wp_get_nav_menus($query_args);

        if (!is_wp_error($menus) && !empty($menus)) {
          foreach ($menus as $menu) {
            $select[$menu->name] = $menu->term_id;
          }
        }

        break;

      case 'post_types':
      case 'post_type':

        $query_args['show_in_nav_menus'] = true;
        $post_types                      = get_post_types($query_args);

        if (!is_wp_error($post_types) && !empty($post_types)) {
          foreach ($post_types as $post_type) {
            $select[ucfirst($post_type)] = $post_type;
          }
        }

        break;

      case 'users':
      case 'user':

        $users = get_users($query_args);

        /**
         * key:   the name in select
         * value: the value in select
         */
        $key   = (isset($query['key'])) ? sanitize_key($query['key']) : 'ID';
        $value = (isset($query['value'])) ? sanitize_key($query['value']) : 'user_login';

        if (!is_wp_error($users) && !empty($users)) {
          foreach ($users as $user) {
            $select[$user->{$value}] = $user->{$key};
          }
        }

        break;

      case 'custom':
      case 'callback':

        global $post;

        if (is_callable($query['function'])) {
          $select = call_user_func($query['function'], $query_args, $post);
        }

        break;
    }

    // dd($select);

    return $select;
  }
}
