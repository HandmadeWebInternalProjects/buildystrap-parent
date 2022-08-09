<?php

// Generate branding css
use Buildystrap\Str;

function save_theme_css_settings()
{
    $screen = get_current_screen();
    if (Str::contains($screen->id, ['site-options', 'buildystrap-settings'])) {
        $css_dir = get_stylesheet_directory();
        $template_dir = get_template_directory();

        ob_start(); // Capture all output into buffer

        require $template_dir . '/src/generate-theme-options-css.php'; // Grab the custom style php file

        $css = ob_get_clean(); // Store output in a variable, then flush the buffer

        file_put_contents($css_dir . '/public/hmw-theme-options.css', $css, LOCK_EX); // Save it as a css file
    }
}

if (function_exists('get_field')) {
    add_action('acf/save_post', 'save_theme_css_settings', 20);
}
