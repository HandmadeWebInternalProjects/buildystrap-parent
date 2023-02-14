<?php

namespace Buildystrap;

class ThemeOptions
{
  public function __construct()
  {
    if (function_exists('get_field')) {
      add_action('acf/save_post', [$this, 'save_theme_css_settings'], 20);
    }
  }

  public function save_theme_css_settings()
  {
    if (!is_admin()) return null;
    $screen = get_current_screen();
    if (Str::contains($screen->id, ['site-options', 'buildystrap-settings'])) {
      $template_dir = get_template_directory();
      $current_theme_dir = get_stylesheet_directory();

      ob_start(); // Capture all output into buffer
      require $template_dir . '/src/generate-theme-options-css.php'; // Grab the custom style php file
      $theme_css = ob_get_clean(); // Store output in a variable, then flush the buffer

      ob_start(); // Capture all output into buffer
      require $template_dir . '/src/generate-theme-options-admin-css.php'; // Grab the custom style php file
      $admin_css = ob_get_clean(); // Store output in a variable, then flush the buffer

      file_put_contents($current_theme_dir . '/public/hmw-theme-options.css', $theme_css); // Save it as a css file
      file_put_contents($current_theme_dir . '/public/hmw-theme-admin-options.css', $admin_css); // Save it as a css file
    }
  }

  public static function generateStructureVars()
  {
    if (!function_exists('get_field')) {
      return;
    }
    echo sprintf('--bs-default-grid-system: %s;', get_field('buildystrap_structure_default_grid_system', 'option'));
    echo sprintf('--bs-col-gap: %s;', get_field('buildystrap_structure_column_gap', 'option'));
    // echo sprintf('--bs-gutter: %s;', get_field('buildystrap_structure_column_gap', 'option'));
    // echo sprintf('--bs-gap: %s;', get_field('buildystrap_structure_column_gap', 'option'));
    echo sprintf('--bs-row-gap: %s;', get_field('buildystrap_structure_row_gap', 'option'));
    echo sprintf('--bs-module-gap: %s;', get_field('buildystrap_structure_module_gap', 'option'));
    echo sprintf('--bs-section-padding: %s;', get_field('buildystrap_structure_section_padding', 'option'));
    echo sprintf('--bs-row-padding: %s;', get_field('buildystrap_structure_row_padding', 'option'));
  }

  public static function generateColorVars()
  {
    if (!function_exists('get_field')) {
      return;
    }
    // check if the repeater field has rows of data
    if (function_exists('get_theme_colors')) :
      $colors = get_theme_colors();
      if (isset($colors)) :
        // loop through the rows of data
        foreach ($colors as $color) :
          if (!$color['value']) {
            echo sprintf('--bs-%1$s: %1$s;', sanitize_text_field($color['label']));
            continue;
          }
          $rgb = hex2rgb(sanitize_hex_color($color['value']));
          echo sprintf('--bs-%s: %s;', sanitize_text_field($color['label']), sanitize_hex_color($color['value']));
          echo sprintf('--bs-hover-%s: %s;', sanitize_text_field($color['label']), color_luminance(sanitize_hex_color($color['value']), -0.1));
          echo sprintf('--bs-%s-rgb: %s;', sanitize_text_field($color['label']), $rgb);
        endforeach;
      endif;
    endif;

    $colour_text_link = get_field('buildystrap_theme_colours_link_colour', 'option');
    if ($colour_text_link && $colour_text_link !== 'None') :
      echo sprintf('--bs-link-color: var(--bs-%s);', $colour_text_link);
      echo sprintf('--bs-link-color-rgb: var(--bs-%s-rgb);', $colour_text_link);
    else :
      echo sprintf('--bs-link-color: var(--bs-black);');
      echo sprintf('--bs-link-color-rgb: var(--bs-black-rgb);');

    endif;


    $colour_text_body = get_field('buildystrap_theme_colours_text_colour_body', 'option');

    if (isset($colour_text_body['label']) && $colour_text_body['label'] !== 'None') :
      echo sprintf('--color-text-body: var(--bs-%s);', $colour_text_body['label']);
    else :
      echo sprintf('--color-text-body: var(--bs-black);');
    endif;


    $colour_text_headings = get_field('buildystrap_theme_colours_text_colour_headings', 'option');

    if (isset($colour_text_headings['label']) && $colour_text_headings['label'] !== 'None') :
      echo sprintf('--color-text-headings: var(--bs-%s);', $colour_text_headings['label']);
    else :
      echo sprintf('--color-text-headings: var(--bs-black);');
    endif;
  }

