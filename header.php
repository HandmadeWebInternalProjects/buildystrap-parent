<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

// Blade
echo view('partials.header', get_defined_vars())->render();
