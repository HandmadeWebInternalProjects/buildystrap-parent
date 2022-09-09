<?php

namespace Buildystrap;

use WP_Post;

use function add_action;
use function add_meta_box;
use function in_array;
use function update_post_meta;

class BuilderMetaBox
{
    public static function boot()
    {
        add_action('add_meta_boxes', [static::class, 'add_metabox'], 10, 2);
        add_action('save_post', [static::class, 'save_metabox'], 10, 3);
    }

    public static function add_metabox(string $post_type, WP_Post $post): void
    {
        foreach (Builder::enabledTypes() as $postType) {
            add_meta_box('buildy_metabox', 'Buildy', [static::class, 'display_metabox'], $postType, 'side', 'high');
        }
    }

    public static function display_metabox(WP_Post $post): void
    {
        echo view('wp-admin.metabox', [
            'enabled' => (bool) get_post_meta($post->ID, '_buildy_enabled', true),
        ])->render();
    }

    public static function save_metabox(int $post_id, WP_Post $post, bool $update): void
    {
        if ( ! in_array($post->post_type, Builder::enabledTypes())) {
            return;
        }

        if (isset($_POST['_buildy_enabled'])) {
            update_post_meta($post_id, '_buildy_enabled', $_POST['_buildy_enabled']);
        }
    }
}
