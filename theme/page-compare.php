<?php
/**
 * Template Name: Compare Countries
 * 
 * Compare data for 2-4 countries side by side.
 * 
 * @package Ergonosphera
 */

get_header();

$themes    = ergo_get_data_themes();
$countries = ergo_get_countries();

// Get pre-selected countries from URL
$selected = isset( $_GET['countries'] ) ? array_map( 'sanitize_text_field', explode( ',', $_GET['countries'] ) ) : array();
$selected_theme = isset( $_GET['theme'] ) ? sanitize_text_field( $_GET['theme'] ) : '';
?>

<main id="main-content" class="ergo-main ergo-compare-page">
    <div class="ergo-container">

        <div class="ergo-page-header">
            <h1 class="ergo-page-header__title"><?php echo esc_html( 'Сравнение стран' ); ?></h1>
            <p class="ergo-page-header__subtitle"><?php echo esc_html( 'Выберите 2–4 страны и тему данных для сравнения' ); ?></p>
        </div>

        <!-- Selection Controls -->
        <div class="ergo-compare-controls" id="compare-controls">
            <div class="ergo-compare-controls__countries">
                <label><?php echo esc_html( 'Страны (2–4):' ); ?></label>
                <div class="ergo-compare-selectors" id="country-selectors">
                    <?php for ( $i = 0; $i < 4; $i++ ) : ?>
                        <select class="ergo-select country-select" data-index="<?php echo $i; ?>">
                            <option value=""><?php printf( 'Страна %d', $i + 1 ); ?></option>
                            <?php foreach ( $countries as $c ) : ?>
                                <option value="<?php echo esc_attr( $c['code'] ); ?>" 
                                    <?php selected( isset( $selected[ $i ] ) ? strtoupper( $selected[ $i ] ) : '', $c['code'] ); ?>>
                                    <?php echo esc_html( $c['flag'] . ' ' . $c['name'] ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="ergo-compare-controls__theme">
                <label for="compare-theme"><?php echo esc_html( 'Тема данных:' ); ?></label>
                <select id="compare-theme" class="ergo-select">
                    <option value=""><?php echo esc_html( '— Выберите тему —' ); ?></option>
                    <?php foreach ( $themes as $theme ) : ?>
                        <option value="<?php echo esc_attr( $theme['id'] ); ?>"
                            <?php selected( $selected_theme, $theme['id'] ); ?>>
                            <?php echo esc_html( $theme['name'] ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button id="compare-btn" class="ergo-btn ergo-btn--primary ergo-btn--lg" disabled>
                <?php echo esc_html( 'Сравнить' ); ?>
            </button>
        </div>

        <!-- Results -->
        <div class="ergo-compare-results" id="compare-results" hidden>
            <div class="ergo-compare-loading" id="compare-loading" hidden>
                <div class="ergo-spinner"></div>
                <p><?php echo esc_html( 'Загрузка данных для сравнения...' ); ?></p>
            </div>

            <!-- Basic Info Comparison -->
            <section class="ergo-compare-section" id="compare-basic">
                <h2><?php echo esc_html( 'Основная информация' ); ?></h2>
                <div class="ergo-table-responsive">
                    <table class="ergo-table ergo-compare-table" id="basic-compare-table">
                        <!-- Filled via JS -->
                    </table>
                </div>
            </section>

            <!-- Charts -->
            <section class="ergo-compare-section" id="compare-charts">
                <h2><?php echo esc_html( 'Сравнительные графики' ); ?></h2>
                <div class="ergo-compare-charts-grid" id="charts-container">
                    <!-- Charts rendered via JS -->
                </div>
            </section>

            <!-- Detailed Table -->
            <section class="ergo-compare-section" id="compare-detailed">
                <h2><?php echo esc_html( 'Детальное сравнение' ); ?></h2>
                <div class="ergo-table-responsive">
                    <table class="ergo-table" id="detailed-compare-table">
                        <!-- Filled via JS -->
                    </table>
                </div>
            </section>

            <!-- Export -->
            <div class="ergo-compare-export">
                <button class="ergo-btn ergo-btn--outline" id="export-comparison-csv">
                    <?php echo esc_html( 'Экспорт CSV' ); ?>
                </button>
                <button class="ergo-btn ergo-btn--outline" id="export-comparison-png">
                    <?php echo esc_html( 'Экспорт графика (PNG)' ); ?>
                </button>
            </div>
        </div>

        <!-- Empty state -->
        <div class="ergo-compare-empty" id="compare-empty">
            <p><?php echo esc_html( 'Выберите как минимум 2 страны и тему данных, затем нажмите «Сравнить».' ); ?></p>
            <?php if ( empty( $themes ) ) : ?>
                <p class="ergo-text-muted"><?php echo esc_html( 'Нет установленных тем данных. Установите плагины для включения сравнения.' ); ?></p>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php get_footer();
