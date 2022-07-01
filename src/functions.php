<?php

use Buildystrap\Builder;
use Buildystrap\BuilderBackend;
use Buildystrap\Theme;

add_action('init', [Builder::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);
add_action('rest_api_init', [Builder::class, 'register_rest_routes']);
