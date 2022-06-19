<?php

use Buildystrap\Theme;

defined('ABSPATH') || exit;

echo view()->first(Theme::get_template_hierarchy())->render();
