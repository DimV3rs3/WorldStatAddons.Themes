<?php
/**
 * Template helper functions — Вспомогательные функции шаблонов
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Хлебные крошки
 */
function ergo_breadcrumbs( $items = array() ) {
    $home = array( 'url' => home_url( '/' ), 'label' => 'Главная' );
    $crumbs = array_merge( array( $home ), $items );

    echo '<nav class="ergo-breadcrumbs" aria-label="Навигация">';
    echo '<ol class="ergo-breadcrumbs__list">';

    foreach ( $crumbs as $i => $crumb ) {
        $is_last = ( $i === count( $crumbs ) - 1 );
        echo '<li class="ergo-breadcrumbs__item">';
        if ( ! $is_last && ! empty( $crumb['url'] ) ) {
            printf( '<a href="%s">%s</a>', esc_url( $crumb['url'] ), esc_html( $crumb['label'] ) );
        } else {
            printf( '<span aria-current="page">%s</span>', esc_html( $crumb['label'] ) );
        }
        if ( ! $is_last ) {
            echo '<span class="ergo-breadcrumbs__sep">&rsaquo;</span>';
        }
        echo '</li>';
    }

    echo '</ol></nav>';
}

/**
 * Карточка темы данных
 */
function ergo_render_theme_card( $theme, $args = array() ) {
    $defaults = array(
        'show_preview_map' => false,
        'show_description' => true,
        'link_to_map'      => true,
    );
    $args = wp_parse_args( $args, $defaults );
    ?>
    <div class="ergo-theme-card" data-theme-id="<?php echo esc_attr( $theme['id'] ); ?>" style="--theme-color: <?php echo esc_attr( $theme['color'] ?? '#6366f1' ); ?>">
        <div class="ergo-theme-card__header">
            <?php if ( ! empty( $theme['icon'] ) ) : ?>
                <span class="ergo-theme-card__icon dashicons <?php echo esc_attr( $theme['icon'] ); ?>"></span>
            <?php endif; ?>
            <h3 class="ergo-theme-card__title"><?php echo esc_html( $theme['name'] ); ?></h3>
        </div>

        <?php if ( $args['show_description'] && ! empty( $theme['description'] ) ) : ?>
            <p class="ergo-theme-card__desc"><?php echo esc_html( $theme['description'] ); ?></p>
        <?php endif; ?>

        <div class="ergo-theme-card__meta">
            <?php if ( ! empty( $theme['coverage'] ) ) : ?>
                <span class="ergo-theme-card__stat">
                    <strong><?php echo esc_html( $theme['coverage'] ); ?></strong> стран
                </span>
            <?php endif; ?>
            <?php if ( ! empty( $theme['last_update'] ) ) : ?>
                <span class="ergo-theme-card__stat">
                    Обновлено: <?php echo esc_html( $theme['last_update'] ); ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if ( $args['show_preview_map'] ) : ?>
            <div class="ergo-theme-card__minimap" data-theme="<?php echo esc_attr( $theme['id'] ); ?>"></div>
        <?php endif; ?>

        <div class="ergo-theme-card__actions">
            <?php if ( $args['link_to_map'] ) : ?>
                <a href="<?php echo esc_url( home_url( '/?theme=' . $theme['id'] ) ); ?>" class="ergo-btn ergo-btn--primary ergo-btn--sm">
                    Показать на карте &rarr;
                </a>
            <?php endif; ?>
            <a href="<?php echo esc_url( home_url( '/countries/?theme=' . $theme['id'] ) ); ?>" class="ergo-btn ergo-btn--outline ergo-btn--sm">
                Обзор стран
            </a>
        </div>

        <?php do_action( 'ergo_theme_card_extra', $theme ); ?>
    </div>
    <?php
}

/**
 * Карточка страны
 */
