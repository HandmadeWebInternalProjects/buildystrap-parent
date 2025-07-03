<?php

namespace Buildystrap\Compatibility;

class YoastSEOCompatibility extends BaseCompatibility
{
    public static function shouldLoad(): bool
    {
        return defined('WPSEO_VERSION');
    }

    public static function getPluginName(): string
    {
        return 'Yoast SEO';
    }

    public static function getMinimumVersion(): ?string
    {
        return '15.0.0';
    }

    public static function init(): void
    {
        $config = CompatibilityManager::getPluginConfig('yoast_seo');
        
        // Add meta description support for builder pages
        if ($config['meta_description_support'] ?? true) {
            add_filter('wpseo_metadesc', [static::class, 'enhanceMetaDescription'], 10, 2);
        }
        
        // Add structured data support
        if ($config['structured_data'] ?? true) {
            add_filter('wpseo_schema_graph', [static::class, 'enhanceSchemaGraph'], 10, 2);
        }

        // Add OpenGraph support for builder content
        if ($config['opengraph_support'] ?? true) {
            add_filter('wpseo_opengraph_desc', [static::class, 'enhanceOpenGraphDescription'], 10, 2);
        }
    }

    public static function enhanceMetaDescription(string $metadesc, \WP_Post $post): string
    {
        // Extract text content from builder modules for meta description
        if (function_exists('get_post_meta')) {
            $builderContent = get_post_meta($post->ID, '_buildystrap_content', true);
            if ($builderContent && empty($metadesc)) {
                // Extract first paragraph of text from builder content
                $textContent = static::extractTextFromBuilderContent($builderContent);
                if ($textContent) {
                    return wp_trim_words($textContent, 25);
                }
            }
        }
        
        return $metadesc;
    }

    public static function enhanceSchemaGraph(array $graph, \WP_Post $post): array
    {
        // Add structured data based on builder modules
        // This is a simplified example - you'd implement based on your specific needs
        return $graph;
    }

    public static function enhanceOpenGraphDescription(string $description, \WP_Post $post): string
    {
        // Similar to meta description enhancement
        return $description;
    }

    private static function extractTextFromBuilderContent(string $content): string
    {
        // Simple text extraction - you'd implement based on your builder structure
        $decoded = json_decode($content, true);
        if (is_array($decoded)) {
            // Extract text from your builder modules
            // This is a placeholder - implement based on your builder data structure
            return '';
        }
        
        return '';
    }
}
