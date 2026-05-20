<?php
/**
 * Theme Setup
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme setup
 */
function ergo_setup() {
    // Text domain
    load_theme_textdomain( 'ergonosphera', ERGO_DIR . '/languages' );

    // Theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Image sizes
    add_image_size( 'ergo-card', 400, 250, true );
    add_image_size( 'ergo-hero', 1920, 600, true );
    add_image_size( 'ergo-country-thumb', 600, 400, true );

    // Navigation menus
    register_nav_menus( array(
        'primary'  => 'Главное меню',
        'footer'   => 'Меню в подвале',
    ) );
}
add_action( 'after_setup_theme', 'ergo_setup' );

/**
 * Content width
 */
function ergo_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'ergo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'ergo_content_width', 0 );

/**
 * Widget areas
 */
function ergo_widgets_init() {
    register_sidebar( array(
        'name'          => 'Боковая панель стран',
        'id'            => 'country-sidebar',
        'description'   => 'Боковая панель для страниц стран',
        'before_widget' => '<div id="%1$s" class="ergo-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="ergo-widget__title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => 'Виджеты подвала',
        'id'            => 'footer-widgets',
        'description'   => 'Область виджетов в подвале сайта',
        'before_widget' => '<div id="%1$s" class="ergo-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="ergo-footer-widget__title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'ergo_widgets_init' );

/**
 * Разрешить SVG в медиатеке
 */
function ergo_allow_svg( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'ergo_allow_svg' );

function ergo_fix_svg_upload( $data, $file, $filename, $mimes ) {
    if ( ! empty( $data['ext'] ) && $data['ext'] === 'svg' ) {
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'ergo_fix_svg_upload', 10, 4 );
