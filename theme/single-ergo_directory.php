<?php
/**
 * Single: Справочник (ergo_directory)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $author = get_post_meta( get_the_ID(), 'directory_author', true );
    $year   = get_post_meta( get_the_ID(), 'directory_year', true );
    $isbn   = get_post_meta( get_the_ID(), 'directory_isbn', true );
    $url    = get_post_meta( get_the_ID(), 'directory_url', true );
?>
<main id="main-content" class="ergo-main ergo-page ergo-single-directory">
    <div class="ergo-container">
        <article class="ergo-single-entry">
            <header class="ergo-single-entry__header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ergo-single-entry__thumb"><?php the_post_thumbnail( 'ergo-hero' ); ?></div>
                <?php endif; ?>
                <h1 class="ergo-single-entry__title"><?php the_title(); ?></h1>
                <div class="ergo-single-entry__meta">
                    <?php if ( $author ) : ?><span><?php echo esc_html( $author ); ?></span><?php endif; ?>
                    <?php if ( $year ) : ?><span>&bull; <?php echo esc_html( $year ); ?></span><?php endif; ?>
                    <?php if ( $isbn ) : ?><span>&bull; ISBN: <?php echo esc_html( $isbn ); ?></span><?php endif; ?>
                </div>
            </header>
            <div class="ergo-single-entry__content ergo-section__content">
                <?php the_content(); ?>
            </div>
            <?php if ( $url ) : ?>
                <div class="ergo-single-entry__actions">
                    <a href="<?php echo esc_url( $url ); ?>" class="ergo-btn ergo-btn--primary" target="_blank" rel="noopener">Перейти к ресурсу &rarr;</a>
                </div>
            <?php endif; ?>
        </article>
        <nav class="ergo-single-entry__back">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_directory' ) ?: home_url( '/' ) ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все справочники</a>
        </nav>
    </div>
</main>
<?php
endwhile;
get_footer();
