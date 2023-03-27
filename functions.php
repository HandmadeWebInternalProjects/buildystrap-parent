<?php

use function Roots\bootloader;

defined('ABSPATH') || exit;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
  wp_die(__('Error locating autoloader. Please run <code>composer install</code>.'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/
try {
  bootloader()->boot();
  require_once __DIR__ . '/vendor/illuminate/support/helpers.php';
} catch (Throwable $e) {
  wp_die('You need to install Acorn to use this theme.');
}

// Load Understrap functions
require __DIR__ . '/understrap/functions.php';

// Load Buildystrap helpers
require __DIR__ . '/src/helpers.php';

// Load Buildystrap functions
require __DIR__ . '/src/functions.php';

// Load shortcodes
require __DIR__ . '/src/shortcodes.php';

// Temporarily fix Gravity Forms Merge Tags not displaying
add_action('admin_footer', function () {
?>
  <script>
    if (typeof window.gform?.addFilter === 'function') {
      gform?.addFilter('gform_merge_tags', 'MaybeAddSaveLinkMergeTag');

      function MaybeAddSaveLinkMergeTag(mergeTags, elementId, hideAllFields, excludeFieldTypes, isPrepop, option) {
        var event = document.getElementById('event')?.value;
        if (event === 'form_saved' || event === 'form_save_email_requested') {
          mergeTags['other'].tags.push({
            tag: '{save_link}',
            label: <?php echo json_encode(esc_html__('Save & Continue Link', 'gravityforms')); ?>
          });
          mergeTags['other'].tags.push({
            tag: '{save_token}',
            label: <?php echo json_encode(esc_html__('Save & Continue Token', 'gravityforms')); ?>
          });
        }
        return mergeTags;
      }
    }
  </script>
<?php
});
