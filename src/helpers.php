<?php

use Buildystrap\BuilderBackend;
use Buildystrap\Str;

if (!function_exists('extendable_layout')) {
  function extendable_layout($post = null, string $default = 'default'): string
  {
    if ($template = get_page_template_slug($post)) {
      $template = Str::replaceLast('.php', '', $template);
      $template = Str::replace('/', '.', $template);
      $template = Str::replaceFirst('page-templates', '', $template);
    } else {
      $template = $default;
    }

    return "layouts.$template";
  }
}

if (!function_exists('add_filters')) {
  /**
   * Bind single callback to multiple filters.
   *
   * @param iterable $filters List of filters
   */
  function add_filters(iterable $filters, callable $callback, int $priority = 10, int $args = 1): void
  {
    \Roots\add_filters($filters, $callback, $priority, $args);
  }
}

if (!function_exists('add_actions')) {
  /**
   * Bind single callback to multiple actions.
   *
   * @param iterable $actions List of actions
   */
  function add_actions(iterable $actions, callable $callback, int $priority = 10, int $args = 1): void
  {
    \Roots\add_actions($actions, $callback, $priority, $args);
  }
}

if (!function_exists('get_registered_image_sizes')) {
  function get_registered_image_sizes(): array
  {
    global $_wp_additional_image_sizes;

    $default_image_sizes = ['thumbnail', 'medium', 'large'];

    foreach ($default_image_sizes as $size) {
      $image_sizes[$size]['width'] = intval(get_option("{$size}_size_w"));
      $image_sizes[$size]['height'] = intval(get_option("{$size}_size_h"));
      $image_sizes[$size]['crop'] = get_option("{$size}_crop") ? get_option("{$size}_crop") : false;
    }

    if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
      $image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
    }

    return $image_sizes;
  }
}

if (!function_exists('class_extends')) {
  function class_extends(string $class, string $parent): bool
  {
    if (!class_exists($class) || !class_exists($parent) || !is_a($class, $parent, true)) {
      return false;
    }

    return true;
  }
}

if (!function_exists('getResponsiveClasses')) {
  function getResponsiveClasses(
    object $module,
    string $prop,
    string $classPrefix,
    string $fallback,
    mixed $computed = null
  ) {
    $has_prop = $module->has($prop);
    if (!$has_prop) {
      return $fallback;
    }

    $prop = $module->get($prop);
    if (!isset($prop)) {
      return $fallback;
    }

    $class_list = [];
    foreach ($prop->value() as $breakpoint => $value) {
      $val = isset($computed) ? $computed($value) : $value;
      if (!$val) {
        continue;
      }
      $class_list[] = match ($breakpoint) {
        'xs' => "{$classPrefix}-{$val}",
        default => "{$classPrefix}-{$breakpoint}-{$val}"
      };
    }
    return implode(' ', $class_list);
  }
}

if (!function_exists('str_slug')) {
  // Str::slug already exists for this..
  function str_slug($title, $separator = '-'): string
  {
    return Str::slug($title, $separator);

    // Convert all dashes/underscores into separator
    $flip = $separator === '-' ? '_' : '-';

    $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

    // Replace @ with the word 'at'
    $title = str_replace('@', $separator . 'at' . $separator, $title);

    // Remove all characters that are not the separator, letters, numbers, or whitespace.
    $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', strtolower($title));

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

    return trim($title, $separator);
  }
}

if (!function_exists('has_flourishes')) {
  function has_flourishes($module)
  {
    return !!stripos(($module->classes() ?? ""), 'flourish-') !== false;
  }
}

if (!function_exists('has_divider')) {
  function has_divider($module)
  {
    return !!stripos(($module->classes() ?? ""), 'divider-') !== false;
  }
}



if (!function_exists('acf_active')) {
  function acf_active()
  {
    return function_exists('get_field');
  }
}


if (!function_exists('bs_has_field')) {
  function bs_has_field(string $field, int | string $id, string $default = ''): bool
  {
    if (acf_active() && $check = get_field($field, $id)) {
      return true;
    }
    return false;
  }
}


if (!function_exists('bs_get_field')) {
  function bs_get_field(string $field, int | string $id, string $default = null): mixed
  {
    if (acf_active() && get_field($field, $id)) {
      return get_field($field, $id);
    }
    return $default;
  }
}

if (!function_exists('format_phone')) {
  function format_phone($number, $cc = '61', $html = null, $type = 'tel')
  {
    $phoneURL = preg_replace('/\s+/', '', $number);
    $phoneURL = str_replace("+$cc", '', $phoneURL);
    $phoneURL = str_replace(['(', ')'], '', $phoneURL);
    $phoneURL = ltrim($phoneURL, '0');
    $formattedPhone = "{$type}:+{$cc}{$phoneURL}";

    if (!$html) :
      return $formattedPhone;
    else : ?>
      <a class="formatted-phone country-code-<?= $cc ?>" href="<?= $formattedPhone; ?>"><?= esc_html__($number, 'hmw-starter-child'); ?></a>
    <?php
    endif;
  }
}


