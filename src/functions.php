<?php

use Buildystrap\Builder;
use Buildystrap\BuilderApi;
use Buildystrap\BuilderBackend;
use Buildystrap\BuilderCPT;
use Buildystrap\Theme;
use Buildystrap\ThemeOptions;
use Buildystrap\Str;

BuilderCPT::boot();
include __DIR__ . '/BuilderACF.php';

add_action('init', [Builder::class, 'boot']);
add_action('init', [BuilderApi::class, 'boot']);
add_action('acf/init', [BuilderBackend::class, 'boot']);
add_action('init', [Theme::class, 'boot']);

/****************************************************************************************************************
 * Include Theme Options // used for global fields (e.g social icons)
 */

// Handle Theme Options;
new ThemeOptions();

/* Custom Logo */
function custom_logo($url = null, $svg = null)
{
  $custom_logo = acf_active() ? get_field('buildystrap_company_details_site_logo', 'option') : null;
  if (!acf_active() || empty($custom_logo)) { ?>

    <?php
    if (is_front_page() && is_home()) : ?>
      <h1 class="navbar-brand"><a rel="home" href="<?php echo esc_url(isset($url) ? $url : home_url('/')); ?>" itemprop="url"><?php bloginfo('name'); ?></a></h1>
    <?php
    else : ?>
      <a class="navbar-brand" rel="home" href="<?php echo esc_url(isset($url) ? $url : home_url('/')); ?>" itemprop="url"><?php bloginfo('name'); ?></a>
    <?php
    endif; ?>

<?php
  } else {
    echo sprintf(
      '<a class="navbar-brand" href="%s">',
      isset($url) ? $url : home_url('/')
    );

    if (isset($svg) && $svg) {
      echo get_svg_url($custom_logo['url']);
    } else {
      echo sprintf(
        '<a class="navbar-brand" href="%s"><img class="site-logo" src="%s" alt="%s" /></a>',
        isset($url) ? $url : home_url('/'),
        $custom_logo['url'],
        $custom_logo['alt']
      );
    }

    echo '</a>';
  }
}

add_action('wp_body_open', function () {
  if (function_exists('get_field') && !is_admin() && (get_field('buildystrap_sitewide_message_enable_sitewide_message', 'option') == true) && !isset($_COOKIE["sitewide_message"])) {
    echo apply_shortcodes('[sitewide-message]');
  }
});


// Populate colour options
// Add the global colour options to all of these fields
if (!function_exists('add_site_color_choices')) {
  add_filter('acf/load_field/key=field_62eb52287454c', 'add_site_color_choices');
  add_filter('acf/load_field/key=field_62ce5cbe77fbf', 'add_site_color_choices');
  add_filter('acf/load_field/key=field_62ce5cd577fc0', 'add_site_color_choices');
  add_filter('acf/load_field/key=field_62ce5d0577fc1', 'add_site_color_choices');
  add_filter('acf/load_field/key=field_62ce556144f02', 'add_site_color_choices');
  add_filter('acf/load_field/key=field_62ce558644f03', 'add_site_color_choices');

  function add_site_color_choices($field)
  {
    $field['choices'] = [];
    if (function_exists('get_theme_colors')) :
      $colours = @get_theme_colors();
      // $colours = [["name" => "red", "value" => "sdf79sf"]];
      if (!empty($colours) && (is_array($colours) || is_object($colours))) :
        foreach ($colours as $colour) {
          $colour_name = trim($colour['label']);
          $colour_value = sanitize_hex_color($colour['value']);
          $field['choices']['None'] = 'None';
          if ($field['ui']) {
            $field['choices'][$colour_name] = "<div style='display: flex;'><span style='background: {$colour_value}; width: 20px;
            margin-right: 0.6rem; display: block; border-radius: 50%;'></span>{$colour_name}</div>";
          } else {
            $field['choices'][$colour_value] = $colour_name;
          }
        }
      endif;
    // return the field
    endif;
    return $field;
  }
}
