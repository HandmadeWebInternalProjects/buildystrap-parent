

/******* Variables */

:root {

/* Default Grid System */
<?php
// dd(get_field('buildystrap_structure_default_grid_system', 'option'));?>

--bs-default-grid-system: <?php
echo get_field('buildystrap_structure_default_grid_system', 'option'); ?>;
--bs-col-gap: <?php
echo get_field('buildystrap_structure_column_gap', 'option'); ?>;
--bs-module-gap: <?php
echo get_field('buildystrap_structure_module_gap', 'option'); ?>;
--bs-section-padding: <?php
echo get_field('buildystrap_structure_section_padding', 'option'); ?>;
--bs-row-padding: <?php
echo get_field('buildystrap_structure_row_padding', 'option'); ?>;

/* Colours (included) */
<?php
// check if the repeater field has rows of data
if (function_exists('get_theme_colors')):
    $colors = get_theme_colors();
    if (isset($colors)):
        // loop through the rows of data
        foreach ($colors as $color) : ?>
          <?php if ( ! $color['value']) {
              continue;
          } ?>
          <?php $rgb = hex2rgb(sanitize_hex_color($color['value'])); ?>
          --bs-<?= sanitize_text_field($color['label']); ?>: <?= sanitize_hex_color($color['value']); ?>;
          --bs-<?= sanitize_text_field($color['label']); ?>-rgb: <?= $rgb; ?>;
        <?php endforeach;
    endif;
endif; ?>

<?php
$colour_text_link = get_field('buildystrap_theme_colours_link_colour', 'option');
if ($colour_text_link && $colour_text_link !== 'None') : ?>
    --bs-link-color: var(--bs-<?= $colour_text_link; ?>);
<?php else : ?>
    --bs-link-color: var(--color-black);
<?php endif; ?>

<?php
$colour_text_body = get_field('buildystrap_theme_colours_text_colour_body', 'option');

if (isset($colour_text_body['label']) && $colour_text_body['label'] !== 'None') : ?>
    --color-text-body: var(--bs-<?= $colour_text_body['label']; ?>);
<?php else : ?>
    --color-text-body: var(--color-black);
<?php endif; ?>

<?php
$colour_text_headings = get_field('buildystrap_theme_colours_text_colour_headings', 'option');

if (isset($colour_text_headings['label']) && $colour_text_headings['label'] !== 'None') : ?>
    --color-text-headings: var(--bs-<?= $colour_text_headings['label']; ?>);
<?php else : ?>
    --color-text-headings: var(--color-black);
<?php endif; ?>

/* Typography */
<?php
$font_main = get_field('buildystrap_typography_body_font', 'option');
$font_headings = get_field('buildystrap_typography_heading_font', 'option');
$font_buttons = get_field('buildystrap_typography_font_buttons', 'option');
?>

<?php
if (isset($font_main)) : ?>
    --font-main: "<?php
    echo $font_main['value']; ?>";
<?php
endif; ?>

<?php
if (isset($font_headings)) : ?>
    --font-headings: "<?php
    echo $font_headings['value']; ?>";
<?php
endif; ?>

<?php
if (isset($font_buttons)) : ?>
    --font-buttons: "<?php
    echo $font_buttons['value']; ?>";
<?php
endif; ?>

<?php
// check if the repeater field has rows of data
if (have_rows('buildystrap_typography_additional_fonts', 'option')):

    // loop through the rows of data
    while (have_rows('buildystrap_typography_additional_fonts', 'option')) : the_row(); ?>

        <?php
        $fontFamily = get_sub_field('value');
        ?>

        --font-<?= \Buildystrap\Str::slug(the_sub_field('label')); ?>: <?php
        echo $fontFamily; ?>;


    <?php
    endwhile; endif; ?>

<?php
$col_gap = get_field('default_column_gap', 'option') ?? '3rem'; ?>
--bs-gutter: <?= $col_gap; ?>;
--bs-gap: <?= $col_gap; ?>;
--bs-col-gap: <?= $col_gap; ?>;


}
/******* END Variables */


/******* Colors */
<?php

if (function_exists('get_theme_colors')):

    $colors = get_theme_colors();

    if (isset($colors)):

        // loop through the rows of data
        foreach ($colors as $color) :
            $colorName = sanitize_text_field($color['label']);

            if ( ! $color['value']) {
                continue;
            } ?>

            .text-<?php
            echo $colorName; ?>,
            .text-<?php
            echo $colorName; ?>:visited,
            .text-<?php
            echo $colorName; ?>:hover {
            color: var(--color-<?php
            echo $colorName; ?>);
            }

            .bg-<?php
            echo $colorName; ?>,
            .bg-<?php
            echo $colorName; ?>:hover {
            background-color: var(--color-<?php
            echo $colorName;
            ?>);
            }

            /* Buttons */
            <?= ".btn.btn-{$colorName} {" ?> 
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: var(--bs-<?= $colorName ?>);
                --bs-btn-hover-bg: var(--bs-btn-bg);
                --bs-btn-border-color: var(--bs-btn-bg);
                --bs-btn-hover-border-color: var(--bs-btn-bg);
                --bs-btn-active-color: var(--bs-white);
                --bs-btn-active-bg: var(--bs-btn-bg);
                --bs-btn-active-border-color: var(--bs-btn-bg);
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-focus-shadow-rgb: var(--bs-<?= $colorName ?>-rgb);
                --bs-btn-disabled-bg: #d5d5d5;
                --bs-btn-disabled-border-color: #d5d5d5;
            <?= '}' ?> 

            <?= ".btn.btn-outline-{$colorName} {" ?> 
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: transparent;
                --bs-btn-hover-bg: var(--bs-<?= $colorName ?>);
                --bs-btn-border-color: var(--bs-<?= $colorName ?>);
                --bs-btn-hover-border-color: var(--bs-<?= $colorName ?>);
                --bs-btn-active-color: var(--bs-white);
                --bs-btn-active-bg: var(--bs-<?= $colorName ?>);
                --bs-btn-active-border-color: var(--bs-<?= $colorName ?>);
                --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                --bs-btn-focus-shadow-rgb: var(--bs-<?= $colorName ?>-rgb);
                --bs-btn-disabled-bg: #d5d5d5;
                --bs-btn-disabled-border-color: #d5d5d5;
            <?= '}' ?> 


        <?php
        endforeach; endif; endif; ?>
.text-link {
color: var(--color-<?php
echo $link_colour; ?>);
}
/******* END Colors */
