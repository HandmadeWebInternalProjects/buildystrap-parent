<?php

/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
$always_show_mobile_nav = bs_get_field('buildystrap_always_show_mobile_nav', 'option');

?>

<div class="py-0 buildystrap-row">
  <nav id="main-nav" class="navbar <?= $always_show_mobile_nav ? 'navbar-expand-lg' : ''; ?>  navbar-dark" aria-labelledby="main-nav-label">

    <h2 id="main-nav-label" class="screen-reader-text">
      <?php esc_html_e('Main Navigation', 'understrap'); ?>
    </h2>


    <div class="<?php echo esc_attr($container); ?>">

      <?= apply_shortcodes('[company-phone]') ?>


      <!-- Your site title as branding in the menu -->
      <?php custom_logo(); ?>
      <!-- end custom logo -->

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'understrap'); ?>">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarNavOffcanvas">

        <div class="offcanvas-header justify-content-end">
          <button type="button" class="btn-close btn-close-black text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div><!-- .offcancas-header -->

        <!-- The WordPress Menu goes here -->
        <div class="offcanvas-body">
          <div class="d-flex flex-column flex-lg-row align-items-lg-center ms-auto gap-1">

            <?php
            wp_nav_menu(
              [
                'menu' => 'main_nav',
                'theme_location'  => 'primary',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'gx-2 navbar-nav justify-content-end flex-grow-1',
                'fallback_cb'     => '',
                'menu_id'         => 'main-menu',
                'depth'           => 3,
                'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
              ]
            );
            ?>
          </div><!-- .flex container -->
        </div><!-- .offcanvas-body -->
      </div><!-- .offcanvas -->

    </div><!-- .container(-fluid) -->


  </nav><!-- .site-navigation -->
</div>