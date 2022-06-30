<?php

namespace Buildystrap;

use function add_meta_box;
use function delete_post_meta;
use function update_post_meta;

class BuilderMetaBox
{
    public static function boot()
    {
        add_action('add_meta_boxes', [static::class, 'add_metabox']);
        add_action('save_post', [static::class, 'save_metabox']);
    }

    public static function add_metabox(): void
    {
        foreach (Builder::enabledTypes() as $postType) {
            add_meta_box('buildy_metabox', 'Buildy', [static::class, 'display_metabox'], $postType, 'side', 'high');
        }
    }

    public static function display_metabox($post): void
    {
        echo view('metabox.template', [
            'enabled' => (bool) get_post_meta($post->ID, '_buildy_enabled', true),
        ])->render();
    }

    public static function save_metabox($post_id): void
    {
        if (isset($_POST['_buildy_enabled'])) {
            update_post_meta($post_id, '_buildy_enabled', true);
        } else {
            delete_post_meta($post_id, '_buildy_enabled');
        }
    }
}
