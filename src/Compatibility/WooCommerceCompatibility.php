<?php

namespace Buildystrap\Compatibility;

class WooCommerceCompatibility extends BaseCompatibility
{
    public static function shouldLoad(): bool
    {
        return class_exists('WooCommerce');
    }

    public static function getPluginName(): string
    {
        return 'WooCommerce';
    }

    public static function getMinimumVersion(): ?string
    {
        return '5.0.0';
    }

    public static function init(): void
    {
        $config = CompatibilityManager::getPluginConfig('woocommerce');
        
        // Add WooCommerce-specific hooks for page builder
        add_action('buildystrap_before_content', [static::class, 'beforeContent']);
        add_action('buildystrap_after_content', [static::class, 'afterContent']);

        // Ensure WooCommerce assets are loaded on builder pages (if enabled in config)
        if ($config['load_assets'] ?? true) {
            add_action('wp_enqueue_scripts', [static::class, 'enqueueAssets']);
        }

        // Add WooCommerce shortcodes to safe list (if enabled in config)
        if ($config['safe_shortcodes'] ?? true) {
            add_filter('buildystrap_safe_shortcodes', [static::class, 'addSafeShortcodes']);
        }

        // Enqueue assets specifically on builder pages (if enabled in config)
        if ($config['enqueue_on_builder_pages'] ?? true) {
            add_action('wp_enqueue_scripts', [static::class, 'enqueueBuilderPageAssets']);
        }
    }

    public static function beforeContent(): void
    {
        if (function_exists('is_shop')) {
            // Add any necessary WooCommerce context
        }
    }

    public static function afterContent(): void
    {
        // Clean up if needed
    }

    public static function enqueueAssets(): void
    {
        if (function_exists('is_woocommerce')) {
            // Ensure WooCommerce styles are loaded
            wp_enqueue_style('woocommerce-general');
            wp_enqueue_style('woocommerce-layout');
            wp_enqueue_style('woocommerce-smallscreen');
        }
    }

    /**
     * Enqueue assets specifically for builder pages with WooCommerce content
     */
    public static function enqueueBuilderPageAssets(): void
    {
        // Check if this is a page using the builder and contains WooCommerce content
        if (static::pageContainsWooCommerceContent()) {
            wp_enqueue_style('woocommerce-general');
            wp_enqueue_style('woocommerce-layout');
            wp_enqueue_style('woocommerce-smallscreen');
            wp_enqueue_script('woocommerce');
        }
    }

    /**
     * Check if page contains WooCommerce content
     */
    private static function pageContainsWooCommerceContent(): bool
    {
        global $post;
        
        if (!$post) {
            return false;
        }
        
        // Check if post content contains WooCommerce shortcodes
        $woocommerceShortcodes = [
            'product', 'products', 'product_category', 'product_categories',
            'sale_products', 'best_selling_products', 'top_rated_products',
            'featured_products', 'recent_products', 'product_attribute'
        ];
        
        foreach ($woocommerceShortcodes as $shortcode) {
            if (has_shortcode($post->post_content, $shortcode)) {
                return true;
            }
        }
        
        // Check builder content for WooCommerce modules
        $builderContent = get_post_meta($post->ID, '_buildystrap_content', true);
        if ($builderContent && str_contains($builderContent, 'woocommerce')) {
            return true;
        }
        
        return false;
    }

    public static function addSafeShortcodes(array $shortcodes): array
    {
        return array_merge($shortcodes, [
            'product',
            'product_category',
            'product_categories',
            'products',
            'sale_products',
            'best_selling_products',
            'top_rated_products',
            'featured_products',
            'recent_products',
            'product_attribute',
            'woocommerce_cart',
            'woocommerce_checkout',
            'woocommerce_my_account',
            'woocommerce_order_tracking',
        ]);
    }
}
