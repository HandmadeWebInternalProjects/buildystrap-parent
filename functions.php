<?php

// Exit if accessed directly.

use Buildystrap\Builder;

defined('ABSPATH') || exit;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/
\Roots\bootloader();

add_action('init', [Builder::class, 'boot']);

// Load Understrap functions
require __DIR__.'/understrap/functions.php';

// Load Buildystrap helpers
require __DIR__.'/src/helpers.php';

// Load Buildystrap functions
require __DIR__.'/src/functions.php';
