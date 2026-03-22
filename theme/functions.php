<?php
/**
 * Ergonosphera Theme Functions
 * 
 * Universal platform for global data visualization
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

// Theme constants
define( 'ERGO_VERSION', '1.0.0' );
define( 'ERGO_DIR', get_template_directory() );
define( 'ERGO_URI', get_template_directory_uri() );

// Include core files
require_once ERGO_DIR . '/inc/theme-setup.php';
require_once ERGO_DIR . '/inc/enqueue.php';
require_once ERGO_DIR . '/inc/custom-post-types.php';
require_once ERGO_DIR . '/inc/countries-data.php';
require_once ERGO_DIR . '/inc/plugin-api.php';
require_once ERGO_DIR . '/inc/ajax-handlers.php';
require_once ERGO_DIR . '/inc/rest-api.php';
require_once ERGO_DIR . '/inc/template-functions.php';
require_once ERGO_DIR . '/inc/customizer.php';
require_once ERGO_DIR . '/inc/rewrite-rules.php';
require_once ERGO_DIR . '/inc/sample-content.php';
