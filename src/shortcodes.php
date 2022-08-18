<?php

// [company-phone]
if ( ! function_exists('company_phone_shortcode')) {
    function company_phone_shortcode($atts)
    {
        $atts = shortcode_atts([
      'text' => null,
      'icon' => false,
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

        if ( ! $company_phone) {
            return;
        }

        ob_start(); ?>

<?php  ?>

<a class="<?= $atts['field']; ?>" href="<?= format_phone($company_phone, '61', false, $atts['type']) ?>">
    <?php if ($atts['icon']) : ?>
      <i class="<?= esc_attr($atts['icon']) ?>"></i>
    <?php endif; ?>
  <span><?php esc_attr_e($atts['text'] ?: $company_phone, 'hmw-starter-child'); ?></span>
</a>

<?php
    return ob_get_clean();
    }
    add_shortcode('company-phone', 'company_phone_shortcode');
}


// [company-fax]
if ( ! function_exists('company_fax_shortcode')) {
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
if ( ! function_exists('company_email_shortcode')) {
    function company_email_shortcode($atts)
    {
        $atts = shortcode_atts([
      'text' => null,
      'icon' => false
    ], $atts);

        if (is_admin() || ! function_exists('get_field')) {
            return null;
        }

        $company_email = get_field('buildystrap_company_details_company_email', 'option') ? get_field('buildystrap_company_details_company_email', 'option') : '';
        ob_start(); ?>

        <a class="company-email" href="mailto:<?php echo esc_attr($company_email); ?>">
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

if ( ! function_exists('social_icons_shortcode')) {
    function social_icons_shortcode()
    {
        ob_start();

        if (have_rows('buildystrap_company_details_social_links', 'option')): ?>

        <ul class="social-links flex items-center mb-0">

          <?php while (have_rows('buildystrap_company_details_social_links', 'option')): the_row(); ?>

          <?php
            $icon_type = get_sub_field('icon_style') ? get_sub_field('icon_style') : 'fa'; ?>

          <li class="fa-social-icon flex items-center px-1"><a href="<?php the_sub_field('link'); ?>" target="_blank"
              class="text-lg <?= $icon_type ?>b <?= $icon_type ?>-<?php echo strtolower(get_sub_field('icon')); ?>"></a></li>

          <?php endwhile; ?>

        </ul>

        <?php endif;

        return ob_get_clean();
    }
    add_shortcode('social-icons', 'social_icons_shortcode');
}


// [company-address]
if ( ! function_exists('company_address_shortcode')) {
    function company_address_shortcode()
    {
        if (is_admin() || ! function_exists('get_field')) {
            return;
        }

        $address = get_field('buildystrap_company_details_company_address', 'option') ? get_field('buildystrap_company_details_company_address', 'option') : '';

        if ( ! $address) {
            return;
        }

        ob_start(); ?>

        <address class="company-address">
          <?php echo $address; ?>
        </address>


    <?php
        return ob_get_clean();
    }
    add_shortcode('company-address', 'company_address_shortcode');
}
