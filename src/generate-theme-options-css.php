/******* Variables */

:root {

  /* Default Grid System */
  <?php // dd(get_field('structure_default_grid_system', 'option'));?>

  --default-grid-system: <?php echo get_field('buildystrap_structure_default_grid_system', 'option'); ?>;
  --col-gap: <?php echo get_field('buildystrap_structure_column_gap', 'option'); ?>;
  --module-gap: <?php echo get_field('buildystrap_structure_module_gap', 'option'); ?>;
  --section-padding: <?php echo get_field('buildystrap_structure_section_padding', 'option'); ?>;
  --row-padding: <?php echo get_field('buildystrap_structure_row_padding', 'option'); ?>;

/* Colours (included) */
<?php
  // check if the repeater field has rows of data
  if (function_exists('get_theme_colors')):

      $colors = get_theme_colors();

      if (isset($colors)):

          // loop through the rows of data
          foreach ($colors as $color) : ?>

--bs-<?php echo sanitize_text_field($color['label']); ?>: <?php echo sanitize_hex_color($color['value']); ?>;
--bs-<?php echo sanitize_text_field($color['label']); ?>-rgb: <?php echo hex2rgb(sanitize_hex_color($color['value'])); ?>;

<?php endforeach; endif; endif; ?>

<?php if (get_field('link_colour', 'option') && get_field('link_colour', 'option') !== 'None') :

    $link_colour = get_field('link_colour', 'option');

    ?>

--color-link: var(--color-<?php echo $link_colour; ?>);

<?php else :
    $link_colour = 'primary';
    ?>


--color-link: var(--color-primary);

<?php endif; ?>

<?php if (get_field('text_colour_main', 'option') && get_field('text_colour_main', 'option') !== 'None') :

    $text_colour_main = get_field('text_colour_main', 'option');
    ?>

--color-text-main: var(--color-<?php echo $text_colour_main; ?>);

<?php else : ?>

--color-text-main: var(--color-black);

<?php endif; ?>

<?php if (get_field('text_colour_headings', 'option') && get_field('text_colour_headings', 'option') !== 'None') :

    $text_headings = get_field('text_colour_headings', 'option');

    ?>


--color-text-headings: var(--color-<?php echo $text_headings; ?>);

<?php else : ?>

--color-text-headings: var(--color-black);

<?php endif; ?>



/* Typography */
<?php
        if (get_field('enable_google_fonts', 'option')) :
            $font_main = get_field('font_main', 'option');
            $font_headings = get_field('font_headings', 'option');
            $font_buttons = get_field('font_buttons', 'option');
        endif;
  ?>

<?php if (isset($font_main)) : ?>
--font-main: "<?php echo $font_main['font']; ?>";
<?php endif; ?>

<?php if (isset($font_headings)) : ?>
--font-headings: "<?php echo $font_headings['font']; ?>";
<?php endif; ?>

<?php if (isset($font_buttons)) : ?>
--font-buttons: "<?php echo $font_buttons['font']; ?>";
<?php endif; ?>

<?php
    // check if the repeater field has rows of data
    if (have_rows('additional_fonts', 'option')):

        // loop through the rows of data
        while (have_rows('additional_fonts', 'option')) : the_row(); ?>

<?php

  // If font is disabled, skip it
  if ( ! get_sub_field('enabled')) {
      continue;
  }

  $fontChoice = get_sub_field('font_selector');
            $fontFamily = $fontChoice['font'];
            ?>

--font-<?php trim(the_sub_field('name')); ?>: <?php echo $fontFamily; ?>;


<?php endwhile; endif;  ?>

<?php $col_gap = get_field('default_column_gap', 'option') ?? '3rem'; ?>
--col-gap: <?= $col_gap; ?>;


}
/******* END Variables */


/******* Color Utils */
<?php

            if (function_exists('get_theme_colors')):

                $colors = get_theme_colors();

                if (isset($colors)):

                    // loop through the rows of data
                    foreach ($colors as $color) :
                        $colorName = sanitize_text_field($color['label']);
                        ?>

.text-<?php echo $colorName; ?>,
.text-<?php echo $colorName; ?>:visited,
.text-<?php echo $colorName; ?>:hover {
color: var(--color-<?php echo $colorName; ?>);
}

.bg-<?php echo $colorName; ?>,
.bg-<?php echo $colorName; ?>:hover {
background-color: var(--color-<?php echo $colorName;
                        ; ?>);
}


<?php endforeach; endif; endif; ?>
.text-link {
color: var(--color-<?php echo $link_colour; ?>);
}
/******* END Color Utils */
