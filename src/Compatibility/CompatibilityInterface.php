<?php

namespace Buildystrap\Compatibility;

interface CompatibilityInterface
{
    /**
     * Check if the plugin is active and should be loaded
     */
    public static function shouldLoad(): bool;

    /**
     * Initialize the compatibility layer
     */
    public static function init(): void;

    /**
     * Get the plugin name for reference
     */
    public static function getPluginName(): string;

    /**
     * Get the minimum required version (optional)
     */
    public static function getMinimumVersion(): ?string;
}
