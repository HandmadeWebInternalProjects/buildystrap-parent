<?php

function register_buildy_acf_options_page()
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

add_action('acf/init', 'register_buildy_acf_options_page');
