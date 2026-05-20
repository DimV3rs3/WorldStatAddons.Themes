<?php
/**
 * Archive: Учёные (ergo_scientist)
 *
 * @package Ergonosphera
 */

get_header();
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-scientists">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Учёные</h1>
            <p class="ergo-page-header__subtitle">Исследователи в области глобалистики и смежных дисциплин</p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ergo-scientists-grid">
                <?php while ( have_posts() ) : the_post();
                    $position = get_post_meta( get_the_ID(), 'scientist_position', true );
                    $org      = get_post_meta( get_the_ID(), 'scientist_organization', true );
                    $field    = get_post_meta( get_the_ID(), 'scientist_field', true );
                ?>
                    <article class="ergo-scientist-card">
                        <a href="<?php the_permalink(); ?>" class="ergo-scientist-card__link">
                            <div class="ergo-scientist-card__photo">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                <?php else : ?>
                                    <span class="ergo-scientist-card__placeholder dashicons dashicons-admin-users"></span>
                                <?php endif; ?>
                            </div>
                            <div class="ergo-scientist-card__body">
                                <h2 class="ergo-scientist-card__name"><?php the_title(); ?></h2>
                                <?php if ( $position ) : ?>
                                    <p class="ergo-scientist-card__position"><?php echo esc_html( $position ); ?></p>
                                <?php endif; ?>
                                <?php if ( $org ) : ?>
                                    <p class="ergo-scientist-card__org"><?php echo esc_html( $org ); ?></p>
                                <?php endif; ?>
                                <?php if ( $field ) : ?>
                                    <p class="ergo-scientist-card__field"><?php echo esc_html( $field ); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '&larr; Назад', 'next_text' => 'Вперёд &rarr;' ) ); ?>
        <?php else : ?>
            <p>Пока нет учёных в каталоге.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
