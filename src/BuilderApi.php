<?php

namespace Buildystrap;

use WP_Error;
use WP_REST_Response;

use function __;
use function register_rest_route;

class BuilderApi
{
    protected static bool $booted = false;

    public static function boot(): void
    {
        if ( ! static::$booted) {
            static::$booted = true;

            add_action('rest_api_init', [static::class, 'register_rest_routes']);
        }
    }

    public static function register_rest_routes(): void
    {
        register_rest_route('buildy/v1', '/globals', [
      'methods' => 'GET',
      'callback' => [static::class, 'get_globals'],
      'permission_callback' => '__return_true',
    ]);

        register_rest_route('buildy/v1', '/get_global', [
      'methods' => 'GET',
      'callback' => [static::class, 'get_global_modules'],
      'permission_callback' => '__return_true',
    ]);

        // register rest route to render a page html by an ID passed in the request

        register_rest_route('buildy/v1', '/get_image_sizes', [
      'methods' => 'GET',
      'callback' => [static::class, 'get_image_sizes'],
      'permission_callback' => '__return_true',
    ]);

        register_rest_route('buildy/v1', '/get_fields/(?P<post_type>[A-Za-z0-9_-]+)', [
      'methods' => 'GET',
      'callback' => function ($request) {
          $post_type = $request->get_param('post_type');
          if ( ! function_exists('acf_get_field_groups')) {
              return new WP_REST_Response('ACF is not installed or activated.', 404);
          }

          $field_groups = acf_get_field_groups(['post_type' => $post_type]);
          $fields = [];
          foreach ($field_groups as $field_group) {
              $group_fields = acf_get_fields($field_group['key']);
              $fields = array_merge($fields, get_sub_fields($group_fields));
              // Remove repeater fields - needs work!
              $fields = array_filter($fields, function ($field) {
                  return $field['type'] !== 'repeater';
              });
          }

          return new WP_REST_Response($fields, 200);
      },
    ]);

        register_rest_route('buildy/v1', '/get_field/(?P<meta_key>[A-Za-z0-9_,-]+)', [
      'methods' => 'GET',
      'callback' => function ($request) {
          $meta_key = $request->get_param('meta_key');
          if ( ! function_exists('acf_get_field_groups')) {
              return new WP_REST_Response('ACF is not installed or activated.', 404);
          }
          $meta_key = explode(',', $meta_key);
          $choices = [];

          foreach ($meta_key as $key) {
              $field = get_field_object($key);
              $field['parent_name'] = '';
              if ($field['parent'] ?? false) {
                  // This needs work. Repeaters won't work currently.
                  $parent = acf_get_field($field['parent']);
                  if ($field['type'] === 'repeater') {
                      $field['parent_name'] = $parent ? $parent['name'] . '_$_' : '';
                  } elseif ($field['type'] === 'group') {
                      $field['parent_name'] = $parent ? $parent['name'] . '_' : '';
                  }
              }

              if (empty($field['choices'])) {
                  continue;
              }
              $choices[] = array_map(function ($key, $value) use ($field) {
                  return [
              'meta_key' => $field['parent_name'] . $field['name'],
              'value' => $key,
              'label' => $value . ' - ' . $field['label'],
            ];
              }, array_keys($field['choices']), $field['choices']);
          }

          $choices = array_merge(...$choices);

          return new WP_REST_Response($choices, 200);
      },
    ]);

        register_rest_route('buildy/v1', '/render_module/(?P<id>\d+)', [
      'methods' => 'GET',
      'callback' => [static::class, 'render_module'],
      'permission_callback' => '__return_true',
    ]);

        register_rest_route('buildy/v1', '/fetch-library-post/(?P<id>\d+)', [
      'methods' => 'GET',
      'callback' => [static::class, 'fetch_library_post'],
      'permission_callback' => '__return_true',
    ]);


        register_rest_route('buildy/v1', '/get_image_sizes', [
      'methods' => 'GET',
      'callback' => [static::class, 'get_image_sizes'],
      'permission_callback' => '__return_true',
    ]);
    }

    public static function fetch_library_post($request): WP_Error|WP_REST_Response
    {
        $id = $request->get_param('id');

        $post = get_post($id);

        return new WP_REST_Response([
      'status' => 200,
      'data' => $post,
    ]);
    }

    public static function render_module($request): WP_Error|WP_REST_Response
    {
        $id = $request->get_param('id');

        $post = get_post($id);

        $content = Builder::renderFromContent($post->post_content)->render();

        return new WP_REST_Response([
      'status' => 200,
      'html' => $content,
    ]);
    }

    public static function get_globals($request): WP_Error|WP_REST_Response
    {
        $type = Arr::get($request, 'type');

        if ( ! $type) {
            return new WP_Error(
                'Type missing!',
                __('You must speficy a type of global you wish to retrieve entries for'),
                ['status' => 400]
            );
        }

        $results = $type === 'module' ? Builder::getGlobalModules() : Builder::getGlobals();

        return new WP_REST_Response([
      'status' => 200,
      'data' => $results,
    ]);
    }

    public static function get_image_sizes($request): WP_Error|WP_REST_Response
    {
        $image_sizes = get_registered_image_sizes();

        return new WP_REST_Response([
      'status' => 200,
      'data' => $image_sizes,
    ]);
    }

    public static function get_global_modules($request): WP_Error|WP_REST_Response
    {
        $global_id = Arr::get($request, 'global_id');

        if ( ! $global_id) {
            return new WP_Error(
                'ID Missing!',
                __('You must speficy the ID for the global module you are looking for.'),
                ['status' => 400]
            );
        }

        $result = Builder::getGlobalModule($global_id)->fields()->map->raw();

        return new WP_REST_Response([
      'status' => 200,
      'data' => $result,
    ]);
    }
}