function ergo_render_country_card( $country ) {
    $themes = ergo_get_data_themes();
    $tabs = ergo_get_country_tabs( $country['code'] );
    ?>
    <div class="ergo-country-card" data-code="<?php echo esc_attr( $country['code'] ); ?>">
        <div class="ergo-country-card__flag">
            <?php echo esc_html( $country['flag'] ?: '🏳️' ); ?>
        </div>
        <div class="ergo-country-card__info">
            <h3 class="ergo-country-card__name">
                <a href="<?php echo esc_url( $country['url'] ); ?>"><?php echo esc_html( $country['name'] ); ?></a>
            </h3>
            <span class="ergo-country-card__region"><?php echo esc_html( $country['region'] ); ?></span>
        </div>
        <div class="ergo-country-card__badges">
            <?php if ( ! empty( $tabs ) ) : ?>
                <?php foreach ( $tabs as $tab ) : 
                    $theme = ergo_get_data_theme( $tab['id'] );
                    $color = $theme['color'] ?? '#6366f1';
                ?>
                    <span class="ergo-badge" style="--badge-color: <?php echo esc_attr( $color ); ?>" title="<?php echo esc_attr( $tab['title'] ); ?>">
                        <?php if ( ! empty( $tab['icon'] ) ) : ?>
                            <span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
                        <?php endif; ?>
                        <?php echo esc_html( $tab['title'] ); ?>
                    </span>
                <?php endforeach; ?>
            <?php else : ?>
                <span class="ergo-badge ergo-badge--muted">Нет данных</span>
            <?php endif; ?>
        </div>
        <a href="<?php echo esc_url( $country['url'] ); ?>" class="ergo-btn ergo-btn--outline ergo-btn--sm">
            Подробнее
        </a>
    </div>
    <?php
}

/**
 * Рендер секции компонента по типу
 */
function ergo_render_section( $section, $section_index = 0 ) {
    $type = $section['type'] ?? 'text';
    $template = 'template-parts/components/section-' . sanitize_file_name( $type ) . '.php';

    if ( file_exists( ERGO_DIR . '/' . $template ) ) {
        include ERGO_DIR . '/' . $template;
    } else {
        include ERGO_DIR . '/template-parts/components/section-text.php';
    }
}

/**
 * Сообщение «нет данных»
 */
