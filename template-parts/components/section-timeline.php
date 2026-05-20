<?php
/**
 * Component: Timeline Section
 * 
 * Interactive timeline with events/data
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;

$events = $section['events'] ?? array();
?>
<div class="ergo-section ergo-section--timeline" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>

    <?php if ( ! empty( $section['slider'] ) ) : ?>
        <div class="ergo-timeline-slider">
            <input type="range" class="ergo-range" 
                min="<?php echo esc_attr( $section['slider']['min'] ?? 1990 ); ?>" 
                max="<?php echo esc_attr( $section['slider']['max'] ?? 2024 ); ?>" 
                value="<?php echo esc_attr( $section['slider']['value'] ?? 2024 ); ?>"
                id="timeline-slider-<?php echo esc_attr( $section_index ); ?>">
            <div class="ergo-timeline-slider__labels">
                <span><?php echo esc_html( $section['slider']['min'] ?? 1990 ); ?></span>
                <span class="ergo-timeline-slider__current" id="timeline-value-<?php echo esc_attr( $section_index ); ?>">
                    <?php echo esc_html( $section['slider']['value'] ?? 2024 ); ?>
                </span>
                <span><?php echo esc_html( $section['slider']['max'] ?? 2024 ); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $events ) ) : ?>
        <div class="ergo-timeline">
            <?php foreach ( $events as $event ) : ?>
                <div class="ergo-timeline__item">
                    <div class="ergo-timeline__marker"></div>
                    <div class="ergo-timeline__content">
                        <span class="ergo-timeline__date"><?php echo esc_html( $event['date'] ?? '' ); ?></span>
                        <h4 class="ergo-timeline__title"><?php echo esc_html( $event['title'] ?? '' ); ?></h4>
                        <?php if ( ! empty( $event['description'] ) ) : ?>
                            <p class="ergo-timeline__desc"><?php echo esc_html( $event['description'] ); ?></p>
                        <?php endif; ?>
                        <?php if ( ! empty( $event['value'] ) ) : ?>
                            <span class="ergo-timeline__value"><?php echo esc_html( $event['value'] ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
