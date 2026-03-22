<?php
/**
 * Theme Customizer — настройки главной страницы (баннер и др.)
 *
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Регистрация настроек Customizer
 */
function ergo_customize_register( WP_Customize_Manager $wp_customize ) {

    // Секция «Главная страница»
    $wp_customize->add_section( 'ergo_front_page', array(
        'title'    => 'Главная страница',
        'priority' => 30,
    ) );

    // --- Баннер (до 3 слайдов) ---
    for ( $i = 1; $i <= 3; $i++ ) {
        $wp_customize->add_setting( "ergo_banner_image_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ) );
        $wp_customize->add_control( new WP_Customize_Media_Control(
            $wp_customize,
            "ergo_banner_image_{$i}",
            array(
                'label'       => sprintf( 'Баннер %d: изображение', $i ),
                'section'     => 'ergo_front_page',
                'mime_type'   => 'image',
            )
        ) );

        $wp_customize->add_setting( "ergo_banner_title_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "ergo_banner_title_{$i}", array(
            'label'   => sprintf( 'Баннер %d: заголовок', $i ),
            'section' => 'ergo_front_page',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "ergo_banner_text_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        $wp_customize->add_control( "ergo_banner_text_{$i}", array(
            'label'   => sprintf( 'Баннер %d: текст', $i ),
            'section' => 'ergo_front_page',
            'type'    => 'textarea',
        ) );

        $wp_customize->add_setting( "ergo_banner_link_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "ergo_banner_link_{$i}", array(
            'label'   => sprintf( 'Баннер %d: ссылка (URL)', $i ),
            'section' => 'ergo_front_page',
            'type'    => 'url',
        ) );
    }
}
add_action( 'customize_register', 'ergo_customize_register' );

/**
 * Получить слайды баннера для главной
 *
 * @return array
 */
function ergo_get_banner_slides() {
    $slides = array();
    for ( $i = 1; $i <= 3; $i++ ) {
        $image_id = get_theme_mod( "ergo_banner_image_{$i}", 0 );
        $title    = get_theme_mod( "ergo_banner_title_{$i}", '' );
        $text     = get_theme_mod( "ergo_banner_text_{$i}", '' );
        $link     = get_theme_mod( "ergo_banner_link_{$i}", '' );
        if ( $image_id || $title || $text ) {
            $slides[] = array(
                'image_id' => $image_id,
                'image_url' => $image_id ? wp_get_attachment_image_url( $image_id, 'ergo-hero' ) : '',
                'title'    => $title,
                'text'     => $text,
                'link'     => $link,
            );
        }
    }
    return $slides;
}
