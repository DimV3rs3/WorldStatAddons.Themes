<?php
/**
 * Front Page — Главная страница (стиль globalistika.ru)
 *
 * Порядок:
 *   1) Баннер (из Customizer)
 *   2) Блок-карточки разделов (сетка с иконками)
 *   3) О платформе
 *   4) Актуальные новости + кнопка «Загрузить ещё»
 *   5) Статьи по глобалистике / Глоссарий / Интересные ссылки (три колонки)
 *   6) Конференции и семинары
 *   7) Нижние информационные блоки (6 карточек)
 *   8) Карта мира
 *
 * @package Ergonosphera
 */

get_header();

$themes          = ergo_get_data_themes();
$themes_count    = count( $themes );
$countries_count = ergo_get_countries_count();

/* ===== Запросы ===== */
$cat_news     = get_cat_ID( 'Новости' );
$cat_articles = get_cat_ID( 'Статьи' );

$news_query = new WP_Query( array(
    'post_type'      => 'ergo_news',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
) );
if ( ! $news_query->have_posts() ) {
    $news_args = array( 'post_type' => 'post', 'posts_per_page' => 6, 'post_status' => 'publish', 'no_found_rows' => true );
    if ( $cat_news ) $news_args['cat'] = $cat_news;
    $news_query = new WP_Query( $news_args );
}

$articles_args = array( 'post_type' => 'post', 'posts_per_page' => 3, 'post_status' => 'publish', 'no_found_rows' => true );
if ( $cat_articles ) {
    $articles_args['cat'] = $cat_articles;
}
$articles_query = new WP_Query( $articles_args );

$conf_query = new WP_Query( array(
    'post_type'      => 'conference',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
) );

$news_url     = get_post_type_archive_link( 'ergo_news' ) ?: ergo_get_page_url( 'novosti' );
$articles_url = ergo_get_page_url( 'statyi' );
$conf_url     = get_post_type_archive_link( 'conference' ) ?: ergo_get_page_url( 'konferencii' );
?>

<main id="main-content" class="ergo-main ergo-front-page">

<!-- ============================
     1) БАННЕР
     ============================ -->
<?php get_template_part( 'template-parts/components/front-banner' ); ?>


<!-- ============================
     2) БЛОКИ РАЗДЕЛОВ (как «Справочные издания», «Учебная литература» и т.д.)
     ============================ -->
