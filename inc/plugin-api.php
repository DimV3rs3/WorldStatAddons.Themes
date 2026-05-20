<?php
/**
 * Plugin API - Interface for data theme plugins
 * 
 * This file defines the hooks and API that plugins use to register
 * their data themes and provide data to the platform.
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * =============================================================
 * PLUGIN API HOOKS REFERENCE
 * =============================================================
 * 
 * Filters:
 * - ergo_data_themes              : Register a data theme plugin
 * - ergo_country_data_tabs        : Register tabs for country page
 * - ergo_map_data                 : Provide map coloring data
 * - ergo_map_legend               : Provide map legend data
 * - ergo_theme_downloads          : Provide downloadable datasets
 * - ergo_theme_coming_soon        : Register coming soon themes
 * - ergo_compare_data             : Provide comparison data
 * - ergo_country_related          : Filter related countries
 * 
 * Actions:
 * - ergo_before_country_content   : Before country data content
 * - ergo_after_country_content    : After country data content
 * - ergo_theme_card_extra         : Extra content in theme card
 * =============================================================
 */

/**
 * Get all registered data themes (active plugins)
 * 
 * Plugins register themselves via the 'ergo_data_themes' filter:
 * 
 * add_filter( 'ergo_data_themes', function( $themes ) {
 *     $themes[] = array(
 *         'id'          => 'automotive',
 *         'name'        => 'Automotive Industry',
 *         'description' => 'Global automotive production and market data',
 *         'icon'        => 'dashicons-car',
 *         'color'       => '#2196F3',
 *         'version'     => '1.0.0',
 *         'author'      => 'Plugin Author',
 *         'coverage'    => 120,
 *         'last_update' => '2024-02-10',
 *         'source'      => 'International Organization of Motor Vehicle Manufacturers',
 *     );
 *     return $themes;
 * });
 * 
 * @return array
 */
function ergo_get_data_themes() {
    $themes = apply_filters( 'ergo_data_themes', array() );
    return is_array( $themes ) ? $themes : array();
}

/**
 * Get active data themes count
 */
function ergo_get_active_themes_count() {
    return count( ergo_get_data_themes() );
}

/**
 * Get a specific data theme by ID
 */
function ergo_get_data_theme( $theme_id ) {
    $themes = ergo_get_data_themes();
    foreach ( $themes as $theme ) {
        if ( isset( $theme['id'] ) && $theme['id'] === $theme_id ) {
            return $theme;
        }
    }
    return null;
}

/**
 * Get country data tabs from plugins
 * 
 * Plugins register tabs via the 'ergo_country_data_tabs' filter:
 * 
 * add_filter( 'ergo_country_data_tabs', function( $tabs, $country_code ) {
 *     $tabs[] = array(
 *         'id'       => 'automotive',
 *         'title'    => 'Automotive Industry',
 *         'icon'     => 'dashicons-car',
 *         'priority' => 10,
 *         'callback' => 'my_plugin_get_automotive_data',
 *     );
 *     return $tabs;
 * }, 10, 2 );
 * 
 * @param string $country_code ISO country code
 * @return array
 */
function ergo_get_country_tabs( $country_code ) {
    $tabs = apply_filters( 'ergo_country_data_tabs', array(), strtoupper( $country_code ) );
    if ( ! is_array( $tabs ) ) return array();

    // Sort by priority
    usort( $tabs, function( $a, $b ) {
        $pa = isset( $a['priority'] ) ? $a['priority'] : 10;
        $pb = isset( $b['priority'] ) ? $b['priority'] : 10;
        return $pa - $pb;
    });

    return $tabs;
}

