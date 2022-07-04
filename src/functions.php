<?php

use Buildystrap\Builder;
use Buildystrap\BuilderApi;
use Buildystrap\BuilderBackend;
use Buildystrap\Theme;

include __DIR__ . '/cpt.php';

add_action('init', [Builder::class, 'boot']);
add_action('init', [BuilderApi::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);
