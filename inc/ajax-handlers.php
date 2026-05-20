<?php
/**
 * AJAX Handlers
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get map data for a specific theme via AJAX
 */
function ergo_ajax_get_map_data() {
    check_ajax_referer( 'ergo_nonce', 'nonce' );

    $theme_id = isset( $_POST['theme_id'] ) ? sanitize_text_field( $_POST['theme_id'] ) : '';
    if ( empty( $theme_id ) ) {
        wp_send_json_error( array( 'message' => 'Theme ID required' ) );
    }

    $map_data = ergo_get_map_data( $theme_id );
    $legend   = ergo_get_map_legend( $theme_id );
    $theme    = ergo_get_data_theme( $theme_id );

    wp_send_json_success( array(
        'map_data' => $map_data,
        'legend'   => $legend,
        'theme'    => $theme,
    ) );
}
add_action( 'wp_ajax_ergo_get_map_data', 'ergo_ajax_get_map_data' );
add_action( 'wp_ajax_nopriv_ergo_get_map_data', 'ergo_ajax_get_map_data' );

/**
 * Get country tab content via AJAX
 */
function ergo_ajax_get_tab_content() {
    check_ajax_referer( 'ergo_nonce', 'nonce' );

    $country_code = isset( $_POST['country_code'] ) ? sanitize_text_field( $_POST['country_code'] ) : '';
    $tab_id       = isset( $_POST['tab_id'] ) ? sanitize_text_field( $_POST['tab_id'] ) : '';

    if ( empty( $country_code ) || empty( $tab_id ) ) {
        wp_send_json_error( array( 'message' => 'Country code and tab ID required' ) );
    }

    $tabs = ergo_get_country_tabs( $country_code );
    $target_tab = null;

    foreach ( $tabs as $tab ) {
        if ( isset( $tab['id'] ) && $tab['id'] === $tab_id ) {
            $target_tab = $tab;
            break;
        }
    }

    if ( ! $target_tab ) {
        wp_send_json_error( array( 'message' => 'Tab not found' ) );
    }

    $content = ergo_get_tab_content( $target_tab, $country_code );
    wp_send_json_success( array( 'content' => $content ) );
}
add_action( 'wp_ajax_ergo_get_tab_content', 'ergo_ajax_get_tab_content' );
add_action( 'wp_ajax_nopriv_ergo_get_tab_content', 'ergo_ajax_get_tab_content' );

/**
 * Filter countries via AJAX
 */
function ergo_ajax_filter_countries() {
    check_ajax_referer( 'ergo_nonce', 'nonce' );

    $region   = isset( $_POST['region'] ) ? sanitize_text_field( $_POST['region'] ) : '';
    $theme_id = isset( $_POST['theme_id'] ) ? sanitize_text_field( $_POST['theme_id'] ) : '';
    $search   = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
    $has_data = isset( $_POST['has_data'] ) ? sanitize_text_field( $_POST['has_data'] ) : '';
    $page     = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

    $countries = ergo_get_countries();
    $filtered = array();

    foreach ( $countries as $country ) {
        // Region filter
        if ( $region && $country['region'] !== $region ) continue;

        // Search filter
        if ( $search && stripos( $country['name'], $search ) === false && 
             stripos( $country['code'], $search ) === false ) continue;

        // Data availability filter
        if ( $has_data === 'with_data' && ! $country['has_data'] ) continue;
        if ( $has_data === 'without_data' && $country['has_data'] ) continue;

        // Theme-specific data filter
        if ( $theme_id ) {
            $tabs = ergo_get_country_tabs( $country['code'] );
            $has_theme = false;
            foreach ( $tabs as $tab ) {
                if ( isset( $tab['id'] ) && $tab['id'] === $theme_id ) {
                    $has_theme = true;
                    break;
                }
            }
            if ( ! $has_theme ) continue;
        }

        $filtered[] = $country;
    }

    // Pagination
    $per_page = 24;
    $total = count( $filtered );
    $pages = ceil( $total / $per_page );
    $offset = ( $page - 1 ) * $per_page;
    $paged = array_slice( $filtered, $offset, $per_page );

    wp_send_json_success( array(
        'countries'  => array_values( $paged ),
        'total'      => $total,
        'pages'      => $pages,
        'current'    => $page,
    ) );
}
add_action( 'wp_ajax_ergo_filter_countries', 'ergo_ajax_filter_countries' );
add_action( 'wp_ajax_nopriv_ergo_filter_countries', 'ergo_ajax_filter_countries' );

/**
 * Get comparison data via AJAX
 */
function ergo_ajax_compare_countries() {
    check_ajax_referer( 'ergo_nonce', 'nonce' );

    $codes    = isset( $_POST['countries'] ) ? array_map( 'sanitize_text_field', (array) $_POST['countries'] ) : array();
    $theme_id = isset( $_POST['theme_id'] ) ? sanitize_text_field( $_POST['theme_id'] ) : '';

    if ( empty( $codes ) || empty( $theme_id ) ) {
        wp_send_json_error( array( 'message' => 'Countries and theme required' ) );
    }

    $data = ergo_get_compare_data( $codes, $theme_id );
    wp_send_json_success( array( 'data' => $data ) );
}
add_action( 'wp_ajax_ergo_compare_countries', 'ergo_ajax_compare_countries' );
add_action( 'wp_ajax_nopriv_ergo_compare_countries', 'ergo_ajax_compare_countries' );

/**
 * Download data file
 */
function ergo_ajax_download_data() {
    $theme_id = isset( $_GET['theme'] ) ? sanitize_text_field( $_GET['theme'] ) : '';
    $file_id  = isset( $_GET['file'] ) ? sanitize_text_field( $_GET['file'] ) : '';
    $format   = isset( $_GET['format'] ) ? sanitize_text_field( $_GET['format'] ) : 'csv';

    if ( empty( $theme_id ) || empty( $file_id ) ) {
        wp_die( 'Invalid request' );
    }

    /**
     * Filter to let plugins handle file downloads
     * 
     * @param null   $handled   Return non-null to indicate handled
     * @param string $theme_id  Theme identifier
     * @param string $file_id   File identifier
     * @param string $format    Requested format
     */
    $handled = apply_filters( 'ergo_handle_download', null, $theme_id, $file_id, $format );

    if ( null === $handled ) {
        wp_die( 'File not found' );
    }
}
add_action( 'wp_ajax_ergo_download', 'ergo_ajax_download_data' );
add_action( 'wp_ajax_nopriv_ergo_download', 'ergo_ajax_download_data' );
