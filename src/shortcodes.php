<?php

// [company-phone]
if (!function_exists('company_phone_shortcode')) {
  function company_phone_shortcode($atts)
  {
    $atts = shortcode_atts([
      'text' => null,
      'icon' => false,
      'class' => 'd-flex align-items-baseline gap-3',
      'field' => 'buildystrap_company_details_company_phone',
      'type' => 'tel'
    ], $atts);

    if (is_admin()) {
      return null;
    }
    $company_phone = 'xxxx xxx xxx';
    if (function_exists('get_field')) {
      $company_phone = get_field($atts['field'], 'option') ? get_field($atts['field'], 'option') : $company_phone;
    }

    if (!$company_phone) {
      return;
    }

    ob_start(); ?>

    <a class="<?= $atts['class']; ?>" href="<?= format_phone($company_phone, '61', false, $atts['type']) ?>">
      <?php if ($atts['icon']) : ?>
        <i class="<?= esc_attr($atts['icon']) ?>"></i>
      <?php endif; ?>
      <span><?php esc_attr_e($atts['text'] ?: $company_phone, 'buildystrap-child'); ?></span>
    </a>

  <?php
    return ob_get_clean();
  }
  add_shortcode('company-phone', 'company_phone_shortcode');
}


// [company-fax]
if (!function_exists('company_fax_shortcode')) {
  function company_fax_shortcode()
  {
    if (is_admin()) {
      return null;
    }

    ob_start();

    echo apply_shortcodes('[company-phone type=\'fax\' field=\'company_fax\']');

    return ob_get_clean();
  }
  add_shortcode('company-fax', 'company_fax_shortcode');
}


// [company-email]
if (!function_exists('company_email_shortcode')) {
  function company_email_shortcode($atts)
  {
    $atts = shortcode_atts([
      'text' => null,
      'icon' => false
    ], $atts);

    if (is_admin() || !function_exists('get_field')) {
      return null;
    }

    $company_email = get_field('buildystrap_company_details_company_email', 'option') ? get_field('buildystrap_company_details_company_email', 'option') : '';
    ob_start(); ?>

    <a class="company-email d-flex align-items-baseline gap-3" href="mailto:<?php echo esc_attr($company_email); ?>">
      <?php if ($atts['icon']) : ?>
        <i class="<?= esc_attr($atts['icon']) ?>"></i>
      <?php endif; ?>
      <span><?php echo esc_attr_e($atts['text'] ?: $company_email, 'hmw-starter-child'); ?></span>
    </a>
  <?php
    return ob_get_clean();
  }
  add_shortcode('company-email', 'company_email_shortcode');
}


// [company-address]
if (!function_exists('company_address_shortcode')) {
  function company_address_shortcode($atts)
  {
    if (is_admin() || !function_exists('get_field')) {
      return;
    }

    $atts = shortcode_atts([
      'icon' => false
    ], $atts);

    $address = get_field('buildystrap_company_details_company_address', 'option') ? get_field('buildystrap_company_details_company_address', 'option') : '';

    if (!$address) {
      return;
    }

    ob_start(); ?>

    <address class="company-address d-flex align-items-baseline gap-3">
      <?php if ($atts['icon']) : ?>
        <i class="<?= esc_attr($atts['icon']) ?>"></i>
      <?php endif; ?>
      <div>
        <?php echo $address; ?>
      </div>
    </address>

    <?php
    return ob_get_clean();
  }
  add_shortcode('company-address', 'company_address_shortcode');
}


// [company-abn]
if (!function_exists('company_abn_shortcode')) {
  function company_abn_shortcode()
  {
    if (is_admin()) {
      return null;
    }

    ob_start();

    $company_abn = get_field('company_abn', 'option');

    if ($company_abn) { ?>
      <span class="company-abn">ABN <?php echo $company_abn; ?></span>
    <?php }

    return ob_get_clean();
  }
  add_shortcode('company-abn', 'company_abn_shortcode');
}


// [menu name=""]
if (!function_exists('menu_shortcode')) {
  function menu_shortcode($atts, $content = null)
  {
    $atts = shortcode_atts([
      'name' => null,
      'depth' => 0
    ], $atts);
    $content .= wp_nav_menu(array('menu' => $atts['name'], 'echo' => false, 'depth' => $atts['depth']));
    return $content;
  }
  add_shortcode('menu', 'menu_shortcode');
}


