<?php
/**
 * Archive: Новости (ergo_news)
 *
 * @package Ergonosphera
 */

get_header();
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-news">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Новости</h1>
            <p class="ergo-page-header__subtitle">Актуальные новости и события</p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ergo-news-list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="ergo-news-list__item">
                        <a href="<?php the_permalink(); ?>" class="ergo-news-list__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-news-list__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php endif; ?>
                            <div class="ergo-news-list__body">
                                <?php
                                $news_date = get_post_meta( get_the_ID(), 'news_date', true );
                                ?>
                                <time class="ergo-news-list__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( $news_date ?: get_the_date() ); ?>
                                </time>
                                <h2 class="ergo-news-list__title"><?php the_title(); ?></h2>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="ergo-news-list__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '&larr; Назад',
                'next_text' => 'Вперёд &rarr;',
            ) );
            ?>
        <?php else : ?>
            <p>Пока нет новостей.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
