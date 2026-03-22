<?php
/**
 * Archive: Библиотеки (ergo_library)
 *
 * @package Ergonosphera
 */

get_header();
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-libraries">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Библиотеки</h1>
            <p class="ergo-page-header__subtitle">Научные и электронные библиотеки</p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ergo-cards-grid">
                <?php while ( have_posts() ) : the_post();
                    $lib_url  = get_post_meta( get_the_ID(), 'library_url', true );
                    $lib_desc = get_post_meta( get_the_ID(), 'library_description', true );
                    $terms    = get_the_terms( get_the_ID(), 'library_type' );
                ?>
                    <article class="ergo-card-item">
                        <a href="<?php the_permalink(); ?>" class="ergo-card-item__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-card-item__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php endif; ?>
                            <div class="ergo-card-item__body">
                                <h2 class="ergo-card-item__title"><?php the_title(); ?></h2>
                                <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
                                    <p class="ergo-card-item__meta">
                                        <?php echo esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) ); ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="ergo-card-item__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '&larr; Назад', 'next_text' => 'Вперёд &rarr;' ) ); ?>
        <?php else : ?>
            <p>Пока нет библиотек.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
