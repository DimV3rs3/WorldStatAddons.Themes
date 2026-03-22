<?php
/**
 * The main template file
 * 
 * @package Ergonosphera
 */

get_header(); ?>

<main id="main-content" class="ergo-main">
    <div class="ergo-container">
        <?php if ( have_posts() ) : ?>
            <div class="ergo-posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('ergo-card'); ?>>
                        <h2 class="ergo-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="ergo-card__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination( array(
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ) ); ?>
        <?php else : ?>
            <div class="ergo-no-content">
                <h2>Ничего не найдено</h2>
                <p>К сожалению, по вашему запросу ничего не найдено.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer();
