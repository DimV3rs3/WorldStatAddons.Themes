<?php
/**
 * Archive Conferences — список конференций (URL: /conferences/)
 *
 * @package Ergonosphera
 */

get_header();
?>
<main id="main-content" class="ergo-main ergo-page ergo-page-conferences ergo-archive-conferences">
    <div class="ergo-container">
        <header class="ergo-page-header">
            <h1 class="ergo-page-header__title">Конференции</h1>
            <p class="ergo-page-header__subtitle">Международные и всероссийские конференции по глобальным процессам и глобалистике</p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ergo-conferences-list">
                <?php while ( have_posts() ) : the_post();
                    $date  = get_post_meta( get_the_ID(), 'conference_date', true );
                    $place = get_post_meta( get_the_ID(), 'conference_place', true );
                    $org   = get_post_meta( get_the_ID(), 'conference_organizer', true );
                ?>
                    <article class="ergo-conference-card">
                        <a href="<?php the_permalink(); ?>" class="ergo-conference-card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ergo-conference-card__thumb"><?php the_post_thumbnail( 'ergo-card' ); ?></div>
                            <?php else : ?>
                                <div class="ergo-conference-card__thumb ergo-conference-card__placeholder"></div>
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
                                <?php if ( $org ) : ?><p class="ergo-conference-card__organizer"><?php echo esc_html( $org ); ?></p><?php endif; ?>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="ergo-conference-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                                <?php endif; ?>
                                <span class="ergo-conference-card__more">Подробнее &rarr;</span>
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
        else : ?>
            <div class="ergo-empty-state">
                <p>Конференции пока не добавлены. Добавьте их через админ-панель WordPress.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer();
