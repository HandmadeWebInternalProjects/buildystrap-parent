<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

// Blade
echo view('partials.footer', get_defined_vars())->render();