// [social-icons]
if (!function_exists('social_icons_shortcode')) {
  function social_icons_shortcode()
  {
    ob_start();

    if (have_rows('buildystrap_company_details_social_links', 'option')) : ?>

      <ul class="social-links flex items-center mb-0">

        <?php while (have_rows('buildystrap_company_details_social_links', 'option')) : the_row(); ?>

          <?php $icon_type = get_sub_field('icon_style') ? get_sub_field('icon_style') : 'fa'; ?>

          <li class="fa-social-icon flex items-center px-1"><a href="<?php the_sub_field('link'); ?>" target="_blank" class="text-lg <?= $icon_type ?>b <?= $icon_type ?>-<?php echo strtolower(get_sub_field('icon')); ?>"></a></li>

        <?php endwhile; ?>

      </ul>

    <?php endif;

    return ob_get_clean();
  }
  add_shortcode('social-icons', 'social_icons_shortcode');
}


// [site-year]
if (!function_exists('site_year_shortcode')) {
  function site_year_shortcode()
  {
    if (is_admin()) {
      return null;
    }
    return date('Y');
  }
  add_shortcode('site-year', 'site_year_shortcode');
}


// [site-name]
if (!function_exists('site_name_shortcode')) {
  function site_name_shortcode()
  {
    if (is_admin()) {
      return null;
    }
    return get_option('blogname');
  }
  add_shortcode('site-name', 'site_name_shortcode');
}


// [site-description]
if (!function_exists('site_description_shortcode')) {
  function site_description_shortcode()
  {
    if (is_admin()) {
      return null;
    }
    return get_bloginfo('site_description');
  }
  add_shortcode('site-description', 'site_description_shortcode');
}


// [site-url]
if (!function_exists('site_url_shortcode')) {
  function site_url_shortcode()
  {
    if (is_admin()) {
      return null;
    }
    return esc_url(home_url('/'));
  }
  add_shortcode('site-url', 'site_url_shortcode');
}


// [site-credits]
if (!function_exists('site_credits_shortcode')) {
  function site_credits_shortcode()
  {
    if (is_admin()) {
      return null;
    }
    $domain_name = preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']);
    return '<div class="hmw-credit-link">Crafted by <a href="https://www.handmadeweb.com.au/?utm_source=client_footer&utm_medium=referral&utm_campaign=' . $domain_name . '" rel="nofollow" target="_blank">Handmade Web & Design</a></div>';
  }
  add_shortcode('site-credits', 'site_credits_shortcode');
}


// [share-post]
if (!function_exists('share_post_shortcode')) {
  function share_post_shortcode($atts)
  {
    extract(shortcode_atts(array(
      'title' => 'Share'
    ), $atts));
    ob_start();
    if (is_single() || function_exists('is_product') && is_product()) {
      $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'full'); ?>
      <div class="social-share">
        <span class="share-title"><?php echo $title; ?></span>
        <ul>
          <li class="facebook fab fa-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"></a></li>
          <li class="twitter fab fa-twitter"><a href="https://twitter.com/home?status=<?php echo get_permalink(); ?>" target="_blank"></a></li>
          <li class="pinterest fab fa-pinterest"><a href="https://pinterest.com/pin/create/button/?url=&media=<?php echo $img[0]; ?>&description=" target="_blank"></a></li>
          <li class="email fas fa-envelope"><a href="mailto:?&body=<?php echo get_permalink(); ?>"></a></li>
        </ul>
      </div>
  <?php }
    return ob_get_clean();
  }
  add_shortcode('share-post', 'share_post_shortcode');
}

add_shortcode('sitewide-message', function ($atts) {
  if (is_admin() && !function_exists('get_field')) {
    return null;
  }

  $atts = shortcode_atts([
    "icon" => 'fas fa-times'
  ], $atts);

  $bg_colour = get_field('buildystrap_sitewide_message_bg_colour', 'option') ?? '';
  $text_colour = get_field('buildystrap_sitewide_message_text_colour', 'option') ?? '';



  $classes = collect([
    $bg_colour ? "bg-{$bg_colour}" : null,
    $text_colour ? "text-{$text_colour}" : null
  ])->filter()->implode(' ');

  ob_start();
  ?>

  <?php if (get_field('buildystrap_sitewide_message_content', 'option')) { ?>
    <div id="sitewide-message-bar" role="dialog" aria-describedby="dialog-description" class="sitewide-message <?= $classes ?>" style="background: <?= $bg_colour; ?>; color: <?= $text_colour; ?>;">
      <div class="container position-relative py-2">
        <div class="row">
          <div class="col">
            <div id="dialog-description" class="sitewide-message__content">
              <?php echo get_field('buildystrap_sitewide_message_content', 'option'); ?>
            </div>
          </div>
        </div>
        <i tabindex="6" class="position-absolute cursor-pointer top-2 end-0 <?= $atts['icon']; ?> bar-exit"></i>
      </div>
    </div>
  <?php } ?>

<?php

  return ob_get_clean();
});
