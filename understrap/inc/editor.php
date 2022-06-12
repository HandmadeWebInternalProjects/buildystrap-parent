<?php
/**
 * Understrap modify editor
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_filter('mce_buttons_2', 'understrap_tiny_mce_style_formats');

if (! function_exists('understrap_tiny_mce_style_formats')) {
    /**
     * Reveals TinyMCE's hidden Style dropdown.
     *
     * @param array $buttons Array of Tiny MCE's button ids.
     * @return array
     */
    function understrap_tiny_mce_style_formats($buttons)
    {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }
}

add_filter('tiny_mce_before_init', 'understrap_tiny_mce_before_init');

if (! function_exists('understrap_tiny_mce_before_init')) {
    /**
     * Adds style options to TinyMCE's Style dropdown.
     *
     * @param array $settings TinyMCE settings array.
     * @return array
     */
    function understrap_tiny_mce_before_init($settings)
    {
        $style_formats = array(
            array(
                'title'    => __('Lead Paragraph', 'buildystrap'),
                'selector' => 'p',
                'classes'  => 'lead',
                'wrapper'  => true,
            ),
            array(
                'title'  => _x('Small', 'Font size name', 'buildystrap'),
                'inline' => 'small',
            ),
            array(
                'title'   => __('Blockquote', 'buildystrap'),
                'block'   => 'blockquote',
                'classes' => 'blockquote',
                'wrapper' => true,
            ),
            array(
                'title'   => __('Blockquote Footer', 'buildystrap'),
                'block'   => 'footer',
                'classes' => 'blockquote-footer',
                'wrapper' => true,
            ),
            array(
                'title'  => __('Cite', 'buildystrap'),
                'inline' => 'cite',
            ),
        );

        if (isset($settings['style_formats'])) {
            $orig_style_formats = json_decode($settings['style_formats'], true);
            $style_formats      = array_merge($orig_style_formats, $style_formats);
        }

        $settings['style_formats'] = wp_json_encode($style_formats);
        return $settings;
    }
}

add_filter('mce_buttons', 'understrap_tiny_mce_blockquote_button');

if (! function_exists('understrap_tiny_mce_blockquote_button')) {
    /**
     * Removes the blockquote button from the TinyMCE toolbar.
     *
     * We provide the blockquote via the style formats. Using the style formats
     * blockquote receives the proper Bootstrap classes.
     *
     * @see understrap_tiny_mce_before_init()
     *
     * @param array $buttons TinyMCE buttons array.
     * @return array TinyMCE buttons array without the blockquote button.
     */
    function understrap_tiny_mce_blockquote_button($buttons)
    {
        foreach ($buttons as $key => $button) {
            if ('blockquote' === $button) {
                unset($buttons[ $key ]);
            }
        }
        return $buttons;
    }
}
