<?php
/**
 * Understrap enqueue scripts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if ( ! function_exists('understrap_scripts')) {
    /**
     * Load theme's JavaScript and CSS sources.
     */
    function understrap_scripts()
    {
        wp_enqueue_script('jquery');

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
} // End of if function_exists( 'understrap_scripts' ).

add_action('wp_enqueue_scripts', 'understrap_scripts');