  public static function generateTypographyVars()
  {
    if (!function_exists('get_field')) {
      return;
    }
    $font_main = get_field('buildystrap_typography_body_font', 'option');
    $font_headings = get_field('buildystrap_typography_heading_font', 'option');
    $font_buttons = get_field('buildystrap_typography_font_buttons', 'option');

    if (isset($font_main) && $font_main['value']) :
      echo sprintf('--font-main: %s;', $font_main['value']);
    endif;

    if (isset($font_headings) && $font_headings['value']) :
      echo sprintf('--font-headings: "%s";', $font_headings['value']);
    endif;

    if (isset($font_buttons)) :
      echo sprintf('--font-buttons: %s;', $font_buttons['value']);
    endif;

    // check if the repeater field has rows of data
    if (have_rows('buildystrap_typography_additional_fonts', 'option')) :

      // loop through the rows of data
      while (have_rows('buildystrap_typography_additional_fonts', 'option')) : the_row();

        $fontFamily = get_sub_field('value');
        echo sprintf('--font-%s: %s;', get_sub_field('label'), $fontFamily);

      endwhile;
    endif;
  }

  public static function generateColorUtils()
  {
    if (!function_exists('get_field') && !function_exists('get_theme_colors')) {
      return;
    }
    $colors = get_theme_colors();

    if (isset($colors)) :

      // loop through the rows of data
      foreach ($colors as $color) :
        $colorName = sanitize_text_field($color['label']);

        echo sprintf('.border-%1$s { border-color: var(--bs-%1$s) !important; }', $colorName);
        echo sprintf('.bg-%1$s, .bg-%1$s:hover { background-color: var(--bs-%1$s) !important; }', $colorName);
        echo sprintf('.text-%1$s, .text-%1$s:visited, .text-%1$s:hover { color: var(--bs-%1$s) !important; }', $colorName);

        /* Buttons */

        echo "#app .btn.btn-{$colorName}, .btn.btn-{$colorName}, #app .button.button-{$colorName}, .button.button-{$colorName} {
              --bs-btn-color: var(--bs-white);
              --bs-btn-bg: var(--bs-$colorName);
              --bs-btn-hover-bg: var(--bs-hover-$colorName);
              --bs-btn-border-color: var(--bs-btn-bg);
              --bs-btn-hover-border-color: var(--bs-btn-bg);
              --bs-btn-active-color: var(--bs-white);
              --bs-btn-active-bg: var(--bs-btn-bg);
              --bs-btn-active-border-color: var(--bs-btn-bg);
              --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
              --bs-btn-focus-shadow-rgb: var(--bs-$colorName-rgb);
              --bs-btn-disabled-bg: #d5d5d5;
              --bs-btn-disabled-border-color: #d5d5d5;
              }";

        echo "#app .btn.btn-outline-{$colorName}, .btn.btn-outline-{$colorName} {
              --bs-btn-color: var(--bs-white);
              --bs-btn-bg: transparent;
              --bs-btn-hover-bg: var(--bs-$colorName);
              --bs-btn-border-color: var(--bs-$colorName);
              --bs-btn-hover-border-color: var(--bs-$colorName);
              --bs-btn-active-color: var(--bs-white);
              --bs-btn-active-bg: var(--bs-$colorName);
              --bs-btn-active-border-color: var(--bs-$colorName);
              --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
              --bs-btn-focus-shadow-rgb: var(--bs-$colorName-rgb);
              --bs-btn-disabled-bg: #d5d5d5;
              --bs-btn-disabled-border-color: #d5d5d5;
              }";

      endforeach;
    endif;

    sprintf('.text-link { color: var(--bs-link-color) !important; }');
  }
}
