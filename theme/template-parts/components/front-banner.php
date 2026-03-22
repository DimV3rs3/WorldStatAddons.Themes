<?php
/**
 * Баннер главной страницы (слайды из Customizer)
 *
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

$slides = ergo_get_banner_slides();
if ( empty( $slides ) ) {
    $slides = array( array(
        'image_url' => '',
        'title'     => get_bloginfo( 'name' ),
        'text'      => get_bloginfo( 'description' ) ?: 'Глобальная платформа для визуализации данных',
        'link'      => '',
    ) );
}
?>
<section class="ergo-front-banner" id="front-banner">
    <div class="ergo-front-banner__slider">
        <?php foreach ( $slides as $index => $slide ) : ?>
            <div class="ergo-front-banner__slide <?php echo $index === 0 ? 'is-active' : ''; ?>">
                <?php if ( ! empty( $slide['link'] ) ) : ?>
                    <a href="<?php echo esc_url( $slide['link'] ); ?>" class="ergo-front-banner__slide-inner">
                <?php else : ?>
                    <div class="ergo-front-banner__slide-inner">
                <?php endif; ?>
                    <?php if ( ! empty( $slide['image_url'] ) ) : ?>
                        <img class="ergo-front-banner__img" src="<?php echo esc_url( $slide['image_url'] ); ?>" alt="">
                    <?php else : ?>
                        <div class="ergo-front-banner__placeholder"></div>
                    <?php endif; ?>
                    <div class="ergo-front-banner__overlay">
                        <?php if ( ! empty( $slide['title'] ) ) : ?>
                            <h2 class="ergo-front-banner__title"><?php echo esc_html( $slide['title'] ); ?></h2>
                        <?php endif; ?>
                        <?php if ( ! empty( $slide['text'] ) ) : ?>
                            <p class="ergo-front-banner__text"><?php echo esc_html( $slide['text'] ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php if ( ! empty( $slide['link'] ) ) : ?>
                    </a>
                <?php else : ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ( count( $slides ) > 1 ) : ?>
        <div class="ergo-front-banner__dots">
            <?php foreach ( $slides as $i => $s ) : ?>
                <button type="button" class="ergo-front-banner__dot <?php echo $i === 0 ? 'is-active' : ''; ?>" data-index="<?php echo (int) $i; ?>" aria-label="Слайд <?php echo $i + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
