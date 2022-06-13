<?php

use Buildystrap\Theme;

// Enqueue scripts and styles from the Theme
add_action('wp_enqueue_scripts', [Theme::class, 'enqueue_styles']);
add_action('wp_enqueue_scripts', [Theme::class, 'enqueue_scripts']);

// Build template hierarchy for Blade Views loading via: Theme::get_template_hierarchy()
add_filters([
    'index_template_hierarchy',
    '404_template_hierarchy',
    'archive_template_hierarchy',
    'author_template_hierarchy',
    'category_template_hierarchy',
    'tag_template_hierarchy',
    'taxonomy_template_hierarchy',
    'date_template_hierarchy',
    'home_template_hierarchy',
    'frontpage_template_hierarchy',
    'page_template_hierarchy',
    'paged_template_hierarchy',
    'search_template_hierarchy',
    'single_template_hierarchy',
    'singular_template_hierarchy',
    'attachment_template_hierarchy',
    'privacypolicy_template_hierarchy',
    'embed_template_hierarchy',
], [Theme::class, 'filter_template_hierarchy'], 100);

// Clear optimizations when theme has been switched.
add_actions([
    'switch_theme',
    'after_switch_theme',
    'admin_action_do-theme-upgrade',
    'upgrader_process_complete',
], [Theme::class, 'clear_on_update']);
