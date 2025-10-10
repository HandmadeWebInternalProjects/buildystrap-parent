<?php

namespace Buildystrap;

class GenerateRenderModulePage
{
    public array $sub_pages = [
      'render-module-previews' => 'Render Module Previews',
    ];

    public function __construct()
    {
        add_filter('rewrite_rules_array', [$this, 'render_module_previews_rewrite_rules']);
        add_filter('query_vars', [$this, 'render_module_preview_query_vars']);
        remove_filter('wp_head', 'rel_canonical');
        // add_filter('wp_head', [$this, 'render_module_preview_rel_canonical']);
        add_filter('wpseo_canonical', [$this, 'render_module_preview_seo_canonical_exclude']);
        add_filter('wp_title', [$this, 'render_module_preview_titletag'], 11, 3);
        add_action('template_redirect', [$this, 'render_module_previews_template']);
        add_action('wp_head', [$this, 'add_noindex_meta_tag']);
    }

    public function render_module_previews_rewrite_rules(array $rules): array
    {
        $newrules = [];
        $newrules['^builder/render-module-previews'] = 'index.php?my_custom_page=render-module-previews';

        return array_merge($newrules, $rules);
    }

    public function render_module_preview_query_vars(array $vars): array
    {
        $vars[] = 'my_custom_page';

        return $vars;
    }

    public function render_module_preview_rel_canonical(): void
    {
        global $current_sp, $wp_the_query;

        if (!is_singular()) {
            return;
        }

        if (!$id = $wp_the_query->get_queried_object_id()) {
            return;
        }

        $link = trailingslashit(get_permalink($id));

        if (!empty($current_sp)) {
            $link .= user_trailingslashit($current_sp);
        }

        echo '<link rel="canonical" href="' . $link . '" />';
    }

    public function render_module_preview_seo_canonical_exclude($canonical): mixed
    {
        global $post;

        if (is_singular('render_module_previews')) {
            $canonical = false;
        }

        return $canonical;
    }

    protected function render_module_preview_titletag($orig_title): mixed
    {
        global $wp_the_query;
        $current_fp = get_query_var('fpage');

        if (!$current_fp) {
            $title = $orig_title;
        } elseif ($current_fp == 'render-module-previews') {
            $title = $this->sub_pages['render-module-previews'];
        }

        return $title ?? null;
    }

    public function render_module_previews_template(): void
    {
        if (!current_user_can('edit_posts')) {
            return;
        }

        if (get_query_var('my_custom_page') === 'render-module-previews') {
            echo view('render-module-previews')->render();
            exit;
        }
    }

    public function add_noindex_meta_tag(): void
    {
        if (get_query_var('my_custom_page') === 'render-module-previews') {
            echo '<meta name="robots" content="noindex, nofollow">';
        }
    }
}
