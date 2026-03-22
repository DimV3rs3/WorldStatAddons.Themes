<?php
/**
 * Template Name: Раздел портала
 * Универсальный шаблон для страниц-разделов (Студентам, Библиотека и т.д.)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
?>
<main id="main-content" class="ergo-main ergo-portal-page">
    <section class="ergo-portal-hero<?php echo has_post_thumbnail() ? ' ergo-portal-hero--has-image' : ''; ?>">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="ergo-portal-hero__image">
                <?php the_post_thumbnail( 'full' ); ?>
            </div>
        <?php endif; ?>
        <div class="ergo-container ergo-portal-hero__inner">
            <h1 class="ergo-portal-hero__title"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <p class="ergo-portal-hero__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="ergo-portal-content">
        <div class="ergo-container">
            <div class="ergo-portal-content__body">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
</main>
<?php
endwhile;
get_footer();
