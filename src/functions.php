<?php

use Buildystrap\Builder;
use Buildystrap\BuilderApi;
use Buildystrap\BuilderBackend;
use Buildystrap\BuilderCPT;
use Buildystrap\Theme;

BuilderCPT::boot();
include __DIR__ . '/acf.php';

add_action('init', [Builder::class, 'boot']);
add_action('init', [BuilderApi::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);

/****************************************************************************************************************
 * Include Theme Options // used for global fields (e.g social icons)
 */
include get_template_directory() . '/src/theme_options.php';

/* Custom Logo */
function custom_logo()
{
    $custom_logo = acf_active() ? get_field('buildystrap_company_details_site_logo', 'option') : null;
    if ( ! acf_active() || ! isset($custom_logo) && empty($custom_logo)) { ?>

        <?php
        if (is_front_page() && is_home()) : ?>

            <h1 class="navbar-brand"><a rel="home" href="<?php
                echo esc_url(home_url('/')); ?>" itemprop="url"><?php
                    bloginfo('name'); ?></a></h1>

        <?php
        else : ?>

            <a class="navbar-brand" rel="home" href="<?php
            echo esc_url(home_url('/')); ?>" itemprop="url"><?php
                bloginfo('name'); ?></a>

        <?php
        endif; ?>

        <?php
    } else {
        echo sprintf(
            '<a class="navbar-brand" href="/"><img class="site-logo" src="%s" alt="%s" /></a>',
            $custom_logo['url'],
            $custom_logo['alt']
        );
    }
}


// Populate colour options
// Add the global colour options to all of these fields
if ( ! function_exists('add_site_color_choices')) {
    add_filter('acf/load_field/key=field_62eb52287454c', 'add_site_color_choices');

    function add_site_color_choices($field)
    {
        $field['choices'] = [];
        if (function_exists('get_theme_colors')) :
            $colours = @get_theme_colors();
            // $colours = [["name" => "red", "value" => "sdf79sf"]];
            if ( ! empty($colours) && (is_array($colours) || is_object($colours))) :
                foreach ($colours as $colour) {
                    $colour_name = trim($colour['label']);
                    $colour_value = sanitize_hex_color($colour['value']);
                    $field['choices']['None'] = 'None';
                    if ($field['ui']) {
                        $field['choices'][$colour_name] = "<div style='display: flex;'><span style='background: {$colour_value}; width: 20px;
            margin-right: 0.6rem; display: block; border-radius: 50%;'></span>{$colour_name}</div>";
                    } else {
                        $field['choices'][$colour_value] = $colour_name;
                    }
                }
        endif;
        // return the field
        endif;
        return $field;
    }
}
