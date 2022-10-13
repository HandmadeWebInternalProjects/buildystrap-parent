<?php

use Buildystrap\ThemeOptions;
?>

/******* Variables */
:root {
<?php
ThemeOptions::generateColorVars();
ThemeOptions::generateTypographyVars();
?>
}