function ergo_render_no_data( $context = 'general' ) {
    ?>
    <div class="ergo-no-data">
        <div class="ergo-no-data__icon">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                <circle cx="40" cy="40" r="38" stroke="currentColor" stroke-width="2" opacity="0.2"/>
                <path d="M28 44c0-6.627 5.373-12 12-12s12 5.373 12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.3"/>
                <circle cx="32" cy="34" r="2" fill="currentColor" opacity="0.3"/>
                <circle cx="48" cy="34" r="2" fill="currentColor" opacity="0.3"/>
            </svg>
        </div>
        <?php if ( $context === 'themes' ) : ?>
            <h3>Не установлены темы данных</h3>
            <p>Установите плагины для визуализации статистических данных на карте.</p>
            <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=ergonosphera+data+theme&tab=search' ) ); ?>" class="ergo-btn ergo-btn--primary">
                Просмотреть доступные плагины
            </a>
        <?php elseif ( $context === 'country' ) : ?>
            <h3>Нет данных</h3>
            <p>Для этой страны пока нет данных. Установите плагины для добавления статистических данных.</p>
        <?php else : ?>
            <h3>Нет данных</h3>
            <p>В данный момент данные для отображения отсутствуют.</p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Разделы главной страницы (портальные карточки в стиле globalistika.ru)
 *
 * @return array
 */
function ergo_get_front_page_sections() {
    $sections = array(
        array(
            'title'       => 'Новости',
            'description' => 'Актуальные новости платформы и события.',
            'url'         => get_post_type_archive_link( 'ergo_news' ) ?: ergo_get_page_url( 'novosti' ),
            'icon'        => 'dashicons-megaphone',
            'color'       => '#6366f1',
        ),
        array(
            'title'       => 'Статьи',
            'description' => 'Интересные статьи по глобалистике и визуализации данных.',
            'url'         => ergo_get_page_url( 'statyi' ),
            'icon'        => 'dashicons-media-document',
            'color'       => '#0ea5e9',
        ),
        array(
            'title'       => 'Конференции',
            'description' => 'Международные и всероссийские конференции.',
            'url'         => get_post_type_archive_link( 'conference' ) ?: ergo_get_page_url( 'konferencii' ),
            'icon'        => 'dashicons-groups',
            'color'       => '#10b981',
        ),
        array(
            'title'       => 'Карта мира',
            'description' => 'Интерактивная карта с визуализацией данных по странам. Выберите тему данных и изучайте статистику.',
            'url'         => home_url( '/#world-map-section' ),
            'icon'        => 'dashicons-location-alt',
            'color'       => '#6366f1',
        ),
        array(
            'title'       => 'Страны',
            'description' => 'Обзор всех стран с данными по выбранным темам. Переход к детальной странице страны.',
            'url'         => get_post_type_archive_link( 'country' ),
            'icon'        => 'dashicons-admin-site-alt3',
            'color'       => '#0ea5e9',
        ),
        array(
            'title'       => 'Темы данных',
            'description' => 'Активные плагины и темы данных для визуализации на карте и в отчётах.',
            'url'         => home_url( '/data-themes/' ),
            'icon'        => 'dashicons-chart-bar',
            'color'       => '#10b981',
        ),
        array(
            'title'       => 'Сравнение',
            'description' => 'Сравнение показателей нескольких стран по выбранной теме данных.',
            'url'         => home_url( '/compare/' ),
            'icon'        => 'dashicons-image-filter',
            'color'       => '#f59e0b',
        ),
        array(
            'title'       => 'Загрузка данных',
            'description' => 'Скачивание наборов данных в различных форматах для исследований.',
            'url'         => home_url( '/data-downloads/' ),
            'icon'        => 'dashicons-download',
            'color'       => '#8b5cf6',
        ),
        array(
            'title'       => 'О платформе',
            'description' => 'О проекте Ergonosphera, возможностях платформы и для кого она предназначена.',
            'url'         => home_url( '/about/' ),
            'icon'        => 'dashicons-info-outline',
            'color'       => '#64748b',
        ),
        array(
            'title'       => 'API и документация',
            'description' => 'Документация REST API и руководства для разработчиков.',
            'url'         => home_url( '/api-docs/' ),
            'icon'        => 'dashicons-editor-code',
            'color'       => '#475569',
        ),
        array(
            'title'       => 'Статус',
            'description' => 'Статус сервисов и доступность данных платформы.',
            'url'         => home_url( '/status/' ),
            'icon'        => 'dashicons-yes-alt',
            'color'       => '#059669',
        ),
    );
    return apply_filters( 'ergo_front_page_sections', $sections );
}

/**
 * Вывод одной портальной карточки раздела (главная страница)
 *
 * @param array $section
 */
function ergo_render_portal_card( $section ) {
    $url   = $section['url'] ?? '#';
    $title = $section['title'] ?? '';
    $desc  = $section['description'] ?? '';
    $icon  = $section['icon'] ?? 'dashicons-admin-links';
    $color = $section['color'] ?? 'var(--ergo-primary)';
    ?>
    <a href="<?php echo esc_url( $url ); ?>" class="ergo-portal-card" style="--portal-color: <?php echo esc_attr( $color ); ?>">
        <span class="ergo-portal-card__icon dashicons <?php echo esc_attr( $icon ); ?>"></span>
        <h3 class="ergo-portal-card__title"><?php echo esc_html( $title ); ?></h3>
        <?php if ( $desc ) : ?>
            <p class="ergo-portal-card__desc"><?php echo esc_html( $desc ); ?></p>
        <?php endif; ?>
    </a>
    <?php
}

/**
 * Получить URL страницы по slug с кешированием.
 * При первом вызове загружает все нужные страницы одним запросом,
 * последующие вызовы возвращают результат из статического кеша.
 */
function ergo_get_page_url( $slug ) {
    static $cache = null;

    if ( $cache === null ) {
        $cache = get_transient( 'ergo_page_urls' );
        if ( ! is_array( $cache ) ) {
            $cache = array();
        }
    }

    if ( isset( $cache[ $slug ] ) ) {
        return $cache[ $slug ];
    }

    $page = get_page_by_path( $slug, OBJECT, 'page' );
    $url  = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
    $cache[ $slug ] = $url;
    set_transient( 'ergo_page_urls', $cache, 5 * MINUTE_IN_SECONDS );

    return $url;
}

/**
 * Сбросить кеш URL страниц при сохранении/удалении страницы.
 */
function ergo_flush_page_url_cache( $post_id ) {
    if ( get_post_type( $post_id ) === 'page' ) {
        delete_transient( 'ergo_page_urls' );
    }
}
add_action( 'save_post', 'ergo_flush_page_url_cache' );
add_action( 'delete_post', 'ergo_flush_page_url_cache' );

/**
 * Форматирование больших чисел
 */
function ergo_format_number( $num ) {
    if ( $num >= 1000000000 ) {
        return round( $num / 1000000000, 1 ) . ' млрд';
    }
    if ( $num >= 1000000 ) {
        return round( $num / 1000000, 1 ) . ' млн';
    }
    if ( $num >= 1000 ) {
        return round( $num / 1000, 1 ) . ' тыс';
    }
    return number_format_i18n( $num );
}
