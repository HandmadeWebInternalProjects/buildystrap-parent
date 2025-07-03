<?php

namespace Buildystrap\Compatibility;

class CompatibilityManager
{
    /**
     * List of available compatibility classes
     */
    private static array $compatibilityClasses = [
        LinkJuicerCompatibility::class,
        WooCommerceCompatibility::class,
        GravityFormsCompatibility::class,
        // Add more compatibility classes here
    ];

    /**
     * Configuration cache
     */
    private static ?array $config = null;

    /**
     * Initialize all compatibility layers
     */
    public static function init(): void
    {
        $config = static::getConfig();

        // Early exit if compatibility is disabled
        if (!$config['enabled']) {
            return;
        }

        // Load built-in compatibility classes
        foreach (static::$compatibilityClasses as $compatibilityClass) {
            if (class_exists($compatibilityClass) && static::isCompatibilityEnabled($compatibilityClass)) {
                $compatibilityClass::boot();
            }
        }

        // Load custom compatibility classes from config
        foreach ($config['custom_classes'] as $customClass) {
            if (class_exists($customClass) && static::isCompatibilityEnabled($customClass)) {
                $customClass::boot();
            }
        }

        // Hook for third-party developers to register their own compatibility
        do_action('buildystrap_compatibility_init', static::class);
    }

    /**
     * Get configuration from config file
     */
    private static function getConfig(): array
    {
        if (static::$config === null) {
            $configPath = get_template_directory() . '/config/compatibility.php';
            
            if (file_exists($configPath)) {
                static::$config = require $configPath;
            } else {
                // Default configuration if file doesn't exist
                static::$config = [
                    'enabled' => true,
                    'plugins' => [],
                    'custom_classes' => [],
                    'safe_shortcodes' => [],
                ];
            }
        }

        return static::$config;
    }

    /**
     * Check if a specific compatibility class should be loaded
     */
    private static function isCompatibilityEnabled(string $compatibilityClass): bool
    {
        if (!class_exists($compatibilityClass)) {
            return false;
        }

        $config = static::getConfig();
        $pluginKey = static::getPluginKeyFromClass($compatibilityClass);

        // If no specific config for this plugin, default to enabled if plugin is available
        if (!isset($config['plugins'][$pluginKey])) {
            return $compatibilityClass::shouldLoad();
        }

        // Check if specifically enabled in config
        return $config['plugins'][$pluginKey]['enabled'] ?? true;
    }

    /**
     * Get plugin key from class name
     */
    private static function getPluginKeyFromClass(string $className): string
    {
        $map = [
            LinkJuicerCompatibility::class => 'link_juicer',
            WooCommerceCompatibility::class => 'woocommerce',
            GravityFormsCompatibility::class => 'gravity_forms',
        ];

        return $map[$className] ?? strtolower(str_replace('Compatibility', '', class_basename($className)));
    }

    /**
     * Register a new compatibility class
     */
    public static function register(string $compatibilityClass): void
    {
        if (!in_array($compatibilityClass, static::$compatibilityClasses)) {
            static::$compatibilityClasses[] = $compatibilityClass;
        }
    }

    /**
     * Get list of active compatibility integrations
     */
    public static function getActiveCompatibilities(): array
    {
        $active = [];

        foreach (static::$compatibilityClasses as $compatibilityClass) {
            if (class_exists($compatibilityClass) && $compatibilityClass::shouldLoad()) {
                $active[] = $compatibilityClass::getPluginName();
            }
        }

        return $active;
    }

    /**
     * Check if a specific plugin compatibility is active
     */
    public static function isCompatibilityActive(string $pluginName): bool
    {
        return in_array($pluginName, static::getActiveCompatibilities());
    }

    /**
     * Get configuration for a specific plugin
     */
    public static function getPluginConfig(string $pluginKey): array
    {
        $config = static::getConfig();
        return $config['plugins'][$pluginKey] ?? [];
    }

    /**
     * Get safe shortcodes from configuration
     */
    public static function getSafeShortcodes(): array
    {
        $config = static::getConfig();
        return $config['safe_shortcodes'] ?? [];
    }

    /**
     * Check if a shortcode is safe to use
     */
    public static function isShortcodeSafe(string $shortcode): bool
    {
        return in_array($shortcode, static::getSafeShortcodes());
    }

    /**
     * Add safe shortcodes dynamically
     */
    public static function addSafeShortcodes(array $shortcodes): void
    {
        $config = static::getConfig();
        $config['safe_shortcodes'] = array_merge($config['safe_shortcodes'], $shortcodes);
        static::$config = $config;
    }
}
