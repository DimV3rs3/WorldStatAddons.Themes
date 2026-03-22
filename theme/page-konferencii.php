<?php
/**
 * Template Name: Конференции
 * Шаблон страницы «Конференции» — список записей типа conference
 *
 * @package Ergonosphera
 */

get_header();

$paged = get_query_var( 'paged' ) ?: 1;
$q = new WP_Query( array(
    'post_type'      => 'conference',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-conferences">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Конференции</h1>
            <p class="ergo-page-header__subtitle">Международные и всероссийские конференции по глобальным процессам</p>
        </header>

        <?php if ( $q->have_posts() ) : ?>
            <div class="ergo-conferences-list">
                <?php while ( $q->have_posts() ) : $q->the_post(); ?>
                    <?php
                    $date  = get_post_meta( get_the_ID(), 'conference_date', true );
                    $place = get_post_meta( get_the_ID(), 'conference_place', true );
                    ?>
                    <article class="ergo-conference-card">
                        <a href="<?php the_permalink(); ?>" class="ergo-conference-card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-conference-card__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php else : ?>
                                <div class="ergo-conference-card__placeholder"></div>
                            <?php endif; ?>
                            <div class="ergo-conference-card__body">
                                <h2 class="ergo-conference-card__title"><?php the_title(); ?></h2>
                                <?php if ( $date || $place ) : ?>
                                    <p class="ergo-conference-card__meta">
                                        <?php if ( $date ) : ?><span><?php echo esc_html( $date ); ?></span><?php endif; ?>
                                        <?php if ( $date && $place ) : ?> &bull; <?php endif; ?>
                                        <?php if ( $place ) : ?><span><?php echo esc_html( $place ); ?></span><?php endif; ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="ergo-conference-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
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
            <p>Пока нет конференций.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
