<?php
/**
 * Archive: Семинары (ergo_seminar)
 *
 * @package Ergonosphera
 */

get_header();
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-seminars">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Семинары</h1>
            <p class="ergo-page-header__subtitle">Научные и студенческие семинары</p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ergo-cards-grid">
                <?php while ( have_posts() ) : the_post();
                    $date    = get_post_meta( get_the_ID(), 'seminar_date', true );
                    $place   = get_post_meta( get_the_ID(), 'seminar_place', true );
                    $speaker = get_post_meta( get_the_ID(), 'seminar_speaker', true );
                ?>
                    <article class="ergo-card-item">
                        <a href="<?php the_permalink(); ?>" class="ergo-card-item__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-card-item__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php endif; ?>
                            <div class="ergo-card-item__body">
                                <h2 class="ergo-card-item__title"><?php the_title(); ?></h2>
                                <?php if ( $date || $place ) : ?>
                                    <p class="ergo-card-item__meta">
                                        <?php if ( $date ) echo esc_html( $date ); ?>
                                        <?php if ( $date && $place ) echo ' &bull; '; ?>
                                        <?php if ( $place ) echo esc_html( $place ); ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ( $speaker ) : ?>
                                    <p class="ergo-card-item__speaker">Докладчик: <?php echo esc_html( $speaker ); ?></p>
                                <?php endif; ?>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="ergo-card-item__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '&larr; Назад', 'next_text' => 'Вперёд &rarr;' ) ); ?>
        <?php else : ?>
            <p>Пока нет семинаров.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
