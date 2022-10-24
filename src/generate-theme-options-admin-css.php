<?php

/* This file is used to generate css for the builder GUI based on the
settings that are chosen in buildystrap > settings page */

use Buildystrap\ThemeOptions;

?>

/******* Variables */
:root {
<?php
ThemeOptions::generateColorVars();
ThemeOptions::generateTypographyVars();
?>
}

/******* Utils */
<?php
ThemeOptions::generateColorUtils();