<section class="gl-sections">
    <div class="ergo-container">
        <div class="gl-sections__grid">
            <?php
            $cards = array(
                array( 'icon' => 'dashicons-megaphone',        'title' => 'Новости',          'desc' => 'Актуальные новости платформы и события в области глобальных исследований.',                      'url' => $news_url,     'color' => '#6366f1' ),
                array( 'icon' => 'dashicons-media-document',   'title' => 'Статьи',           'desc' => 'Подборка статей по визуализации данных, глобалистике и смежным темам.',                          'url' => $articles_url, 'color' => '#0ea5e9' ),
                array( 'icon' => 'dashicons-groups',           'title' => 'Конференции',      'desc' => 'Международные и всероссийские конференции, семинары.',                                            'url' => $conf_url, 'color' => '#10b981' ),
                array( 'icon' => 'dashicons-location-alt',     'title' => 'Карта мира',       'desc' => 'Интерактивная карта с визуализацией данных по странам.',                                          'url' => '#world-map-section',                                     'color' => '#f59e0b' ),
                array( 'icon' => 'dashicons-admin-site-alt3',  'title' => 'Страны',           'desc' => 'Обзор всех стран с детальной статистикой.',                                                       'url' => get_post_type_archive_link( 'country' ),                  'color' => '#8b5cf6' ),
                array( 'icon' => 'dashicons-chart-bar',        'title' => 'Темы данных',      'desc' => 'Плагины для визуализации статистических данных на карте.',                                        'url' => home_url( '/data-themes/' ),                              'color' => '#ec4899' ),
                array( 'icon' => 'dashicons-image-filter',     'title' => 'Сравнение стран',  'desc' => 'Сравнительный анализ показателей нескольких стран.',                                              'url' => home_url( '/compare/' ),                                  'color' => '#14b8a6' ),
                array( 'icon' => 'dashicons-info-outline',     'title' => 'О платформе',      'desc' => 'О проекте, возможностях и для кого предназначена платформа.',                                    'url' => home_url( '/about/' ),                                    'color' => '#64748b' ),
            );
            foreach ( $cards as $card ) :
            ?>
                <a href="<?php echo esc_url( $card['url'] ); ?>" class="gl-card" style="--card-accent:<?php echo esc_attr( $card['color'] ); ?>">
                    <span class="gl-card__icon dashicons <?php echo esc_attr( $card['icon'] ); ?>"></span>
                    <strong class="gl-card__title"><?php echo esc_html( $card['title'] ); ?></strong>
                    <span class="gl-card__desc"><?php echo esc_html( $card['desc'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ============================
     3) О ПЛАТФОРМЕ (тёмный блок, как «GLOBALISTIKA.RU» на оригинале)
     ============================ -->
<section class="gl-about-banner">
    <div class="ergo-container">
        <h2 class="gl-about-banner__name"><?php bloginfo( 'name' ); ?></h2>
        <p class="gl-about-banner__text">
            Универсальная платформа для визуализации глобальных данных.
            Проект предназначен для исследователей, студентов и всех, кто интересуется сравнительной аналитикой по странам мира.
            Используйте интерактивную карту, темы данных и инструменты сравнения для глубокого анализа.
        </p>
    </div>
</section>


<!-- ============================
     4) АКТУАЛЬНЫЕ НОВОСТИ
     ============================ -->
<section class="gl-news" id="news">
    <div class="ergo-container">
        <h2 class="gl-section-heading">Актуальные новости</h2>

        <?php if ( $news_query->have_posts() ) : ?>
            <div class="gl-news__grid">
                <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
                    <article class="gl-news__item">
                        <a href="<?php the_permalink(); ?>" class="gl-news__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="gl-news__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php endif; ?>
                            <div class="gl-news__body">
                                <time class="gl-news__date"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></time>
                                <h3 class="gl-news__title"><?php the_title(); ?></h3>
                                <p class="gl-news__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16, '...' ) ); ?></p>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <div class="gl-news__more">
                <a href="<?php echo esc_url( $news_url ); ?>" class="ergo-btn ergo-btn--outline">Загрузить ещё</a>
            </div>
        <?php else : ?>
            <p class="gl-empty">Новости появятся здесь после публикации.</p>
        <?php endif; ?>
    </div>
</section>


<!-- ============================
     5) ТРИ КОЛОНКИ: Статьи / Глоссарий / Ссылки (как на globalistika нижняя часть)
     ============================ -->
<section class="gl-three-cols" id="articles">
    <div class="ergo-container">
        <div class="gl-three-cols__grid">
            <!-- Статьи -->
            <div class="gl-three-cols__col">
                <h3 class="gl-three-cols__heading">Статьи</h3>
                <?php if ( $articles_query->have_posts() ) : ?>
                    <ul class="gl-three-cols__list">
                        <?php while ( $articles_query->have_posts() ) : $articles_query->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                <?php endif; ?>
                <a href="<?php echo esc_url( $articles_url ); ?>" class="gl-three-cols__more">Все статьи &rarr;</a>
            </div>
            <!-- Глоссарий -->
            <div class="gl-three-cols__col">
                <h3 class="gl-three-cols__heading">Глоссарий</h3>
                <p class="gl-three-cols__text">Словарь наиболее часто встречающихся терминов, понятий и явлений в области глобалистики и визуализации данных.</p>
                <a href="<?php echo esc_url( home_url( '/about/#faq' ) ); ?>" class="gl-three-cols__more">Перейти &rarr;</a>
            </div>
            <!-- Ссылки -->
            <div class="gl-three-cols__col">
                <h3 class="gl-three-cols__heading">Полезные ссылки</h3>
                <p class="gl-three-cols__text">Важные ресурсы для исследователей: электронные библиотеки, базы данных, API, документация.</p>
                <a href="<?php echo esc_url( home_url( '/api-docs/' ) ); ?>" class="gl-three-cols__more">Перейти &rarr;</a>
            </div>
        </div>
    </div>
