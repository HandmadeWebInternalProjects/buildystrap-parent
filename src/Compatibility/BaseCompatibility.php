<?php

namespace Buildystrap\Compatibility;

abstract class BaseCompatibility implements CompatibilityInterface
{
    /**
     * Common initialization logic
     */
    public static function boot(): void
    {
        if (static::shouldLoad()) {
            static::init();
        }
    }

    /**
     * Default minimum version check
     */
    public static function getMinimumVersion(): ?string
    {
        return null;
    }

    /**
     * Check if plugin meets minimum version requirement
     */
    protected static function checkMinimumVersion(string $currentVersion): bool
    {
        $minimumVersion = static::getMinimumVersion();

        if (!$minimumVersion) {
            return true;
        }

        return version_compare($currentVersion, $minimumVersion, '>=');
    }

    /**
     * Log compatibility issues
     */
    protected static function logCompatibilityIssue(string $message): void
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf('[Buildystrap Compatibility] %s: %s', static::getPluginName(), $message));
        }
    }

    /**
     * Add admin notice for compatibility issues
     */
    protected static function addAdminNotice(string $message, string $type = 'warning'): void
    {
        add_action('admin_notices', function () use ($message, $type) {
            printf(
                '<div class="notice notice-%s"><p><strong>Buildystrap Compatibility:</strong> %s</p></div>',
                esc_attr($type),
                esc_html($message)
            );
        });
    }
}
