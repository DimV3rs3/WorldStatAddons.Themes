<?php
/**
 * Template Name: Статьи
 * Шаблон страницы «Интересные статьи» — список записей из категории «Статьи»
 *
 * @package Ergonosphera
 */

get_header();

$cat_id = get_cat_ID( 'Статьи' );
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
<main id="main-content" class="ergo-main ergo-page ergo-page-articles">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Интересные статьи</h1>
            <p class="ergo-page-header__subtitle">Статьи по глобалистике, визуализации данных и смежным темам</p>
        </header>

        <?php if ( $q->have_posts() ) : ?>
            <div class="ergo-articles-grid">
                <?php while ( $q->have_posts() ) : $q->the_post(); ?>
                    <article class="ergo-article-card">
                        <a href="<?php the_permalink(); ?>" class="ergo-article-card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-article-card__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php else : ?>
                                <div class="ergo-article-card__placeholder"></div>
                            <?php endif; ?>
                            <div class="ergo-article-card__body">
                                <h2 class="ergo-article-card__title"><?php the_title(); ?></h2>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="ergo-article-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                                <?php endif; ?>
                                <span class="ergo-article-card__more">Читать далее &rarr;</span>
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
            <p>Пока нет статей.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