</section>


<!-- ============================
     6) КОНФЕРЕНЦИИ И СЕМИНАРЫ
     ============================ -->
<section class="gl-conferences" id="conferences">
    <div class="ergo-container">
        <h2 class="gl-section-heading">Конференции и семинары</h2>

        <?php if ( $conf_query->have_posts() ) : ?>
            <div class="gl-conferences__grid">
                <?php while ( $conf_query->have_posts() ) : $conf_query->the_post();
                    $c_date  = get_post_meta( get_the_ID(), 'conference_date', true );
                    $c_place = get_post_meta( get_the_ID(), 'conference_place', true );
                ?>
                    <article class="gl-conf-card">
                        <a href="<?php the_permalink(); ?>" class="gl-conf-card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="gl-conf-card__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php else : ?>
                                <div class="gl-conf-card__thumb gl-conf-card__thumb--placeholder"></div>
                            <?php endif; ?>
                            <div class="gl-conf-card__overlay">
                                <h3 class="gl-conf-card__title"><?php the_title(); ?></h3>
                                <?php if ( $c_date || $c_place ) : ?>
                                    <p class="gl-conf-card__meta">
                                        <?php if ( $c_date ) echo esc_html( $c_date ); ?>
                                        <?php if ( $c_date && $c_place ) echo ' &bull; '; ?>
                                        <?php if ( $c_place ) echo esc_html( $c_place ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="gl-conferences__more">
                <a href="<?php echo esc_url( $conf_url ); ?>" class="ergo-btn ergo-btn--outline">Все конференции</a>
            </div>
        <?php else : ?>
            <p class="gl-empty">Конференции появятся здесь после публикации.</p>
        <?php endif; ?>
    </div>
</section>


<!-- ============================
     7) НИЖНИЕ ИНФО-БЛОКИ (как на globalistika: Семинар / Глоссарий / Библиотеки / Путеводитель / ФГП / Справочная литература)
     ============================ -->
