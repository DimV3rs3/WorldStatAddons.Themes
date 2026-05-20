<?php
/**
 * Template Name: Documentation
 * 
 * Developer documentation for creating data theme plugins.
 * 
 * @package Ergonosphera
 */

get_header();
?>

<main id="main-content" class="ergo-main ergo-docs-page">
    <div class="ergo-container">
        <div class="ergo-docs-layout">

            <!-- Sidebar Navigation -->
            <aside class="ergo-docs-sidebar">
                <nav class="ergo-docs-nav">
                    <h3><?php echo esc_html( 'Документация' ); ?></h3>
                    <ul>
                        <li><a href="#getting-started" class="is-active"><?php echo esc_html( 'Начало работы' ); ?></a></li>
                        <li><a href="#plugin-structure"><?php echo esc_html( 'Структура плагина' ); ?></a></li>
                        <li><a href="#hooks-reference"><?php echo esc_html( 'Хуки и фильтры' ); ?></a></li>
                        <li><a href="#data-format"><?php echo esc_html( 'Формат данных' ); ?></a></li>
                        <li><a href="#section-types"><?php echo esc_html( 'Типы секций' ); ?></a></li>
                        <li><a href="#map-integration"><?php echo esc_html( 'Интеграция карт' ); ?></a></li>
                        <li><a href="#downloads"><?php echo esc_html( 'API загрузок' ); ?></a></li>
                        <li><a href="#testing"><?php echo esc_html( 'Руководство по тестированию' ); ?></a></li>
                        <li><a href="#best-practices"><?php echo esc_html( 'Рекомендации' ); ?></a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Content -->
            <div class="ergo-docs-content">
                <div class="ergo-page-header">
                    <h1 class="ergo-page-header__title"><?php echo esc_html( 'Документация для разработчиков' ); ?></h1>
                    <p class="ergo-page-header__subtitle"><?php echo esc_html( 'Полное руководство по созданию плагинов тем данных для Ergonosphera' ); ?></p>
                </div>

                <!-- Getting Started -->
                <section id="getting-started" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Начало работы' ); ?></h2>
                    <p><?php echo esc_html( 'Плагины тем данных расширяют платформу Ergonosphera, предоставляя статистические данные по странам. Каждый плагин регистрируется через хуки WordPress и предоставляет данные в стандартизированном формате.' ); ?></p>
                    
                    <h3><?php echo esc_html( 'Быстрый старт' ); ?></h3>
                    <pre class="ergo-code"><code>&lt;?php
/**
 * Plugin Name: Ergonosphera - Automotive Data Theme
 * Description: Automotive industry data for Ergonosphera platform
 * Version: 1.0.0
 */

// Register the data theme
add_filter( 'ergo_data_themes', function( $themes ) {
    $themes[] = array(
        'id'          => 'automotive',
        'name'        => 'Automotive Industry',
        'description' => 'Global automotive production and market data',
        'icon'        => 'dashicons-car',
        'color'       => '#2196F3',
        'version'     => '1.0.0',
        'author'      => 'Your Name',
        'coverage'    => 120,
        'last_update' => '2024-02-10',
        'source'      => 'OICA',
    );
    return $themes;
});

// Register country data tabs
add_filter( 'ergo_country_data_tabs', function( $tabs, $country_code ) {
    $tabs[] = array(
        'id'       => 'automotive',
        'title'    => 'Automotive Industry',
        'icon'     => 'dashicons-car',
        'priority' => 10,
        'callback' => 'my_get_automotive_data',
    );
    return $tabs;
}, 10, 2 );

function my_get_automotive_data( $country_code ) {
    return array(
        'sections' => array(
            array(
                'title'   => 'Production Statistics',
                'type'    => 'text_with_stats',
                'content' => 'Overview of automotive production...',
                'stats'   => array(
                    array( 'label' => 'Total Production', 'value' => '1.8M', 'unit' => 'vehicles/year' ),
                ),
            ),
        ),
        'last_updated' => '2024-02-10',
        'source'       => 'OICA',
    );
}</code></pre>
                </section>

                <!-- Plugin Structure -->
                <section id="plugin-structure" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Структура плагина' ); ?></h2>
                    <pre class="ergo-code"><code>my-data-theme/
