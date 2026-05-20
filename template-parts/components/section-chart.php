<?php
/**
 * Component: Chart Section
 * 
 * Renders charts using Chart.js
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;

$chart_id   = 'ergo-chart-' . $section_index . '-' . wp_rand( 1000, 9999 );
$chart_type = $section['chart_type'] ?? 'bar';
$chart_data = $section['data'] ?? array();
?>
<div class="ergo-section ergo-section--chart" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>

    <div class="ergo-chart-wrapper">
        <canvas id="<?php echo esc_attr( $chart_id ); ?>" class="ergo-chart"
            data-chart-type="<?php echo esc_attr( $chart_type ); ?>"
            data-chart-data="<?php echo esc_attr( wp_json_encode( $chart_data ) ); ?>">
        </canvas>
    </div>

    <div class="ergo-chart-actions">
        <button class="ergo-btn ergo-btn--sm ergo-btn--ghost ergo-chart-download" data-chart="<?php echo esc_attr( $chart_id ); ?>">
            Скачать PNG
        </button>
    </div>
</div>
