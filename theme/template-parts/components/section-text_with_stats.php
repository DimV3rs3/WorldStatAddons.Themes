<?php
/**
 * Component: Text with Statistics
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="ergo-section ergo-section--text-stats" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>

    <?php if ( ! empty( $section['stats'] ) ) : ?>
        <div class="ergo-stats-cards">
            <?php foreach ( $section['stats'] as $stat ) : ?>
                <div class="ergo-stat-card">
                    <div class="ergo-stat-card__value"><?php echo esc_html( $stat['value'] ); ?></div>
                    <div class="ergo-stat-card__label"><?php echo esc_html( $stat['label'] ); ?></div>
                    <?php if ( ! empty( $stat['unit'] ) ) : ?>
                        <div class="ergo-stat-card__unit"><?php echo esc_html( $stat['unit'] ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $section['content'] ) ) : ?>
        <div class="ergo-section__content">
            <?php echo wp_kses_post( $section['content'] ); ?>
        </div>
    <?php endif; ?>
</div>
