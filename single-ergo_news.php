<?php
/**
 * Single: Новость (ergo_news)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $news_date   = get_post_meta( get_the_ID(), 'news_date', true );
    $news_source = get_post_meta( get_the_ID(), 'news_source', true );
?>
<main id="main-content" class="ergo-main ergo-page ergo-single-news">
    <div class="ergo-container">
        <article class="ergo-single-entry">
            <header class="ergo-single-entry__header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ergo-single-entry__thumb"><?php the_post_thumbnail( 'ergo-hero' ); ?></div>
                <?php endif; ?>
                <h1 class="ergo-single-entry__title"><?php the_title(); ?></h1>
                <div class="ergo-single-entry__meta">
                    <?php if ( $news_date ) : ?>
                        <span><?php echo esc_html( $news_date ); ?></span>
                    <?php else : ?>
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                    <?php endif; ?>
                    <?php if ( $news_source ) : ?>
                        <span>&bull; Источник: <?php echo esc_html( $news_source ); ?></span>
                    <?php endif; ?>
                </div>
            </header>
            <div class="ergo-single-entry__content ergo-section__content">
                <?php the_content(); ?>
            </div>
        </article>
        <nav class="ergo-single-entry__back">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_news' ) ?: home_url( '/' ) ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все новости</a>
        </nav>
    </div>
</main>
<?php
endwhile;
get_footer();
