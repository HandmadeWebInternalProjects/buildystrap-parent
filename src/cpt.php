<?php

if ( ! function_exists('register_buildy_custom_post_types')) {
    function register_buildy_custom_post_types(): void
    {
        /**
         * Post Type: Buildy Globals.
         */

        $labels = [
            'name' => __('Buildy Globals', 'buildystrap'),
            'singular_name' => __('Buildy Global', 'buildystrap'),
        ];

        $args = [
            'label' => __('Buildy Globals', 'buildystrap'),
            'labels' => $labels,
            'description' => '',
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_rest' => false,
            'rest_base' => '',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'rest_namespace' => 'wp/v2',
            'has_archive' => false,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'delete_with_user' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'can_export' => true,
            'rewrite' => false,
            'query_var' => true,
            'supports' => ['title', 'editor', 'revisions'],
            'show_in_graphql' => false,
        ];

        register_post_type('buildy-global', $args);

        /**
         * Post Type: Buildy Global Modules.
         */

        $labels = [
            'name' => __('Buildy Global Modules', 'buildystrap'),
            'singular_name' => __('Buildy Global Module', 'buildystrap'),
        ];

        $args = [
            'label' => __('Buildy Global Modules', 'buildystrap'),
            'labels' => $labels,
            'description' => '',
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_rest' => false,
            'rest_base' => '',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'rest_namespace' => 'wp/v2',
            'has_archive' => false,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'delete_with_user' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'can_export' => true,
            'rewrite' => false,
            'query_var' => true,
            'supports' => ['title', 'editor', 'revisions'],
            'show_in_graphql' => false,
        ];

        register_post_type('buildy-global-module', $args);
    }
}

add_action('init', 'register_buildy_custom_post_types');
