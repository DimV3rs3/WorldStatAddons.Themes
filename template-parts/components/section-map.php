<?php
/**
 * Component: Map Section
 * 
 * Leaflet.js map with markers
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;

$map_id  = 'ergo-leaflet-' . $section_index . '-' . wp_rand( 1000, 9999 );
$markers = $section['markers'] ?? array();
$center  = $section['center'] ?? array( 20, 0 );
$zoom    = $section['zoom'] ?? 3;
?>
<div class="ergo-section ergo-section--map" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>

    <div class="ergo-leaflet-wrapper">
        <div id="<?php echo esc_attr( $map_id ); ?>" class="ergo-leaflet-map"
            data-center="<?php echo esc_attr( wp_json_encode( $center ) ); ?>"
            data-zoom="<?php echo esc_attr( $zoom ); ?>"
            data-markers="<?php echo esc_attr( wp_json_encode( $markers ) ); ?>">
        </div>
    </div>
</div>
