<?php
/**
 * Component: Text Section
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="ergo-section ergo-section--text" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>
    <?php if ( ! empty( $section['content'] ) ) : ?>
        <div class="ergo-section__content">
            <?php echo wp_kses_post( $section['content'] ); ?>
        </div>
    <?php endif; ?>
</div>
