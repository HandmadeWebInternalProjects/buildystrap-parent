<?php
/**
 * Template Name: No header.
 */

use Buildystrap\Theme;

// Exit if accessed directly.
defined('ABSPATH') || exit;

$template = 'layouts.no-header';

echo view()->first(Theme::get_template_hierarchy(), get_defined_vars())->render();