/**
 * Get tab content (sections data) from plugin callback
 * 
 * Plugin callback should return:
 * array(
 *     'sections' => array(
 *         array(
 *             'title'      => 'Section Title',
 *             'type'       => 'text_with_stats|chart|table|map|comparison|timeline',
 *             'content'    => 'Text content...',
 *             'stats'      => array( array( 'label' => '', 'value' => '', 'unit' => '' ) ),
 *             'chart_type' => 'line|bar|pie|doughnut|area',
 *             'data'       => array(),
 *             'headers'    => array(),
 *             'rows'       => array(),
 *             'markers'    => array(),
 *         ),
 *     ),
 *     'last_updated' => '2024-02-10',
 *     'source'       => 'Data source name',
 *     'source_url'   => 'https://...',
 * )
 * 
 * @param array  $tab          Tab configuration
 * @param string $country_code ISO country code
 * @return array|null
 */
function ergo_get_tab_content( $tab, $country_code ) {
    if ( ! isset( $tab['callback'] ) || ! is_callable( $tab['callback'] ) ) {
        return null;
    }
    $data = call_user_func( $tab['callback'], strtoupper( $country_code ) );
    return is_array( $data ) ? $data : null;
}

/**
 * Get map coloring data from a specific theme
 * 
 * Plugin provides via 'ergo_map_data' filter:
 * 
 * add_filter( 'ergo_map_data', function( $data, $theme_id ) {
 *     if ( $theme_id !== 'automotive' ) return $data;
 *     return array(
 *         'countries' => array(
 *             'DE' => array( 'value' => 1800000, 'color' => '#2196F3', 'label' => '1.8M vehicles' ),
 *             'JP' => array( 'value' => 2500000, 'color' => '#1565C0', 'label' => '2.5M vehicles' ),
 *         ),
 *     );
 * }, 10, 2 );
 * 
 * @param string $theme_id
 * @return array
 */
function ergo_get_map_data( $theme_id ) {
    $data = apply_filters( 'ergo_map_data', array(), $theme_id );
    return is_array( $data ) ? $data : array();
}

/**
 * Get map legend from a specific theme
 * 
 * Plugin provides via 'ergo_map_legend' filter:
 * 
 * add_filter( 'ergo_map_legend', function( $legend, $theme_id ) {
 *     if ( $theme_id !== 'automotive' ) return $legend;
 *     return array(
 *         'title'  => 'Vehicle Production',
 *         'unit'   => 'vehicles/year',
 *         'min'    => 0,
 *         'max'    => 5000000,
 *         'colors' => array( '#E3F2FD', '#90CAF9', '#42A5F5', '#1E88E5', '#1565C0', '#0D47A1' ),
 *         'labels' => array( '0', '100K', '500K', '1M', '2M', '5M+' ),
 *     );
 * }, 10, 2 );
 * 
 * @param string $theme_id
 * @return array
 */
function ergo_get_map_legend( $theme_id ) {
    $legend = apply_filters( 'ergo_map_legend', array(), $theme_id );
    return is_array( $legend ) ? $legend : array();
}

/**
 * Get downloadable datasets from plugins
 * 
 * @return array
 */
function ergo_get_all_downloads() {
    $downloads = apply_filters( 'ergo_theme_downloads', array() );
    return is_array( $downloads ) ? $downloads : array();
}

/**
 * Get coming soon themes
 */
function ergo_get_coming_soon_themes() {
    $themes = apply_filters( 'ergo_theme_coming_soon', array() );
    return is_array( $themes ) ? $themes : array();
}

/**
 * Get comparison data for countries
 * 
 * @param array  $country_codes Array of country codes
 * @param string $theme_id      Data theme ID
 * @return array
 */
function ergo_get_compare_data( $country_codes, $theme_id ) {
    $data = apply_filters( 'ergo_compare_data', array(), $country_codes, $theme_id );
    return is_array( $data ) ? $data : array();
}

/**
 * Get last data update date across all themes
 */
function ergo_get_last_update_date() {
    $themes = ergo_get_data_themes();
    $latest = '';
    foreach ( $themes as $theme ) {
        if ( isset( $theme['last_update'] ) && $theme['last_update'] > $latest ) {
            $latest = $theme['last_update'];
        }
    }
    return $latest ?: gmdate( 'Y-m-d' );
}
