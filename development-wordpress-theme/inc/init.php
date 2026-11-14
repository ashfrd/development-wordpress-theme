<?php

$include_dir = trailingslashit( get_template_directory() ) . 'inc/';

/* Helper Includes */
require_once $include_dir . 'helpers/header-walker.php';
require_once $include_dir . 'helpers/header-ctas.php';
require_once $include_dir . 'helpers/footer-walker.php';

/* Theme Specific Includes */
require_once $include_dir . 'theme/acf.php';
require_once $include_dir . 'theme/acf-layouts.php';
require_once $include_dir . 'theme/ajax-loaders.php';
require_once $include_dir . 'theme/asset-loader.php';

// Load any custom functions
require_once $include_dir . 'theme/functions.php';
