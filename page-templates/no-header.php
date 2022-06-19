<?php
/**
 * Template Name: No header.
 */

use Buildystrap\Theme;

// Exit if accessed directly.
defined('ABSPATH') || exit;

echo view()->first(Theme::get_template_hierarchy(), get_defined_vars())->render();
