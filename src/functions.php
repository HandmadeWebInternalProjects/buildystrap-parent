<?php

use Buildystrap\Builder;
use Buildystrap\BuilderBackend;
use Buildystrap\Theme;
use Buildystrap\Builder\Modules\Text;

add_action('init', [Builder::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);


 add_action('buildystrap::builder::boot', function () {
        Builder::registerAddon(
            'text',
            Text::class,
            __DIR__.'/resources/views',
            [
                'stylesheet' => '',
                'script' => get_template_directory_uri().'/buildy-addons/test/test.js',
            ]
        );
    });