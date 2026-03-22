<?php
/**
 * Single: Библиотека (ergo_library)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $lib_url  = get_post_meta( get_the_ID(), 'library_url', true );
    $lib_desc = get_post_meta( get_the_ID(), 'library_description', true );
?>
<main id="main-content" class="ergo-main ergo-page ergo-single-library">
    <div class="ergo-container">
        <article class="ergo-single-entry">
            <header class="ergo-single-entry__header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ergo-single-entry__thumb"><?php the_post_thumbnail( 'ergo-hero' ); ?></div>
                <?php endif; ?>
                <h1 class="ergo-single-entry__title"><?php the_title(); ?></h1>
                <?php
                $terms = get_the_terms( get_the_ID(), 'library_type' );
                if ( $terms && ! is_wp_error( $terms ) ) : ?>
                    <div class="ergo-single-entry__meta">
                        <span><?php echo esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) ); ?></span>
                    </div>
                <?php endif; ?>
            </header>
            <div class="ergo-single-entry__content ergo-section__content">
                <?php the_content(); ?>
            </div>
            <?php if ( $lib_url ) : ?>
                <div class="ergo-single-entry__actions">
                    <a href="<?php echo esc_url( $lib_url ); ?>" class="ergo-btn ergo-btn--primary" target="_blank" rel="noopener">Перейти в библиотеку &rarr;</a>
                </div>
            <?php endif; ?>
        </article>
        <nav class="ergo-single-entry__back">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_library' ) ?: home_url( '/' ) ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все библиотеки</a>
        </nav>
    </div>
</main>
<?php
endwhile;
get_footer();
