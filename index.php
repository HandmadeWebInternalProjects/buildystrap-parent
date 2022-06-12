<?php
// Exit if accessed directly.

use Buildystrap\Builder;
use Buildystrap\Theme;

defined('ABSPATH') || exit;

// echo Buildystrap\Builder::renderFromContent(get_the_content())->render();

// Blade
echo view()->first(Theme::get_template_hierarchy(), get_defined_vars())->render();
