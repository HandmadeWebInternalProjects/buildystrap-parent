<?php

use Buildystrap\Builder;
use Buildystrap\BuilderBackend;
use Buildystrap\Theme;

add_action('init', [Builder::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);

add_action('buildystrap::builder::boot', function () {
    Builder::registerBackendScript('text', get_template_directory_uri().'/buildy-addons/test/test.js');
});
