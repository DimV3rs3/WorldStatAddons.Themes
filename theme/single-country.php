<?php
/**
 * Single Country Template
 * 
 * Universal country page template that plugins fill with data via hooks.
 * 
 * @package Ergonosphera
 */

get_header();

$country_id   = get_the_ID();
$country_code = get_post_meta( $country_id, 'country_code', true );
$country_name = get_the_title();
$flag         = get_post_meta( $country_id, 'flag_emoji', true );
$capital      = get_post_meta( $country_id, 'capital', true );
$region       = ergo_get_country_region( $country_id );
$lat          = get_post_meta( $country_id, 'latitude', true );
$lng          = get_post_meta( $country_id, 'longitude', true );
$population   = get_post_meta( $country_id, 'population', true );
$area         = get_post_meta( $country_id, 'area_km2', true );
$code3        = get_post_meta( $country_id, 'country_code_3', true );

// Get tabs from plugins
$tabs = ergo_get_country_tabs( $country_code );
$themes = ergo_get_data_themes();

// Breadcrumbs
ergo_breadcrumbs( array(
    array( 'url' => get_post_type_archive_link( 'country' ), 'label' => 'Страны' ),
    array( 'url' => '', 'label' => $country_name ),
) );
?>

<main id="main-content" class="ergo-main ergo-country-page">
    <div class="ergo-container">
        <div class="ergo-country-layout">

            <!-- Sidebar: Country list -->
            <aside class="ergo-country-sidebar" id="country-sidebar">
                <div class="ergo-country-sidebar__search">
                    <input type="text" id="sidebar-country-search" 
                        placeholder="<?php echo esc_attr( 'Поиск стран...' ); ?>" 
                        class="ergo-input">
                </div>
                <div class="ergo-country-sidebar__list" id="sidebar-country-list">
                    <?php
                    $by_region = ergo_get_countries_by_region();
                    foreach ( $by_region as $reg_name => $reg_countries ) : ?>
                        <div class="ergo-country-sidebar__region">
                            <h4 class="ergo-country-sidebar__region-name"><?php echo esc_html( $reg_name ); ?></h4>
                            <ul>
                                <?php foreach ( $reg_countries as $c ) : 
                                    $is_current = ( $c['code'] === $country_code );
                                ?>
                                    <li class="<?php echo $is_current ? 'is-active' : ''; ?>">
                                        <a href="<?php echo esc_url( $c['url'] ); ?>">
                                            <span class="ergo-country-sidebar__flag"><?php echo esc_html( $c['flag'] ); ?></span>
                                            <span class="ergo-country-sidebar__name"><?php echo esc_html( $c['name'] ); ?></span>
                                            <?php if ( $c['has_data'] ) : ?>
                                                <span class="ergo-country-sidebar__indicator" title="<?php echo esc_attr( 'Есть данные' ); ?>"></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="ergo-country-content">

                <!-- Country Header / Basic Info -->
                <section class="ergo-country-hero">
                    <div class="ergo-country-hero__image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'ergo-country-thumb' ); ?>
                        <?php else : ?>
                            <div class="ergo-country-hero__placeholder">
                                <span class="ergo-country-hero__flag-large"><?php echo esc_html( $flag ?: '🏳️' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="ergo-country-hero__info">
                        <div class="ergo-country-hero__top">
                            <span class="ergo-country-hero__flag"><?php echo esc_html( $flag ); ?></span>
                            <h1 class="ergo-country-hero__title"><?php echo esc_html( $country_name ); ?></h1>
                        </div>
                        <div class="ergo-country-hero__meta">
                            <div class="ergo-country-hero__meta-item">
                                <span class="ergo-country-hero__meta-label">Код ISO</span>
                                <span class="ergo-country-hero__meta-value"><?php echo esc_html( $country_code ); ?> / <?php echo esc_html( $code3 ); ?></span>
                            </div>
                            <?php if ( $capital ) : ?>
                            <div class="ergo-country-hero__meta-item">
                                <span class="ergo-country-hero__meta-label">Столица</span>
                                <span class="ergo-country-hero__meta-value"><?php echo esc_html( $capital ); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ( $region ) : ?>
                            <div class="ergo-country-hero__meta-item">
                                <span class="ergo-country-hero__meta-label">Регион</span>
                                <span class="ergo-country-hero__meta-value"><?php echo esc_html( $region ); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ( $lat && $lng ) : ?>
                            <div class="ergo-country-hero__meta-item">
                                <span class="ergo-country-hero__meta-label">Координаты</span>
                                <span class="ergo-country-hero__meta-value"><?php echo esc_html( $lat ); ?>, <?php echo esc_html( $lng ); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ( $population ) : ?>
                            <div class="ergo-country-hero__meta-item">
                                <span class="ergo-country-hero__meta-label">Население</span>
                                <span class="ergo-country-hero__meta-value"><?php echo esc_html( ergo_format_number( $population ) ); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ( $area ) : ?>
                            <div class="ergo-country-hero__meta-item">
                                <span class="ergo-country-hero__meta-label">Площадь</span>
                                <span class="ergo-country-hero__meta-value"><?php echo esc_html( number_format_i18n( $area ) ); ?> km&sup2;</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Data Theme Tabs -->
                <section class="ergo-country-tabs">
                    <?php if ( ! empty( $tabs ) ) : ?>
                        <nav class="ergo-tabs" role="tablist">
                            <?php foreach ( $tabs as $i => $tab ) : ?>
                                <button class="ergo-tab <?php echo $i === 0 ? 'is-active' : ''; ?>"
                                    role="tab"
                                    data-tab="<?php echo esc_attr( $tab['id'] ); ?>"
                                    aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                    aria-controls="tab-panel-<?php echo esc_attr( $tab['id'] ); ?>">
                                    <?php if ( ! empty( $tab['icon'] ) ) : ?>
                                        <span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
                                    <?php endif; ?>
                                    <?php echo esc_html( $tab['title'] ); ?>
                                </button>
                            <?php endforeach; ?>
                        </nav>

                        <?php do_action( 'ergo_before_country_content', $country_code ); ?>

                        <?php foreach ( $tabs as $i => $tab ) : ?>
                            <div class="ergo-tab-panel <?php echo $i === 0 ? 'is-active' : ''; ?>"
                                id="tab-panel-<?php echo esc_attr( $tab['id'] ); ?>"
                                role="tabpanel"
                                data-tab-id="<?php echo esc_attr( $tab['id'] ); ?>"
                                data-country="<?php echo esc_attr( $country_code ); ?>"
                                data-loaded="<?php echo $i === 0 ? 'true' : 'false'; ?>">

                                <?php if ( $i === 0 ) : 
                                    // Load first tab immediately
                                    $content = ergo_get_tab_content( $tab, $country_code );
                                    if ( $content && ! empty( $content['sections'] ) ) :
                                        foreach ( $content['sections'] as $si => $section ) :
                                            ergo_render_section( $section, $si );
                                        endforeach;
                                        
                                        // Download section
                                        if ( ! empty( $content['sections'] ) ) : ?>
                                            <div class="ergo-download-section">
                                                <button class="ergo-btn ergo-btn--outline ergo-btn--sm" data-download="csv" data-theme="<?php echo esc_attr( $tab['id'] ); ?>" data-country="<?php echo esc_attr( $country_code ); ?>">
                                                    Скачать CSV
                                                </button>
                                                <button class="ergo-btn ergo-btn--outline ergo-btn--sm" data-download="xlsx" data-theme="<?php echo esc_attr( $tab['id'] ); ?>" data-country="<?php echo esc_attr( $country_code ); ?>">
                                                    Скачать XLSX
                                                </button>
                                                <button class="ergo-btn ergo-btn--outline ergo-btn--sm" data-download="json" data-theme="<?php echo esc_attr( $tab['id'] ); ?>" data-country="<?php echo esc_attr( $country_code ); ?>">
                                                    Скачать JSON
                                                </button>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Source info -->
                                        <?php if ( ! empty( $content['source'] ) ) : ?>
                                            <div class="ergo-source-info">
                                                <span>Источник:</span>
                                                <?php if ( ! empty( $content['source_url'] ) ) : ?>
                                                    <a href="<?php echo esc_url( $content['source_url'] ); ?>" target="_blank" rel="noopener">
                                                        <?php echo esc_html( $content['source'] ); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <?php echo esc_html( $content['source'] ); ?>
                                                <?php endif; ?>
                                                <?php if ( ! empty( $content['last_updated'] ) ) : ?>
                                                    <span class="ergo-source-info__date">
                                                        (Обновлено: <?php echo esc_html( $content['last_updated'] ); ?>)
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                    <?php else : ?>
                                        <?php ergo_render_no_data( 'country' ); ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- Other tabs load via AJAX -->
                                    <div class="ergo-tab-loading">
                                        <div class="ergo-spinner"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <?php do_action( 'ergo_after_country_content', $country_code ); ?>

                    <?php else : ?>
                        <?php ergo_render_no_data( 'country' ); ?>
                    <?php endif; ?>
                </section>

                <!-- Related Countries -->
                <section class="ergo-related-countries">
                    <h2 class="ergo-section-title">Вам также может быть интересно</h2>
                    <div class="ergo-related-countries__grid">
                        <?php
                        $related = apply_filters( 'ergo_country_related', array(), $country_code, $region );
                        
                        // Default: get countries from same region
                        if ( empty( $related ) ) {
                            $all = ergo_get_countries();
                            foreach ( $all as $c ) {
                                if ( $c['region'] === $region && $c['code'] !== $country_code ) {
                                    $related[] = $c;
                                }
                                if ( count( $related ) >= 4 ) break;
                            }
                        }

                        foreach ( $related as $rc ) :
                        ?>
                            <a href="<?php echo esc_url( $rc['url'] ); ?>" class="ergo-related-card">
                                <span class="ergo-related-card__flag"><?php echo esc_html( $rc['flag'] ); ?></span>
                                <span class="ergo-related-card__name"><?php echo esc_html( $rc['name'] ); ?></span>
                                <span class="ergo-related-card__region"><?php echo esc_html( $rc['region'] ); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>

            </div><!-- .ergo-country-content -->

            <!-- Sticky Side Panel -->
            <aside class="ergo-country-panel" id="country-panel">
                <?php if ( ! empty( $tabs ) ) : ?>
                    <div class="ergo-panel-section">
                        <h4 class="ergo-panel-section__title">Основные показатели</h4>
                        <div class="ergo-panel-section__content" id="panel-quick-stats">
                            <!-- Filled by JS from active tab data -->
                            <p class="ergo-text-muted">Выберите тему данных для просмотра статистики</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="ergo-panel-section">
                    <h4 class="ergo-panel-section__title">Поделиться</h4>
                    <div class="ergo-share-buttons">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( $country_name ); ?>" target="_blank" rel="noopener" class="ergo-share-btn" title="Twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener" class="ergo-share-btn" title="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <button class="ergo-share-btn" id="copy-link-btn" title="<?php echo esc_attr( 'Копировать ссылку' ); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </button>
                    </div>
                </div>
            </aside>

        </div><!-- .ergo-country-layout -->
    </div>
</main>

<?php get_footer();