if (acf_active()) {
  if (!function_exists('get_theme_colors')) {
    function get_theme_colors()
    {
      // get the textarea value from options page without any formatting
      // check if the repeater field has rows of data
      $set_colours = [];
      $additional_colours = [];

      if (have_rows('buildystrap_theme_colours_included', 'option')) {
        // TEMP -- ACF Update has caused warnings to appear --- The @ symbol will suppress it for now (still works)
        $set_colours_data = get_field('buildystrap_theme_colours_included', 'option');
        $additional_colours_data = get_field('buildystrap_theme_colours_additional_colours', 'option');

        if (!$additional_colours_data) {
          $additional_colours_data = [];
        }

        foreach ($set_colours_data as $key => $val) {
          $set_arr = [];
          $set_arr['label'] = $key;
          $set_arr['value'] = $val;
          array_push($set_colours, $set_arr);
        }

        return array_merge($set_colours, $additional_colours_data);
      } else {
        return;
      }
    }
  }
}


// Get SVG URL
if (!function_exists('get_svg_url')) {
  function get_svg_url($url)
  {
    if (file_exists(str_replace(get_site_url(), ABSPATH, $url))) {
      $url = str_replace(get_site_url(), ABSPATH, $url);
      return file_get_contents($url);
    }
    return null;
  }
}

/**
 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.
 * */
function color_luminance(string $hex, $percent)
{
  // validate hex string
  $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
  $new_hex = '#';

  if (strlen($hex) < 6) {
    $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
  }

  // convert to decimal and change luminosity
  for ($i = 0; $i < 3; $i++) {
    $dec = hexdec(substr($hex, $i * 2, 2));
    $dec = min(max(0, $dec + $dec * $percent), 255);
    $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
  }

  return $new_hex;
}

if (!function_exists('hex2rgb')) {
  function hex2rgb($color)
  {
    $default = '0 0 0';

    //Return default if no color provided
    if (empty($color)) {
      return $default;
    }

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
      $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
      $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
    } elseif (strlen($color) == 3) {
      $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
    } else {
      return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    $output = implode(',', $rgb);


    //Return rgb(a) color string
    return $output;
  }
}

if (!function_exists('rgbaToRgb')) {
  function rgbaToRgb($rgba)
  {
    $rgba = explode(',', $rgba);
    $r = $rgba[0];
    $g = $rgba[1];
    $b = $rgba[2];
    $a = $rgba[3];

    $r = round($r * (1 - $a) + 255 * $a);
    $g = round($g * (1 - $a) + 255 * $a);
    $b = round($b * (1 - $a) + 255 * $a);

    return "$r, $g, $b";
  }
}


if (!function_exists('rgbToHsl')) {
  function rgbToHsl($rgb)
  {
    $rgb = explode(',', $rgb);
    $r = $rgb[0];
    $g = $rgb[1];
    $b = $rgb[2];

    $oldR = $r;
    $oldG = $g;
    $oldB = $b;

    $r /= 255;
    $g /= 255;
    $b /= 255;

    $max = max($r, $g, $b);
    $min = min($r, $g, $b);

    $h;
    $s;
    $l = ($max + $min) / 2;
    $d = $max - $min;

    if ($d == 0) {
      $h = $s = 0; // achromatic
    } else {
      $s = $d / (1 - abs(2 * $l - 1));

      switch ($max) {
        case $r:
          $h = 60 * fmod((($g - $b) / $d), 6);
          if ($b > $g) {
            $h += 360;
          }
          break;

        case $g:
          $h = 60 * (($b - $r) / $d + 2);
          break;

        case $b:
          $h = 60 * (($r - $g) / $d + 4);
          break;
      }
    }

    return [round($h, 2), round($s, 2), round($l, 2)];
  }
}


if (!function_exists('is_taggable')) {
  function is_taggable($property, $value)
  {
    $options = BuilderBackend::get_default_options() ? collect(BuilderBackend::get_default_options()['structure'][$property])->pluck('value')->toArray() : [];
    return !in_array($value, $options);
  }
}


if (!function_exists('hmw_woocommerce_cart_link')) {
  /**
   * Cart Link.
   *
   * Displayed a link to the cart including the number of items present and the cart total.
   *
   * @return void
   */
  function hmw_woocommerce_cart_link()
  {
    ?>
    <a class="cart-contents <?php echo WC()->cart->get_cart_contents_count() > 0 ? 'has-items' : ''; ?>" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'hmw'); ?>">
      <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
        <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
      <?php endif; ?>
    </a>
  <?php
  }
}



if (!function_exists('hmw_woocommerce_header_cart')) {
  /**
   * Display Header Cart.
   *
   * @return void
   */
  function hmw_woocommerce_header_cart()
  {
    if (is_cart()) {
      $class = 'current-menu-item';
    } else {
      $class = '';
    } ?>
    <ul id="site-headser-cart" class="site-header-cart">
      <li class="<?php echo esc_attr($class); ?>">
        <?php hmw_woocommerce_cart_link(); ?>
        <?php
        $instance = [
          'title' => '',
        ];

        the_widget('WC_Widget_Cart', $instance); ?>
      </li>
    </ul>
<?php
  }
}
