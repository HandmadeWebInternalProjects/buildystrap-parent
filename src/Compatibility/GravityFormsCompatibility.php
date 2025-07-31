<?php

namespace Buildystrap\Compatibility;

class GravityFormsCompatibility extends BaseCompatibility
{
    public static function shouldLoad(): bool
    {
        return class_exists('GFForms');
    }

    public static function getPluginName(): string
    {
        return 'Gravity Forms';
    }

    public static function getMinimumVersion(): ?string
    {
        return '2.5.0';
    }

    public static function init(): void
    {
        $config = CompatibilityManager::getPluginConfig('gravity_forms');

        // Ensure Gravity Forms scripts are loaded when forms are present in builder
        if ($config['auto_enqueue'] ?? true) {
            add_action('wp_enqueue_scripts', [static::class, 'enqueueAssets']);
        }

        // Add Gravity Forms shortcodes to safe list
        if ($config['safe_shortcodes'] ?? true) {
            add_filter('buildystrap_safe_shortcodes', [static::class, 'addSafeShortcodes']);
        }

        // Hook into form rendering for builder content
        add_filter('gform_pre_render', [static::class, 'preRenderForm']);

        // Preload scripts if enabled in config
        if ($config['preload_scripts'] ?? false) {
            add_action('wp_head', [static::class, 'preloadScripts']);
        }
    }

    public static function enqueueAssets(): void
    {
        // Check if page contains Gravity Forms via builder content
        if (static::pageContainsGravityForms()) {
            if (class_exists('GFForms')) {
                \GFForms::enqueue_scripts();
            }
        }
    }

    public static function addSafeShortcodes(array $shortcodes): array
    {
        return array_merge($shortcodes, [
            'gravityform',
            'gravityforms',
        ]);
    }

    public static function preRenderForm(array $form): array
    {
        // Add any necessary modifications to forms when rendered in builder
        return $form;
    }

    /**
     * Preload Gravity Forms scripts for better performance
     */
    public static function preloadScripts(): void
    {
        if (static::pageContainsGravityForms()) {
            echo '<link rel="preload" href="' . esc_url(GFCommon::get_base_url() . '/js/gravityforms.min.js') . '" as="script">';
            echo '<link rel="preload" href="' . esc_url(GFCommon::get_base_url() . '/css/formsmain.min.css') . '" as="style">';
        }
    }

    /**
     * Enhanced form detection including builder content
     */
    private static function pageContainsGravityForms(): bool
    {
        global $post;

        if (!$post) {
            return false;
        }

        // Check if post content contains gravity form shortcodes
        if (has_shortcode($post->post_content, 'gravityform') ||
            has_shortcode($post->post_content, 'gravityforms')) {
            return true;
        }

        // Check builder content for Gravity Forms modules
        $builderContent = get_post_meta($post->ID, '_buildystrap_content', true);
        if ($builderContent && (
            str_contains($builderContent, 'gravity-forms-module') ||
            str_contains($builderContent, 'gravityform')
        )) {
            return true;
        }

        return false;
    }
}
