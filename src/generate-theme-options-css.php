<?php

/* This file is used to generate css for the frontend based on the
settings that are chosen in buildystrap > settings page */

use Buildystrap\ThemeOptions;

?>

/******* Variables */
:root {
<?php

if (!function_exists('generateStructureVars')) {
  add_action('generate-structure-vars', [ThemeOptions::class, 'generateStructureVars']);
}
do_action('generate-structure-vars');

if (!function_exists('generateColorVars')) {
  add_action('generate-color-vars', [ThemeOptions::class, 'generateColorVars']);
}
do_action('generate-color-vars');

if (!function_exists('generateTypographyVars')) {
  add_action('generate-typography-vars', [ThemeOptions::class, 'generateTypographyVars']);
}
do_action('generate-typography-vars');
?>
}

/******* Utils */
<?php
if (!function_exists('generateColorUtils')) {
  add_action('generate-color-utils', [ThemeOptions::class, 'generateColorUtils']);
}
do_action('generate-color-utils');
