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


        register_rest_route('buildy/v1', '/get_image_sizes', [
            'methods' => 'GET',
            'callback' => [static::class, 'get_image_sizes'],
            'permission_callback' => '__return_true',
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
