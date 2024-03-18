<?php

namespace Buildystrap;

use function add_action;
use function add_menu_page;
use function add_submenu_page;

class BuilderCPT
{
    public static function boot(): void
    {
        add_action('admin_menu', [static::class, 'register_menu']);
        static::register_buildy_custom_post_types();
    }

    protected static function register_buildy_custom_post_types(): void
    {
        /**
         * Post Type: Buildystrap Globals.
         */
        register_post_type('buildy-global', [
      'label' => __('Global Sections', 'buildystrap'),
      'labels' => [
        'name' => __('Buildystrap Global Sections', 'buildystrap'),
        'singular_name' => __('Buildystrap Global Section', 'buildystrap'),
        'menu_name' => __('Global Sections', 'buildystrap'),
        'add_new_item' => __('Add new Global Section', 'buildystrap'),
        'edit_item' => __('Edit Global Section', 'buildystrap'),
      ],
      'description' => '',
      'public' => false,
      'publicly_queryable' => false,
      'show_ui' => true,
      'show_in_rest' => true,
      'rest_base' => '',
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_namespace' => 'wp/v2',
      'has_archive' => false,
      'show_in_menu' => false,
      'show_in_nav_menus' => false,
      'delete_with_user' => false,
      'exclude_from_search' => true,
      'capability_type' => 'page',
      'map_meta_cap' => true,
      'hierarchical' => true,
      'can_export' => true,
      'rewrite' => false,
      'query_var' => true,
      'supports' => ['page-attributes', 'title', 'editor', 'revisions', 'thumbnail'],
      'show_in_graphql' => false,
    ]);

        register_post_type('buildy-library', [
      'label' => __('Library', 'buildystrap'),
      'labels' => [
        'name' => __('Buildystrap Library Sections', 'buildystrap'),
        'singular_name' => __('Buildystrap Library Section', 'buildystrap'),
        'menu_name' => __('Library Sections', 'buildystrap'),
        'add_new_item' => __('Add new Library Section', 'buildystrap'),
        'edit_item' => __('Edit Library Section', 'buildystrap'),
      ],
      'description' => 'Add repeatable sections to the library that you want to use as a template to start from',
      'public' => false,
      'publicly_queryable' => false,
      'show_ui' => true,
      'show_in_rest' => true,
      'rest_base' => '',
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_namespace' => 'wp/v2',
      'has_archive' => true,
      'show_in_menu' => false,
      'show_in_nav_menus' => false,
      'delete_with_user' => false,
      'exclude_from_search' => true,
      'capability_type' => 'page',
      'map_meta_cap' => true,
      'hierarchical' => true,
      'can_export' => true,
      'with_front' => true,
      'rewrite' => true,
      'query_var' => true,
      'supports' => ['page-attributes', 'title', 'editor', 'revisions', 'thumbnail'],
      'show_in_graphql' => false,
    ]);

        /**
         * Post Type: Buildystrap Global Modules.
         */

        register_post_type('buildy-global-module', [
      'label' => __('Global Modules', 'buildystrap'),
      'labels' => [
        'name' => __('Buildystrap Global Modules', 'buildystrap'),
        'singular_name' => __('Buildystrap Global Module', 'buildystrap'),
        'menu_name' => __('Global Modules', 'buildystrap'),
        'add_new_item' => __('Add new Global Module', 'buildystrap'),
        'edit_item' => __('Edit Global Module', 'buildystrap'),
      ],
      'description' => '',
      'public' => false,
      'publicly_queryable' => false,
      'show_ui' => true,
      'show_in_rest' => false,
      'rest_base' => '',
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_namespace' => 'wp/v2',
      'has_archive' => false,
      'show_in_menu' => false,
      'show_in_nav_menus' => false,
      'delete_with_user' => false,
      'exclude_from_search' => true,
      'capability_type' => 'post',
      'map_meta_cap' => true,
      'hierarchical' => true,
      'can_export' => true,
      'rewrite' => false,
      'query_var' => true,
      'supports' => ['page-attributes', 'title', 'editor', 'revisions'],
      'show_in_graphql' => false,
    ]);
    }

