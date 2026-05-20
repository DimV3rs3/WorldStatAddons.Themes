<?php
/**
 * Single: Учёный (ergo_scientist)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $position = get_post_meta( get_the_ID(), 'scientist_position', true );
    $org      = get_post_meta( get_the_ID(), 'scientist_organization', true );
    $email    = get_post_meta( get_the_ID(), 'scientist_email', true );
    $field    = get_post_meta( get_the_ID(), 'scientist_field', true );
?>
<main id="main-content" class="ergo-main ergo-page ergo-single-scientist">
    <div class="ergo-container">
        <article class="ergo-single-entry ergo-single-entry--scientist">
            <header class="ergo-single-entry__header ergo-single-entry__header--scientist">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ergo-single-entry__photo"><?php the_post_thumbnail( 'medium' ); ?></div>
                <?php endif; ?>
                <div>
                    <h1 class="ergo-single-entry__title"><?php the_title(); ?></h1>
                    <div class="ergo-single-entry__meta">
                        <?php if ( $position ) : ?><span><?php echo esc_html( $position ); ?></span><?php endif; ?>
                        <?php if ( $org ) : ?><span>&bull; <?php echo esc_html( $org ); ?></span><?php endif; ?>
                        <?php if ( $field ) : ?><span>&bull; <?php echo esc_html( $field ); ?></span><?php endif; ?>
                        <?php if ( $email ) : ?><span>&bull; <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span><?php endif; ?>
                    </div>
                </div>
            </header>
            <div class="ergo-single-entry__content ergo-section__content">
                <?php the_content(); ?>
            </div>
        </article>
        <nav class="ergo-single-entry__back">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_scientist' ) ?: home_url( '/' ) ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все учёные</a>
        </nav>
    </div>
</main>
<?php
endwhile;
get_footer();
