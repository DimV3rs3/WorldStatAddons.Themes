<?php
/**
 * Custom Rewrite Rules
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Flush rewrite rules on theme activation
 */
function ergo_flush_rewrite_rules() {
    ergo_register_post_types();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ergo_flush_rewrite_rules' );

/**
 * Custom archive page for countries
 */
function ergo_countries_archive_template( $template ) {
    if ( is_post_type_archive( 'country' ) ) {
        $custom = locate_template( 'archive-country.php' );
        if ( $custom ) {
            return $custom;
        }
    }
    return $template;
}
add_filter( 'archive_template', 'ergo_countries_archive_template' );

/**
 * Page template for custom pages
 */
function ergo_page_templates( $templates ) {
    $templates['page-themes.php']        = 'Темы данных';
    $templates['page-downloads.php']     = 'Загрузка данных';
    $templates['page-about.php']         = 'О платформе';
    $templates['page-documentation.php'] = 'Документация';
    $templates['page-compare.php']       = 'Сравнение стран';
    $templates['page-api-docs.php']      = 'Документация API';
    $templates['page-status.php']        = 'Статус платформы';
    return $templates;
}
add_filter( 'theme_page_templates', 'ergo_page_templates' );
