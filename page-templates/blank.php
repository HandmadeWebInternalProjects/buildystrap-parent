<?php
/**
 * Template Name: No header / footer
 */

use Buildystrap\Theme;

// Exit if accessed directly.
defined('ABSPATH') || exit;

echo view()->first(Theme::get_template_hierarchy())->render();
