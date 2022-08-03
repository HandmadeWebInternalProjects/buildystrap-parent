<?php

use Buildystrap\Builder;
use Buildystrap\BuilderApi;
use Buildystrap\BuilderBackend;
use Buildystrap\BuilderCPT;
use Buildystrap\Theme;

BuilderCPT::boot();
include __DIR__ . '/acf.php';

add_action('init', [Builder::class, 'boot']);
add_action('init', [BuilderApi::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);

add_filter('buildystrap::builder::container', function ($container) {
});

/****************************************************************************************************************
* Include Theme Options // used for global fields (e.g social icons)
*/
include get_template_directory() . '/src/theme_options.php';
