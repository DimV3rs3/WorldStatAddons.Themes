<?php
/**
 * Single: Семинар (ergo_seminar)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $date    = get_post_meta( get_the_ID(), 'seminar_date', true );
    $place   = get_post_meta( get_the_ID(), 'seminar_place', true );
    $speaker = get_post_meta( get_the_ID(), 'seminar_speaker', true );
?>
<main id="main-content" class="ergo-main ergo-page ergo-single-seminar">
    <div class="ergo-container">
        <article class="ergo-single-entry">
            <header class="ergo-single-entry__header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ergo-single-entry__thumb"><?php the_post_thumbnail( 'ergo-hero' ); ?></div>
                <?php endif; ?>
                <h1 class="ergo-single-entry__title"><?php the_title(); ?></h1>
                <div class="ergo-single-entry__meta">
                    <?php if ( $date ) : ?><span><?php echo esc_html( $date ); ?></span><?php endif; ?>
                    <?php if ( $place ) : ?><span>&bull; <?php echo esc_html( $place ); ?></span><?php endif; ?>
                    <?php if ( $speaker ) : ?><span>&bull; Докладчик: <?php echo esc_html( $speaker ); ?></span><?php endif; ?>
                </div>
            </header>
            <div class="ergo-single-entry__content ergo-section__content">
                <?php the_content(); ?>
            </div>
        </article>
        <nav class="ergo-single-entry__back">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_seminar' ) ?: home_url( '/' ) ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все семинары</a>
        </nav>
    </div>
</main>
<?php
endwhile;
get_footer();
