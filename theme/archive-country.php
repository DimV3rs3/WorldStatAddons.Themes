<?php
/**
 * Countries Archive Template
 * 
 * List of all countries with filtering and search.
 * 
 * @package Ergonosphera
 */

get_header();

$countries      = ergo_get_countries();
$total          = count( $countries );
$themes         = ergo_get_data_themes();
$with_data      = ergo_get_countries_with_data_count();
$regions        = array();
foreach ( $countries as $c ) {
    if ( $c['region'] && ! in_array( $c['region'], $regions, true ) ) {
        $regions[] = $c['region'];
    }
}
sort( $regions );

// Check for theme filter from URL
$active_theme_filter = isset( $_GET['theme'] ) ? sanitize_text_field( $_GET['theme'] ) : '';
?>

<main id="main-content" class="ergo-main ergo-countries-page">
    <div class="ergo-container">

        <!-- Page Header -->
        <div class="ergo-page-header">
            <h1 class="ergo-page-header__title"><?php echo esc_html( 'Все страны' ); ?></h1>
            <p class="ergo-page-header__subtitle">
                <?php printf( 'Исследуйте данные по %s странам мира', '<strong>' . esc_html( $total ) . '</strong>' ); ?>
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="ergo-stats-bar" id="countries-stats">
            <span class="ergo-stats-bar__item">
                <?php printf( 'Показано %1$s из %2$s стран', '<strong id="showing-count">' . esc_html( $total ) . '</strong>', esc_html( $total ) ); ?>
            </span>
            <span class="ergo-stats-bar__item">
                <?php printf( '%s доступных тем', '<strong>' . esc_html( count( $themes ) ) . '</strong>' ); ?>
            </span>
            <span class="ergo-stats-bar__item">
                <?php printf( '%s стран с данными', '<strong>' . esc_html( $with_data ) . '</strong>' ); ?>
            </span>
        </div>

        <!-- Filters -->
        <div class="ergo-filters" id="countries-filters">
            <div class="ergo-filters__row">
                <!-- Search -->
                <div class="ergo-filter-group">
                    <input type="text" id="country-search" class="ergo-input" 
                        placeholder="<?php echo esc_attr( 'Поиск по названию страны...' ); ?>">
                </div>

                <!-- Region filter -->
                <div class="ergo-filter-group">
                    <select id="filter-region" class="ergo-select">
                        <option value=""><?php echo esc_html( 'Все регионы' ); ?></option>
                        <?php foreach ( $regions as $r ) : ?>
                            <option value="<?php echo esc_attr( $r ); ?>"><?php echo esc_html( $r ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Data availability -->
                <div class="ergo-filter-group">
                    <select id="filter-data" class="ergo-select">
                        <option value=""><?php echo esc_html( 'Все страны' ); ?></option>
                        <option value="with_data"><?php echo esc_html( 'Страны с данными' ); ?></option>
                        <option value="without_data"><?php echo esc_html( 'Страны без данных' ); ?></option>
                    </select>
                </div>
            </div>

            <?php if ( ! empty( $themes ) ) : ?>
            <div class="ergo-filters__row ergo-filters__themes">
                <span class="ergo-filters__label"><?php echo esc_html( 'Фильтр по теме:' ); ?></span>
                <?php foreach ( $themes as $theme ) : ?>
                    <label class="ergo-checkbox-label">
                        <input type="checkbox" class="ergo-checkbox theme-filter" 
                            value="<?php echo esc_attr( $theme['id'] ); ?>"
                            <?php checked( $active_theme_filter, $theme['id'] ); ?>>
                        <span style="--theme-color: <?php echo esc_attr( $theme['color'] ?? '#6366f1' ); ?>">
                            <?php echo esc_html( $theme['name'] ); ?>
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Countries Grid -->
        <div class="ergo-countries-grid" id="countries-grid">
            <?php foreach ( $countries as $country ) : ?>
                <?php ergo_render_country_card( $country ); ?>
            <?php endforeach; ?>
        </div>

        <!-- Empty state -->
        <div class="ergo-countries-empty" id="countries-empty" hidden>
            <p><?php echo esc_html( 'Нет стран, соответствующих фильтрам.' ); ?></p>
            <button class="ergo-btn ergo-btn--outline" id="clear-filters">
                <?php echo esc_html( 'Сбросить фильтры' ); ?>
            </button>
        </div>

        <!-- Mini Map -->
        <section class="ergo-countries-minimap">
            <h2 class="ergo-section-title"><?php echo esc_html( 'Обзор карты мира' ); ?></h2>
            <div class="ergo-minimap-container" id="countries-minimap"></div>
            <div class="ergo-minimap-legend">
                <span class="ergo-minimap-legend__item ergo-minimap-legend__item--data">
                    <?php echo esc_html( 'Есть данные' ); ?>
                </span>
                <span class="ergo-minimap-legend__item ergo-minimap-legend__item--nodata">
                    <?php echo esc_html( 'Нет данных' ); ?>
                </span>
            </div>
        </section>

    </div>
</main>

<?php get_footer();
