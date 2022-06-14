<?php

use Buildystrap\Theme;

defined('ABSPATH') || exit;

// Blade
echo view()->first(Theme::get_template_hierarchy(), get_defined_vars())->render();