    public static function register_menu(): void
    {
        /**
         * Admin Page: Buildystrap.
         */

        add_menu_page(
            __('Buildystrap', 'buildystrap'),
            __('Buildystrap', 'buildystrap'),
            'edit_pages',
            'buildystrap',
            [static::class, 'render_menu'],
            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI5OC45NiIgaGVpZ2h0PSI5MS4wNCIgZmlsbD0iIzFkMjMyNyIgc3Ryb2tlPSIjMWQyMzI3IiBzdHlsZT0iLXdlYmtpdC10ZXh0LXN0cm9rZS1jb2xvcjogcmdiKDI1NSwgMjU1LCAyNTUpOyI+PHBhdGggc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMjcuMTY4IDU4LjEwN3MtLjUgMi4zNzcgNC4zMzMgNS4xMTNjNC44MzMgMi43MzYgNi44MzMgMi43MzYgNi44MzMgMi43MzZzLTIuNzUtMy0yLjQxNy00LjQxN2MuMzMzLTEuNDE3IDUuNDE3IDQuMDgzIDEwLjMzMyAyLjQxNyAwIDAtMS42NTUtMS41OTEtMi45NTMtNS4wMDQtMS4wODktMi43MjUtMi4xNTctMy41OS0zLjAwNi00LjI4OCAwIDAgNi43MDgtNy4xMjUgNC45NTgtMTcuMTI1IDAgMC0uNzUtNC43NS0zLjUtNy43NSAwIDAgNi4xNjcgOC4xNjcgMTYuNSAzLjQxNyAwIDAtMS4xNjctMy43NS01LjgzMy02LjkxN3MtOC4yNS0xLjMzMy0xMi41ODMtMS40MTdjLTQuMzMzLS4wODMtNS4yNS0zLjY2Ny01LjI1LTMuNjY3cy0zIDIuNzUtNi4zMzMgMS42NjctMy4yNS0zLjI1LTguMTY3LTEuNjY3LTkuMDgzIDcuNS05LjA4MyA3LjUgOC4zMzMgNS4zMzMgMTIuODMzLTIuNTgzYzAgMC00IDEwLjUtNS42NjcgMTQtMS42NjcgMy41LTcuNSAyMC41IDE0IDE3LjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjwvcGF0aD48cGF0aCBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGQ9Ik0yNC4zNTEgMjAuODdzNi45MDEtNy43MDUgMTEuNDAxLTguODkzYzQuNS0xLjE4OCA2LjMzNC0xLjE4NSA4LjQzOC0uNjI1bC0yLjY5MSAyLjY4My03Ljk1NiA3LjkzMnM4Ljk2LTEwLjYxNiAxOC4xNDctNy45OTFsLTguNTM1IDEwLjY4NyIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjwvcGF0aD48Y2lyY2xlIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgY3g9IjIzLjI1MiIgY3k9IjM2LjI5IiByPSIuNzUiIGZpbGw9Im5vbmUiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48L2NpcmNsZT48Y2lyY2xlIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgY3g9IjM4LjQxOCIgY3k9IjM3Ljc5IiByPSIuNzUiIGZpbGw9Im5vbmUiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48L2NpcmNsZT48cGF0aCBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGQ9Ik0yMS4xNjggNDkuNTRzMy4yOTIuNzUgMy42MjUgMy4yMDhNMjguMjAzIDUzLjU5N3MxLjYyNS0yLjQxNyA0LjkxNy0xLjg3NSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48L3BhdGg+PHBhdGggc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNNDUuNDg0IDM5LjM3NXMyLjg1MSA2LjU4MiAxMi4xMDEgNi40MTVjOS4yNS0uMTY3IDIyLjE2NyA0IDIzLjQxNyAxMS4xNjdzLTEuMDYyIDIyLjI1LTQuMTQ2IDIzLjA4M2gtNi4xNjdsLS40MzgtMTEuNXMtMi4wODMgMS41ODMtNy41ODMgMS41ODMtOC41LTMuNjY3LTguNS0zLjY2NyIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjwvcGF0aD48cGF0aCBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGQ9Ik00Mi42MjYgNjQuMDg2czYuMjA5IDE1LjUzNyA5Ljg3NSAxNS45NTRoNi41ODRWNjkuNTciIGZpbGw9Im5vbmUiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48L3BhdGg+PHBhdGggc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMzguMzM1IDY1Ljk1N3M0LjU4MyAxNC4wODMgOC42NjcgMTQuMDgzaDUuNU02NC44MzQgNzAuMDMybDIgMTAuMDA4aDQuNDE4TTc5LjM4OSA1My41MjJzNC45NDYgMy44MSA4LjU3MS4yNjhjMCAwLTEuMzA4IDcuOTU4LTYuNjEzIDguMDgzIiBmaWxsPSJub25lIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PC9wYXRoPjxwYXRoIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgZD0iTTI3Ljk3MyAxNi41ODhzMy4yMTYgMi44MjcgNy40NjYgMi40NTJNMzIuOTAzIDEyLjk2czEuMjExIDMuMTkgNi44NDIgMi44MjNNMzguMDIgMTguMTY1czIuMjYyIDQuMjM3IDguMDU5IDIuODM3TTQzLjExIDE0Ljc5M3MuODU3IDIuOTU4IDUuNzQ5IDIuNzI4IiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjwvcGF0aD48L3N2Zz4=',
            80
        );

        add_submenu_page(
            'buildystrap',
            'Buildystrap Global Sections',
            'Global Sections',
            'edit_pages',
            '/edit.php?post_type=buildy-global'
        );
        add_submenu_page(
            'buildystrap',
            'Buildystrap Library',
            'Library Sections',
            'edit_pages',
            '/edit.php?post_type=buildy-library'
        );
        add_submenu_page(
            'buildystrap',
            'Buildystrap Global Modules',
            'Global Modules',
            'edit_pages',
            '/edit.php?post_type=buildy-global-module'
        );
    }

    public static function render_menu(): void
    {
        echo view('wp-admin.cpt-menu', [])->render();
    }
}
