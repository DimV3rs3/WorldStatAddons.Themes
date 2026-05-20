<?php
/**
 * Enqueue scripts and styles
 * 
 * Все ресурсы загружаются локально, без внешних CDN.
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue front-end styles and scripts
 */
function ergo_enqueue_assets() {
    // ==== Стили ====
    // Иконки Dashicons на фронте (карточки, вкладки, темы — классы dashicons-* в разметке темы).
    wp_enqueue_style( 'dashicons' );

    // Локальные шрифты (без Google Fonts CDN)
    wp_enqueue_style( 'ergo-fonts', ERGO_URI . '/assets/css/fonts.css', array(), ERGO_VERSION );

    // Основной CSS темы
    wp_enqueue_style( 'ergo-main', ERGO_URI . '/assets/css/main.css', array(), ERGO_VERSION );

    // ==== Скрипты ====

    $needs_map   = is_front_page() || is_singular( 'country' ) || is_page_template( 'page-compare.php' ) || is_page_template( 'page-status.php' );
    $needs_chart = is_singular( 'country' ) || is_page_template( 'page-compare.php' );

    $main_deps = array( 'jquery' );

    if ( $needs_map ) {
        wp_enqueue_style( 'leaflet', ERGO_URI . '/assets/vendor/leaflet/leaflet.css', array(), '1.9.4' );
        wp_enqueue_script( 'leaflet', ERGO_URI . '/assets/vendor/leaflet/leaflet.js', array(), '1.9.4', true );
        wp_enqueue_script( 'topojson-client', ERGO_URI . '/assets/vendor/topojson/topojson-client.min.js', array(), '3.1.0', true );
        wp_enqueue_script( 'ergo-svg-map', ERGO_URI . '/assets/js/svg-map.js', array( 'leaflet', 'topojson-client' ), ERGO_VERSION, true );
        $main_deps[] = 'ergo-svg-map';
    }

    if ( $needs_chart ) {
        wp_enqueue_script( 'chartjs', ERGO_URI . '/assets/vendor/chartjs/chart.umd.min.js', array(), '4.4.1', true );
        wp_enqueue_script( 'ergo-components', ERGO_URI . '/assets/js/components.js', array( 'chartjs' ), ERGO_VERSION, true );
        $main_deps[] = 'ergo-components';
    }

    if ( is_singular( 'country' ) || is_page_template( 'page-compare.php' ) ) {
        wp_enqueue_style( 'datatables', ERGO_URI . '/assets/vendor/datatables/jquery.dataTables.min.css', array(), '1.13.7' );
        wp_enqueue_script( 'datatables', ERGO_URI . '/assets/vendor/datatables/dataTables.min.js', array( 'jquery' ), '1.13.7', true );
    }

    wp_enqueue_script( 'ergo-main', ERGO_URI . '/assets/js/main.js', $main_deps, ERGO_VERSION, true );

    // Локализация — передаём данные в JavaScript
    wp_localize_script( 'ergo-main', 'ergoData', array(
        'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
        'restUrl'      => rest_url( 'ergonosphera/v1/' ),
        'nonce'        => wp_create_nonce( 'ergo_nonce' ),
        'themeUrl'     => ERGO_URI,
        'homeUrl'      => home_url( '/' ),
        'isHome'       => is_front_page(),
        'currentPage'  => get_query_var( 'pagename' ),
        'strings'      => array(
            'loading'      => 'Загрузка...',
            'noData'       => 'Данные отсутствуют',
            'error'        => 'Произошла ошибка',
            'countries'    => 'стран',
            'themes'       => 'тем',
            'noDataAvail'  => 'Нет данных',
            'source'       => 'Источник:',
            'downloadCSV'  => 'Скачать CSV',
            'downloadXLSX' => 'Скачать XLSX',
            'downloadJSON' => 'Скачать JSON',
            'downloadPNG'  => 'Скачать PNG',
            'exportCSV'    => 'Экспорт CSV',
            'copied'       => 'Скопировано!',
            'copyLink'     => 'Копировать ссылку',
            'compare'      => 'Сравнить',
            'selectTheme'  => 'Выберите тему',
        ),
    ) );

    // Страница страны
    if ( is_singular( 'country' ) ) {
        wp_enqueue_script( 'ergo-country', ERGO_URI . '/assets/js/country-page.js', array( 'ergo-main', 'chartjs', 'leaflet' ), ERGO_VERSION, true );
    }

    // Страница сравнения
    if ( is_page_template( 'page-compare.php' ) ) {
        wp_enqueue_script( 'ergo-compare', ERGO_URI . '/assets/js/compare.js', array( 'ergo-main', 'chartjs' ), ERGO_VERSION, true );
    }
}
add_action( 'wp_enqueue_scripts', 'ergo_enqueue_assets' );

/**
 * Исправить путь к маркерам Leaflet (локальный, только если Leaflet подключён)
 */
function ergo_leaflet_marker_path() {
    if ( ! wp_script_is( 'leaflet', 'enqueued' ) ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof L !== 'undefined' && L.Icon && L.Icon.Default) {
            L.Icon.Default.imagePath = '<?php echo esc_js( ERGO_URI . '/assets/vendor/leaflet/images/' ); ?>';
        }
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'ergo_leaflet_marker_path', 5 );