├── my-data-theme.php      # Основной файл плагина
├── includes/
│   ├── data-provider.php  # Логика получения данных
│   ├── map-data.php       # Данные для раскраски карты
│   └── downloads.php      # Загружаемые файлы
├── data/
│   ├── countries.json     # Данные по странам
│   └── exports/           # Предсгенерированные файлы
└── readme.txt</code></pre>
                </section>

                <!-- Hooks Reference -->
                <section id="hooks-reference" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Справочник хуков и фильтров' ); ?></h2>
                    
                    <div class="ergo-docs-table">
                        <table class="ergo-table">
                            <thead>
                                <tr>
                                    <th><?php echo esc_html( 'Хук' ); ?></th>
                                    <th><?php echo esc_html( 'Тип' ); ?></th>
                                    <th><?php echo esc_html( 'Описание' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><code>ergo_data_themes</code></td><td>Filter</td><td><?php echo esc_html( 'Регистрация темы данных' ); ?></td></tr>
                                <tr><td><code>ergo_country_data_tabs</code></td><td>Filter</td><td><?php echo esc_html( 'Добавление вкладок на страницы стран' ); ?></td></tr>
                                <tr><td><code>ergo_map_data</code></td><td>Filter</td><td><?php echo esc_html( 'Предоставление данных для раскраски карты' ); ?></td></tr>
                                <tr><td><code>ergo_map_legend</code></td><td>Filter</td><td><?php echo esc_html( 'Предоставление легенды карты' ); ?></td></tr>
                                <tr><td><code>ergo_theme_downloads</code></td><td>Filter</td><td><?php echo esc_html( 'Регистрация загружаемых файлов' ); ?></td></tr>
                                <tr><td><code>ergo_compare_data</code></td><td>Filter</td><td><?php echo esc_html( 'Предоставление данных для сравнения' ); ?></td></tr>
                                <tr><td><code>ergo_theme_coming_soon</code></td><td>Filter</td><td><?php echo esc_html( 'Регистрация предстоящих тем' ); ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Data Format -->
                <section id="data-format" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Формат данных' ); ?></h2>
                    <p><?php echo esc_html( 'Обратные вызовы плагинов возвращают данные в следующем стандартизированном формате:' ); ?></p>
                    <pre class="ergo-code"><code>array(
    'sections' => array(
        array(
            'title'      => 'Section Title',
            'type'       => 'text_with_stats', // или: chart, table, map, comparison, timeline
            'content'    => 'Text content...',
            'stats'      => array(
                array( 'label' => 'Label', 'value' => '123', 'unit' => 'unit' )
            ),
            'chart_type' => 'line',  // line, bar, pie, doughnut, area
            'data'       => array(), // Данные для Chart.js
            'headers'    => array(), // Заголовки таблицы
            'rows'       => array(), // Строки таблицы
            'markers'    => array(), // Маркеры карты
        ),
    ),
    'last_updated' => '2024-02-10',
    'source'       => 'Data Source Name',
    'source_url'   => 'https://example.com',
)</code></pre>
                </section>

                <!-- Section Types -->
                <section id="section-types" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Поддерживаемые типы секций' ); ?></h2>
                    <ul class="ergo-docs-list">
                        <li><code>text_with_stats</code> — <?php echo esc_html( 'Текстовый блок с выделенными карточками статистики' ); ?></li>
                        <li><code>chart</code> — <?php echo esc_html( 'Графики (линейные, столбчатые, круговые, кольцевые, площадные) через Chart.js' ); ?></li>
                        <li><code>table</code> — <?php echo esc_html( 'Сортируемые и поисковые таблицы через DataTables' ); ?></li>
                        <li><code>map</code> — <?php echo esc_html( 'Интерактивная карта Leaflet.js с маркерами' ); ?></li>
                        <li><code>comparison</code> — <?php echo esc_html( 'Графики и таблицы сравнения стран' ); ?></li>
                        <li><code>timeline</code> — <?php echo esc_html( 'Интерактивная временная шкала с событиями и данными' ); ?></li>
                        <li><code>text</code> — <?php echo esc_html( 'Простой текстовый блок' ); ?></li>
                    </ul>
                </section>

                <!-- Map Integration -->
                <section id="map-integration" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Интеграция карт' ); ?></h2>
                    <pre class="ergo-code"><code>// Предоставление данных для раскраски карты
add_filter( 'ergo_map_data', function( $data, $theme_id ) {
    if ( $theme_id !== 'my_theme' ) return $data;
    return array(
        'countries' => array(
            'DE' => array( 'value' => 1800000, 'color' => '#2196F3', 'label' => '1.8M' ),
            'JP' => array( 'value' => 2500000, 'color' => '#1565C0', 'label' => '2.5M' ),
        ),
    );
}, 10, 2 );

// Предоставление легенды
add_filter( 'ergo_map_legend', function( $legend, $theme_id ) {
    if ( $theme_id !== 'my_theme' ) return $legend;
    return array(
        'title'  => 'Vehicle Production',
        'unit'   => 'vehicles/year',
        'min'    => 0,
        'max'    => 5000000,
        'colors' => array( '#E3F2FD', '#90CAF9', '#42A5F5', '#1E88E5', '#1565C0' ),
        'labels' => array( '0', '100K', '1M', '2.5M', '5M+' ),
    );
}, 10, 2 );</code></pre>
                </section>

                <!-- Downloads -->
                <section id="downloads" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'API загрузок' ); ?></h2>
                    <pre class="ergo-code"><code>add_filter( 'ergo_theme_downloads', function( $downloads ) {
    $downloads[] = array(
        'theme_id'    => 'automotive',
        'theme_name'  => 'Automotive Industry',
        'description' => 'Global automotive production data',
        'files'       => array(
            array(
                'id'        => 'production_data',
                'name'      => 'Complete Production Data',
                'countries' => 195,
                'updated'   => '2024-02-10',
                'formats'   => array( 'csv', 'xlsx' ),
                'size'      => '2.5MB',
            ),
        ),
        'bulk_url' => plugin_dir_url( __FILE__ ) . 'exports/all-data.zip',
    );
    return $downloads;
});</code></pre>
                </section>

                <!-- Testing -->
                <section id="testing" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Руководство по тестированию' ); ?></h2>
                    <ol>
                        <li><?php echo esc_html( 'Активируйте тему Ergonosphera' ); ?></li>
                        <li><?php echo esc_html( 'Добавьте несколько стран через админку WordPress' ); ?></li>
                        <li><?php echo esc_html( 'Активируйте свой плагин' ); ?></li>
                        <li><?php echo esc_html( 'Проверьте главную страницу — ваша тема должна появиться в выпадающем списке' ); ?></li>
                        <li><?php echo esc_html( 'Откройте страницу страны и проверьте содержимое вкладки' ); ?></li>
                        <li><?php echo esc_html( 'Проверьте раскраску карты и отображение легенды' ); ?></li>
                        <li><?php echo esc_html( 'Проверьте загрузку данных' ); ?></li>
                    </ol>
                </section>

                <!-- Best Practices -->
                <section id="best-practices" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Рекомендации' ); ?></h2>
                    <ul class="ergo-docs-list">
                        <li><?php echo esc_html( 'Кэшируйте данные с помощью WordPress transients для лучшей производительности' ); ?></li>
                        <li><?php echo esc_html( 'Используйте коды стран ISO 3166-1 alpha-2 последовательно' ); ?></li>
                        <li><?php echo esc_html( 'Предоставляйте осмысленные состояния при отсутствии данных' ); ?></li>
                        <li><?php echo esc_html( 'Указывайте источник данных' ); ?></li>
                        <li><?php echo esc_html( 'Держите наборы данных небольшими; подгружайте детальные данные через AJAX' ); ?></li>
                        <li><?php echo esc_html( 'Следуйте стандартам кодирования WordPress' ); ?></li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</main>

<?php get_footer();
