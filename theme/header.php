<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">Перейти к содержимому</a>

<header class="ergo-header" id="ergo-header">
    <div class="ergo-container ergo-header__inner">
        <div class="ergo-header__brand">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ergo-header__logo" rel="home">
                    <svg class="ergo-header__logo-icon" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2"/>
                        <ellipse cx="16" cy="16" rx="6" ry="14" stroke="currentColor" stroke-width="1.5"/>
                        <line x1="2" y1="16" x2="30" y2="16" stroke="currentColor" stroke-width="1.5"/>
                        <line x1="4" y1="9" x2="28" y2="9" stroke="currentColor" stroke-width="1" opacity="0.6"/>
                        <line x1="4" y1="23" x2="28" y2="23" stroke="currentColor" stroke-width="1" opacity="0.6"/>
                    </svg>
                    <span class="ergo-header__site-name"><?php bloginfo( 'name' ); ?></span>
                </a>
            <?php endif; ?>
        </div>

        <nav class="ergo-header__nav" id="ergo-nav" role="navigation" aria-label="Основная навигация">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'ergo-nav__list',
                'depth'          => 2,
                'fallback_cb'    => 'ergo_default_menu',
            ) );
            ?>
        </nav>

        <div class="ergo-header__search">
            <?php get_search_form(); ?>
        </div>

        <button class="ergo-header__toggle" id="ergo-menu-toggle" aria-controls="ergo-nav" aria-expanded="false" aria-label="Открыть меню">
            <span class="ergo-header__toggle-bar"></span>
            <span class="ergo-header__toggle-bar"></span>
            <span class="ergo-header__toggle-bar"></span>
        </button>
    </div>
</header>

<?php
/**
 * Fallback-меню с dropdown-подгруппами по образцу globalistika.ru
 */
function ergo_default_menu() {

    $l = 'ergo_get_page_url';

    $menu = array(
        array( 'label' => 'Главная', 'url' => home_url( '/' ) ),
        array(
            'label' => 'Студентам',
            'url'   => $l( 'o-globalistike' ),
            'children' => array(
                array( 'label' => 'О глобалистике',             'url' => $l( 'o-globalistike' ) ),
                array( 'label' => 'Студенческие семинары',      'url' => $l( 'studencheskie-seminari' ) ),
                array( 'label' => 'Программы курсов',           'url' => $l( 'programmi-kursov' ) ),
                array( 'label' => 'Электронные библиотеки',     'url' => $l( 'elektronnye-biblioteki' ) ),
                array( 'label' => 'Глоссарий',                  'url' => $l( 'glossariy' ) ),
                array( 'label' => 'Подкасты',                   'url' => $l( 'podkasty' ) ),
            ),
        ),
        array(
            'label' => 'Научная жизнь',
            'url'   => $l( 'seminar-globalistiki' ),
            'children' => array(
                array( 'label' => 'Семинар по глобалистике',    'url' => $l( 'seminar-globalistiki' ) ),
                array( 'label' => 'Семинары',                   'url' => get_post_type_archive_link( 'ergo_seminar' ) ?: $l( 'studencheskie-seminari' ) ),
                array( 'label' => 'Конференции',                'url' => get_post_type_archive_link( 'conference' ) ?: $l( 'konferencii' ) ),
                array( 'label' => 'Новости',                    'url' => get_post_type_archive_link( 'ergo_news' ) ?: $l( 'novosti' ) ),
            ),
        ),
        array(
            'label' => 'Библиотека',
            'url'   => get_post_type_archive_link( 'ergo_directory' ) ?: $l( 'spravochnaya-literatura' ),
            'children' => array(
                array( 'label' => 'Справочники',                'url' => get_post_type_archive_link( 'ergo_directory' ) ?: $l( 'spravochnaya-literatura' ) ),
                array( 'label' => 'Электронные библиотеки',     'url' => get_post_type_archive_link( 'ergo_library' ) ?: $l( 'elektronnye-biblioteki' ) ),
                array( 'label' => 'Статьи',                     'url' => $l( 'statyi' ) ),
            ),
        ),
        array(
            'label' => 'Учёные и организации',
            'url'   => get_post_type_archive_link( 'ergo_scientist' ) ?: $l( 'uchenye' ),
            'children' => array(
                array( 'label' => 'Учёные',                     'url' => get_post_type_archive_link( 'ergo_scientist' ) ?: $l( 'uchenye' ) ),
                array( 'label' => 'Поздравления',               'url' => $l( 'pozdravleniya' ) ),
                array( 'label' => 'Памяти коллег',              'url' => $l( 'pamyati-kolleg' ) ),
            ),
        ),
        array( 'label' => 'О нас', 'url' => home_url( '/about/' ) ),
        array( 'label' => 'Карта', 'url' => home_url( '/#ergo-map' ) ),
    );

    echo '<ul class="ergo-nav__list">';
    foreach ( $menu as $item ) {
        $has_children = ! empty( $item['children'] );
        $cls = 'ergo-nav__item' . ( $has_children ? ' ergo-nav__item--has-children' : '' );
        echo '<li class="' . esc_attr( $cls ) . '">';
        echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] );
        if ( $has_children ) {
            echo ' <svg class="ergo-nav__arrow" width="10" height="6" viewBox="0 0 10 6"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        }
        echo '</a>';
        if ( $has_children ) {
            echo '<ul class="ergo-nav__sub-menu">';
            foreach ( $item['children'] as $child ) {
                echo '<li class="ergo-nav__sub-item"><a href="' . esc_url( $child['url'] ) . '">' . esc_html( $child['label'] ) . '</a></li>';
            }
            echo '</ul>';
        }
        echo '</li>';
    }
    echo '</ul>';
}
