<?php
/**
 * REST API Endpoints
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register REST API routes
 */
function ergo_register_rest_routes() {
    $namespace = 'ergonosphera/v1';

    // Get all countries
    register_rest_route( $namespace, '/countries', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_get_countries',
        'permission_callback' => '__return_true',
    ) );

    // Get single country
    register_rest_route( $namespace, '/country/(?P<code>[a-zA-Z]{2,3})', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_get_country',
        'permission_callback' => '__return_true',
        'args' => array(
            'code' => array(
                'validate_callback' => function( $param ) {
                    return preg_match( '/^[a-zA-Z]{2,3}$/', $param );
                },
            ),
        ),
    ) );

    // Get data themes
    register_rest_route( $namespace, '/themes', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_get_themes',
        'permission_callback' => '__return_true',
    ) );

    // Get theme data for country
    register_rest_route( $namespace, '/(?P<theme>[a-z0-9_-]+)/country/(?P<code>[a-zA-Z]{2,3})', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_get_theme_country_data',
        'permission_callback' => '__return_true',
    ) );

    // Get map data
    register_rest_route( $namespace, '/map/(?P<theme>[a-z0-9_-]+)', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_get_map_data',
        'permission_callback' => '__return_true',
    ) );

    // Compare countries
    register_rest_route( $namespace, '/compare', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_compare_countries',
        'permission_callback' => '__return_true',
        'args' => array(
            'countries' => array( 'required' => true ),
            'theme'     => array( 'required' => true ),
        ),
    ) );

    // Platform status
    register_rest_route( $namespace, '/status', array(
        'methods'             => 'GET',
        'callback'            => 'ergo_rest_get_status',
        'permission_callback' => '__return_true',
    ) );
}
add_action( 'rest_api_init', 'ergo_register_rest_routes' );

/**
 * REST: Get all countries
 */
function ergo_rest_get_countries( $request ) {
    $countries = ergo_get_countries();
    return rest_ensure_response( array_values( $countries ) );
}

/**
 * REST: Get single country
 */
function ergo_rest_get_country( $request ) {
    $code = strtoupper( $request['code'] );
    $country = ergo_get_country_by_code( $code );

    if ( ! $country ) {
        return new WP_Error( 'not_found', 'Country not found', array( 'status' => 404 ) );
    }

    // Add data tabs info
    $tabs = ergo_get_country_tabs( $code );
    $country['available_themes'] = array_map( function( $tab ) {
        return array(
            'id'    => $tab['id'],
            'title' => $tab['title'],
        );
    }, $tabs );

    return rest_ensure_response( $country );
}

/**
 * REST: Get data themes
 */
function ergo_rest_get_themes( $request ) {
    return rest_ensure_response( ergo_get_data_themes() );
}

/**
 * REST: Get theme data for country
 */
function ergo_rest_get_theme_country_data( $request ) {
    $theme_id     = $request['theme'];
    $country_code = strtoupper( $request['code'] );

    $tabs = ergo_get_country_tabs( $country_code );
    $target_tab = null;

    foreach ( $tabs as $tab ) {
        if ( $tab['id'] === $theme_id ) {
            $target_tab = $tab;
            break;
        }
    }

    if ( ! $target_tab ) {
        return new WP_Error( 'not_found', 'No data for this theme/country', array( 'status' => 404 ) );
    }

    $content = ergo_get_tab_content( $target_tab, $country_code );
    return rest_ensure_response( $content );
}

/**
 * REST: Get map data
 */
function ergo_rest_get_map_data( $request ) {
    $theme_id = $request['theme'];
    $data     = ergo_get_map_data( $theme_id );
    $legend   = ergo_get_map_legend( $theme_id );

    return rest_ensure_response( array(
        'data'   => $data,
        'legend' => $legend,
    ) );
}

/**
 * REST: Compare countries
 */
function ergo_rest_compare_countries( $request ) {
    $codes    = explode( ',', $request->get_param( 'countries' ) );
    $theme_id = $request->get_param( 'theme' );

    $codes = array_map( 'strtoupper', array_map( 'trim', $codes ) );
    $data  = ergo_get_compare_data( $codes, $theme_id );

    return rest_ensure_response( $data );
}

/**
 * REST: Platform status
 */
function ergo_rest_get_status( $request ) {
    return rest_ensure_response( array(
        'platform'          => 'Ergonosphera',
        'version'           => ERGO_VERSION,
        'active_themes'     => ergo_get_active_themes_count(),
        'total_countries'   => ergo_get_countries_count(),
        'countries_with_data' => ergo_get_countries_with_data_count(),
        'last_update'       => ergo_get_last_update_date(),
        'themes'            => array_map( function( $t ) {
            return array( 'id' => $t['id'], 'name' => $t['name'], 'version' => $t['version'] ?? '1.0' );
        }, ergo_get_data_themes() ),
        'status'            => 'operational',
        'uptime'            => '99.9%',
        'timestamp'         => gmdate( 'c' ),
    ) );
}
