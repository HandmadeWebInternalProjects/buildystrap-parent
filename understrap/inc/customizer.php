<?php
/**
 * Understrap Theme Customizer
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists('understrap_customize_register')) {
    /**
     * Register basic customizer support.
     *
     * @param object $wp_customize Customizer reference.
     */
    function understrap_customize_register($wp_customize)
    {
        $wp_customize->get_setting('blogname')->transport         = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
    }
}
add_action('customize_register', 'understrap_customize_register');

if ( ! function_exists('understrap_theme_customize_register')) {
    /**
     * Register individual settings through customizer's API.
     *
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function understrap_theme_customize_register($wp_customize)
    {

        // Theme layout settings.
        $wp_customize->add_section(
            'understrap_theme_layout_options',
            [
                'title'       => __('Theme Layout Settings', 'buildystrap'),
                'capability'  => 'edit_theme_options',
                'description' => __('Container width and sidebar defaults', 'buildystrap'),
                'priority'    => apply_filters('understrap_theme_layout_options_priority', 160),
            ]
        );

        /**
         * Select sanitization function
         *
         * @param string               $input   Slug to sanitize.
         * @param WP_Customize_Setting $setting Setting instance.
         * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
         */
        function understrap_theme_slug_sanitize_select($input, $setting)
        {

            // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
            $input = sanitize_key($input);

            // Get the list of possible select options.
            $choices = $setting->manager->get_control($setting->id)->choices;

            // If the input is a valid key, return it; otherwise, return the default.
            return (array_key_exists($input, $choices) ? $input : $setting->default);
        }

        $wp_customize->add_setting(
            'understrap_container_type',
            [
                'default'           => 'container',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
                'capability'        => 'edit_theme_options',
            ]
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'understrap_container_type',
                [
                    'label'       => __('Container Width', 'buildystrap'),
                    'description' => __('Choose between Bootstrap\'s container and container-fluid', 'buildystrap'),
                    'section'     => 'understrap_theme_layout_options',
                    'settings'    => 'understrap_container_type',
                    'type'        => 'select',
                    'choices'     => [
                        'container'       => __('Fixed width container', 'buildystrap'),
                        'container-fluid' => __('Full width container', 'buildystrap'),
                    ],
                    'priority'    => apply_filters('understrap_container_type_priority', 10),
                ]
            )
        );

        $wp_customize->add_setting(
            'understrap_navbar_type',
            [
                'default'           => 'collapse',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
                'capability'        => 'edit_theme_options',
            ]
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'understrap_navbar_type',
                [
                    'label'             => __('Responsive Navigation Type', 'buildystrap'),
                    'description'       => __(
                        'Choose between an expanding and collapsing navbar or an offcanvas drawer.',
                        'buildystrap'
                    ),
                    'section'           => 'understrap_theme_layout_options',
                    'settings'          => 'understrap_navbar_type',
                    'type'              => 'select',
                    'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
                    'choices'           => [
                        'collapse'  => __('Collapse', 'buildystrap'),
                        'offcanvas' => __('Offcanvas', 'buildystrap'),
                    ],
                    'priority'          => apply_filters('understrap_navbar_type_priority', 20),
                ]
            )
        );

        $wp_customize->add_setting(
            'understrap_sidebar_position',
            [
                'default'           => 'right',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
                'capability'        => 'edit_theme_options',
            ]
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'understrap_sidebar_position',
                [
                    'label'             => __('Sidebar Positioning', 'buildystrap'),
                    'description'       => __(
                        'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
                        'buildystrap'
                    ),
                    'section'           => 'understrap_theme_layout_options',
                    'settings'          => 'understrap_sidebar_position',
                    'type'              => 'select',
                    'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
                    'choices'           => [
                        'right' => __('Right sidebar', 'buildystrap'),
                        'left'  => __('Left sidebar', 'buildystrap'),
                        'both'  => __('Left & Right sidebars', 'buildystrap'),
                        'none'  => __('No sidebar', 'buildystrap'),
                    ],
                    'priority'          => apply_filters('understrap_sidebar_position_priority', 20),
                ]
            )
        );

        $wp_customize->add_setting(
            'understrap_site_info_override',
            [
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'wp_kses_post',
                'capability'        => 'edit_theme_options',
            ]
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'understrap_site_info_override',
                [
                    'label'       => __('Footer Site Info', 'buildystrap'),
                    'description' => __('Override Understrap\'s site info located at the footer of the page.', 'buildystrap'),
                    'section'     => 'understrap_theme_layout_options',
                    'settings'    => 'understrap_site_info_override',
                    'type'        => 'textarea',
                    'priority'    => 20,
                ]
            )
        );
    }
} // End of if function_exists( 'understrap_theme_customize_register' ).
add_action('customize_register', 'understrap_theme_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists('understrap_customize_preview_js')) {
    /**
     * Setup JS integration for live previewing.
     */
    function understrap_customize_preview_js()
    {
        wp_enqueue_script(
            'understrap_customizer',
            get_template_directory_uri() . '/js/customizer.js',
            [ 'customize-preview' ],
            '20130508',
            true
        );
    }
}
add_action('customize_preview_init', 'understrap_customize_preview_js');

if ( ! function_exists('understrap_default_navbar_type')) {
    /**
     * Overrides the responsive navbar type for Bootstrap 4
     *
     * @param string $current_mod
     * @return string
     */
    function understrap_default_navbar_type($current_mod)
    {
        return $current_mod;
    }
}
add_filter('theme_mod_understrap_navbar_type', 'understrap_default_navbar_type', 20);
