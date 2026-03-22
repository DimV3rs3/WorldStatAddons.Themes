<?php
/**
 * Component: Comparison Section
 * 
 * Compare current country with others
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;

$comparison_data = $section['data'] ?? array();
$chart_type      = $section['chart_type'] ?? 'bar';
$compare_id      = 'ergo-compare-' . $section_index . '-' . wp_rand( 1000, 9999 );
?>
<div class="ergo-section ergo-section--comparison" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>

    <div class="ergo-comparison-chart">
        <canvas id="<?php echo esc_attr( $compare_id ); ?>" class="ergo-chart"
            data-chart-type="<?php echo esc_attr( $chart_type ); ?>"
            data-chart-data="<?php echo esc_attr( wp_json_encode( $comparison_data ) ); ?>">
        </canvas>
    </div>

    <?php if ( ! empty( $section['table_data'] ) ) : ?>
        <div class="ergo-table-responsive">
            <table class="ergo-table">
                <?php if ( ! empty( $section['table_data']['headers'] ) ) : ?>
                    <thead>
                        <tr>
                            <?php foreach ( $section['table_data']['headers'] as $h ) : ?>
                                <th><?php echo esc_html( $h ); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                <?php endif; ?>
                <tbody>
                    <?php foreach ( ( $section['table_data']['rows'] ?? array() ) as $row ) : ?>
                        <tr>
                            <?php foreach ( (array) $row as $cell ) : ?>
                                <td><?php echo esc_html( $cell ); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
