<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Plugin Compatibility Settings
    |--------------------------------------------------------------------------
    |
    | Configure which plugins should have compatibility enabled and any
    | specific settings for those integrations.
    |
    */

    'enabled' => true,    'plugins' => [
        'link_juicer' => [
            'enabled' => true,
            'priority' => 99,
            'hooks' => ['the_buildystrap_content'],
            'show_admin_notice' => false, // Set to true to show admin notice
        ],
        
        'woocommerce' => [
            'enabled' => true,
            'load_assets' => true,
            'safe_shortcodes' => true,
            'enqueue_on_builder_pages' => true,
        ],
        
        'gravity_forms' => [
            'enabled' => true,
            'auto_enqueue' => true,
            'safe_shortcodes' => true,
            'preload_scripts' => false,
        ],

        'yoast_seo' => [
            'enabled' => true,
            'meta_description_support' => true,
            'structured_data' => true,
            'opengraph_support' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Compatibility Classes
    |--------------------------------------------------------------------------
    |
    | Register custom compatibility classes here. These will be loaded
    | automatically if the corresponding plugins are active.
    |
    */

    'custom_classes' => [
        // 'CustomPluginCompatibility::class',
    ],

    /*
    |--------------------------------------------------------------------------
    | Safe Shortcodes
    |--------------------------------------------------------------------------
    |
    | Define shortcodes that are safe to use within the page builder.
    | These will not be stripped out during content processing.
    |
    */

    'safe_shortcodes' => [
        'gallery',
        'audio',
        'video',
        'playlist',
        'embed',
    ],
];
