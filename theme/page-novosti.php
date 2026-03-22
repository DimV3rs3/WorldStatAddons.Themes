<?php
/**
 * Template Name: Новости
 * Шаблон страницы «Новости» — список записей из категории «Новости»
 *
 * @package Ergonosphera
 */

get_header();

$cat_id = get_cat_ID( 'Новости' );
if ( ! $cat_id ) {
    $cat_id = 1;
}
$paged = get_query_var( 'paged' ) ?: 1;
$q = new WP_Query( array(
    'cat'            => $cat_id,
    'posts_per_page' => 10,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-news">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Новости</h1>
            <p class="ergo-page-header__subtitle">Актуальные новости платформы и события</p>
        </header>

        <?php if ( $q->have_posts() ) : ?>
            <div class="ergo-news-list">
                <?php while ( $q->have_posts() ) : $q->the_post(); ?>
                    <article class="ergo-news-list__item">
                        <a href="<?php the_permalink(); ?>" class="ergo-news-list__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-news-list__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php endif; ?>
                            <div class="ergo-news-list__body">
                                <time class="ergo-news-list__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
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
            wp_reset_postdata();
            ?>
        <?php else : ?>
            <p>Пока нет новостей.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
