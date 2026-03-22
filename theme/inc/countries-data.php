<?php
/**
 * Countries Data - Built-in country information
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get all countries with basic data
 */
function ergo_get_countries() {
    $countries = get_transient( 'ergo_countries_list' );
    if ( false !== $countries ) {
        return $countries;
    }

    $args = array(
        'post_type'      => 'country',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );
    $query = new WP_Query( $args );
    $countries = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $id = get_the_ID();
            $code = get_post_meta( $id, 'country_code', true );
            $countries[ $code ] = array(
                'id'        => $id,
                'name'      => get_the_title(),
                'code'      => $code,
                'code3'     => get_post_meta( $id, 'country_code_3', true ),
                'capital'   => get_post_meta( $id, 'capital', true ),
                'flag'      => get_post_meta( $id, 'flag_emoji', true ),
                'lat'       => (float) get_post_meta( $id, 'latitude', true ),
                'lng'       => (float) get_post_meta( $id, 'longitude', true ),
                'region'    => ergo_get_country_region( $id ),
                'url'       => get_permalink( $id ),
                'has_data'  => ergo_country_has_data( $code ),
            );
        }
        wp_reset_postdata();
    }

    set_transient( 'ergo_countries_list', $countries, HOUR_IN_SECONDS );
    return $countries;
}

/**
 * Get country region
 */
function ergo_get_country_region( $post_id ) {
    $terms = get_the_terms( $post_id, 'region' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        return $terms[0]->name;
    }
    return '';
}

/**
 * Check if country has data from any plugin
 */
function ergo_country_has_data( $country_code ) {
    $tabs = apply_filters( 'ergo_country_data_tabs', array(), $country_code );
    return ! empty( $tabs );
}

/**
 * Get country by code
 */
function ergo_get_country_by_code( $code ) {
    $countries = ergo_get_countries();
    $code = strtoupper( $code );
    return isset( $countries[ $code ] ) ? $countries[ $code ] : null;
}

/**
 * Get total countries count
 */
function ergo_get_countries_count() {
    $count = wp_count_posts( 'country' );
    return isset( $count->publish ) ? (int) $count->publish : 0;
}

/**
 * Get countries grouped by region
 */
function ergo_get_countries_by_region() {
    $countries = ergo_get_countries();
    $grouped = array();

    foreach ( $countries as $country ) {
        $region = $country['region'] ?: 'Другое';
        if ( ! isset( $grouped[ $region ] ) ) {
            $grouped[ $region ] = array();
        }
        $grouped[ $region ][] = $country;
    }

    ksort( $grouped );
    return $grouped;
}

/**
 * Get countries with data count
 */
function ergo_get_countries_with_data_count() {
    $countries = ergo_get_countries();
    $count = 0;
    foreach ( $countries as $country ) {
        if ( $country['has_data'] ) {
            $count++;
        }
    }
    return $count;
}

/**
 * Clear countries cache on save
 */
function ergo_clear_countries_cache( $post_id ) {
    if ( get_post_type( $post_id ) === 'country' ) {
        delete_transient( 'ergo_countries_list' );
    }
}
add_action( 'save_post', 'ergo_clear_countries_cache' );