<section class="gl-info-blocks">
    <div class="ergo-container">
        <div class="gl-info-blocks__grid">
            <?php
            $info = array(
                array( 'title' => 'Карта мира',            'desc' => 'Интерактивная карта с визуализацией данных по странам.',                        'url' => '#world-map-section' ),
                array( 'title' => 'Глоссарий',             'desc' => 'Расширяющийся словарь терминов, понятий и явлений.',                            'url' => home_url( '/about/#faq' ) ),
                array( 'title' => 'Электронные ресурсы',   'desc' => 'Важные ресурсы для исследователей: от API до электронных библиотек.',            'url' => home_url( '/api-docs/' ) ),
                array( 'title' => 'Путеводитель',          'desc' => 'О платформе: возможности, инструменты и для кого предназначена.',                'url' => home_url( '/about/' ) ),
                array( 'title' => 'Страны мира',           'desc' => 'Все страны с данными по выбранным темам.',                                       'url' => get_post_type_archive_link( 'country' ) ),
                array( 'title' => 'Справочная информация', 'desc' => 'Документация, руководства для разработчиков, описание API.',                    'url' => home_url( '/documentation/' ) ),
            );
            foreach ( $info as $block ) :
            ?>
                <a href="<?php echo esc_url( $block['url'] ); ?>" class="gl-info-block">
                    <strong class="gl-info-block__title"><?php echo esc_html( $block['title'] ); ?></strong>
                    <span class="gl-info-block__desc"><?php echo esc_html( $block['desc'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ============================
     8) КАРТА МИРА
     ============================ -->
<section class="ergo-map-section" id="world-map-section">
    <div class="ergo-container" style="padding:0">
        <?php if ( $themes_count > 0 ) : ?>
            <div class="ergo-theme-selector ergo-theme-selector--above-map" style="padding:1.5rem var(--ergo-gutter)">
                <div class="ergo-theme-selector__controls" style="max-width:500px">
                    <div class="ergo-select-wrapper">
                        <select id="ergo-theme-select" class="ergo-select">
                            <option value="">— Выберите тему данных —</option>
                            <?php foreach ( $themes as $theme ) : ?>
                                <option value="<?php echo esc_attr( $theme['id'] ); ?>"
                                    data-icon="<?php echo esc_attr( $theme['icon'] ?? '' ); ?>"
                                    data-color="<?php echo esc_attr( $theme['color'] ?? '#6366f1' ); ?>"
                                    data-description="<?php echo esc_attr( $theme['description'] ?? '' ); ?>">
                                    <?php echo esc_html( $theme['name'] ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="ergo-map-wrapper">
        <div class="ergo-map-controls">
            <button class="ergo-map-btn" id="map-zoom-in" title="Приблизить">+</button>
            <button class="ergo-map-btn" id="map-zoom-out" title="Отдалить">−</button>
            <button class="ergo-map-btn" id="map-reset" title="Сбросить вид">⟳</button>
        </div>
        <div class="ergo-map-container" id="ergo-world-map">
            <div class="ergo-map-loading"><div class="ergo-spinner"></div><p>Загрузка карты...</p></div>
        </div>
        <div class="ergo-map-region-legend" id="map-region-legend">
            <div class="ergo-map-region-legend__item"><span class="ergo-map-region-legend__dot" style="background:#5B8FD6"></span>Европа</div>
            <div class="ergo-map-region-legend__item"><span class="ergo-map-region-legend__dot" style="background:#5EAF5E"></span>Азия</div>
            <div class="ergo-map-region-legend__item"><span class="ergo-map-region-legend__dot" style="background:#F0A830"></span>Африка</div>
            <div class="ergo-map-region-legend__item"><span class="ergo-map-region-legend__dot" style="background:#E05555"></span>Сев. Америка</div>
            <div class="ergo-map-region-legend__item"><span class="ergo-map-region-legend__dot" style="background:#9B59B6"></span>Юж. Америка</div>
            <div class="ergo-map-region-legend__item"><span class="ergo-map-region-legend__dot" style="background:#1ABC9C"></span>Океания</div>
        </div>
        <div class="ergo-map-legend" id="map-legend" hidden>
            <h4 class="ergo-map-legend__title" id="legend-title"></h4>
            <div class="ergo-map-legend__scale" id="legend-scale"></div>
            <div class="ergo-map-legend__labels"><span id="legend-min"></span><span id="legend-unit"></span><span id="legend-max"></span></div>
        </div>
    </div>
</section>


<!-- ============================
     FOOTER-CTA
     ============================ -->
<section class="ergo-cta">
    <div class="ergo-container">
        <div class="ergo-cta__content">
            <h2 class="ergo-cta__title">Начните изучение глобальных данных</h2>
            <p class="ergo-cta__text">Интерактивная карта и темы данных — откройте аналитику по странам мира</p>
            <div class="ergo-cta__buttons">
                <a href="#world-map-section" class="ergo-btn ergo-btn--primary ergo-btn--lg">К карте мира</a>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'country' ) ); ?>" class="ergo-btn ergo-btn--outline ergo-btn--lg">Все страны</a>
            </div>
        </div>
    </div>
</section>

</main>

<?php get_footer(); ?>
