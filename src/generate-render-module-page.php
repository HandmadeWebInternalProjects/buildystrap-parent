<?php
/*
*  Creates fake sub pages for a custom post type.
*/

class CreateRenderModulePage
{
    public $sub_pages = [
    'render-module-previews' => 'Render Module Previews',
  ];

    public function __construct()
    {
        // add_action('init', 'edit_members_rewrite_rules');
        add_filter('rewrite_rules_array', [$this, 'render_module_previews_rewrite_rules']);
        add_filter('query_vars', [$this, 'render_module_preview_query_vars']);

        // Remove WordPress's default canonical handling function
        remove_filter('wp_head', 'rel_canonical');
        add_filter('wp_head', [$this, 'render_module_preview_rel_canonical']);

        add_filter('wpseo_canonical', [$this, 'render_module_preview_seo_canonical_exclude']);

        // // Modify page titles
        add_filter('wp_title', [$this, 'render_module_preview_titletag'], 11, 3);
    }


    // Adding fake sub-pages' rewrite rules
    public function render_module_previews_rewrite_rules($rules)
    {
        $newrules = [];
        $newrules['^builder/render-module-previews'] = 'index.php?my_custom_page=render-module-previews';
        return $newrules + $rules;
    }

    // Adding fake sub-pages' rewrite rules
    public function render_module_previews_rewrite_rules($rules)
    {
        $newrules = [];
        $newrules['^builder/render-module-previews'] = 'index.php?my_custom_page=render-module-previews';
        return $newrules + $rules;
    }

    // Tell WordPress to accept our custom query variable
    public function render_module_preview_query_vars($vars)
    {
        array_push($vars, 'my_custom_page');
        return $vars;
    }

    public function render_module_preview_rel_canonical()
    {
        global $current_sp, $wp_the_query;

        if ( ! is_singular()) {
            return;
        }

        if ( ! $id = $wp_the_query->get_queried_object_id()) {
            return;
        }

        $link = trailingslashit(get_permalink($id));

        // Make sure sub-pages' permalinks are canonical
        if ( ! empty($current_sp)) {
            $link .= user_trailingslashit($current_sp);
        }

        echo '<link rel="canonical" href="' . $link . '" />';
    }

    // If using Yoast - remove the canonical link from your custom post type as we set proper canonical tags above.
    public function render_module_preview_seo_canonical_exclude($canonical)
    {
        global $post;
        if (is_singular('render_module_previews')) {
            $canonical = false;
        }
        return $canonical;
    }


    private function render_module_preview_titletag($orig_title)
    {
        global $wp_the_query;
        $current_fp = get_query_var('fpage');

        if ( ! $current_fp) {
            // If this is not a new page, use the existing title
            $title = $orig_title;
        } elseif ($current_fp == 'render-module-previews') {
            $title = $this->sub_pages['render-module-previews'];
        }
        return $title;
    }
}
