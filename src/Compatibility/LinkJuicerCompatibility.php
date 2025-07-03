<?php

namespace Buildystrap\Compatibility;

class LinkJuicerCompatibility extends BaseCompatibility
{
    public static function shouldLoad(): bool
    {
        return class_exists('ILJ\Helper\LinkBuilding');
    }

    public static function getPluginName(): string
    {
        return 'Internal Link Juicer';
    }

    public static function getMinimumVersion(): ?string
    {
        return '1.0.0'; // Set your minimum required version
    }

    public static function init(): void
    {
        $config = \Buildystrap\Compatibility\CompatibilityManager::getPluginConfig('link_juicer');
        $priority = $config['priority'] ?? 99;
        $hooks = $config['hooks'] ?? ['the_buildystrap_content'];

        // Apply LinkJuicer processing to specified hooks
        foreach ($hooks as $hook) {
            add_filter($hook, [static::class, 'processContent'], $priority, 1);
        }

        // Optional: Add compatibility info to admin (only if not in config or explicitly enabled)
        if (is_admin() && (!isset($config['show_admin_notice']) || $config['show_admin_notice'])) {
            static::addAdminNotice(
                sprintf('Integration with %s is active.', static::getPluginName()),
                'success'
            );
        }
    }

    /**
     * Process content through LinkJuicer
     */
    public static function processContent(string $content): string
    {
        try {
            if (class_exists('ILJ\Helper\LinkBuilding')) {
                $linkBuilder = new \ILJ\Helper\LinkBuilding();
                return $linkBuilder->linkContent($content);
            }
        } catch (\Exception $e) {
            static::logCompatibilityIssue('Failed to process content: ' . $e->getMessage());
        }

        return $content;
    }
}
