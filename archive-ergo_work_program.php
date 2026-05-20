<?php
/**
 * Archive Work Programs — каталог в стиле Netology
 *
 * @package Ergonosphera
 */

get_header();

$current_level = isset( $_GET['level'] ) ? sanitize_text_field( wp_unslash( $_GET['level'] ) ) : '';

// Получаем уникальные уровни
$levels_query = new WP_Query( array(
    'post_type'      => 'ergo_work_program',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields'         => 'ids',
) );
$levels_raw = array();
foreach ( $levels_query->posts as $pid ) {
    $l = get_post_meta( $pid, 'work_program_level', true );
    if ( $l && ! in_array( $l, $levels_raw, true ) ) {
        $levels_raw[] = $l;
    }
}
wp_reset_postdata();
sort( $levels_raw );

$base_url = get_post_type_archive_link( 'ergo_work_program' );
?>
<main id="main-content" class="ergo-main ergo-page ergo-catalog-programmi ergo-catalog-netology ergo-archive-work-programs">
    <section class="ergo-catalog-hero">
        <div class="ergo-container">
            <h1 class="ergo-catalog-hero__title">Рабочие программы дисциплин</h1>
            <p class="ergo-catalog-hero__subtitle">Выберите направление и начните изучение нужной дисциплины</p>
        </div>
    </section>

    <section class="ergo-catalog-content">
        <div class="ergo-container">
            <?php if ( ! empty( $levels_raw ) && $base_url ) : ?>
            <div class="ergo-catalog-filters">
                <a href="<?php echo esc_url( $base_url ); ?>" class="ergo-catalog-filter<?php echo $current_level === '' ? ' is-active' : ''; ?>">Все программы</a>
                <?php foreach ( $levels_raw as $l ) :
                    $filter_url = add_query_arg( 'level', rawurlencode( $l ), $base_url );
                ?>
                <a href="<?php echo esc_url( $filter_url ); ?>" class="ergo-catalog-filter<?php echo $current_level === $l ? ' is-active' : ''; ?>"><?php echo esc_html( $l ); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ( have_posts() ) : ?>
            <div class="ergo-catalog-grid ergo-catalog-programs">
                <?php while ( have_posts() ) : the_post();
                    $code  = get_post_meta( get_the_ID(), 'work_program_code', true );
                    $level = get_post_meta( get_the_ID(), 'work_program_level', true );
                    $file  = get_post_meta( get_the_ID(), 'work_program_file', true );
                ?>
                <article class="ergo-catalog-card ergo-program-card">
                    <div class="ergo-program-card__badges">
                        <?php if ( $level ) : ?><span class="ergo-program-card__badge"><?php echo esc_html( $level ); ?></span><?php endif; ?>
                        <?php if ( $code ) : ?><span class="ergo-program-card__badge ergo-program-card__badge--muted"><?php echo esc_html( $code ); ?></span><?php endif; ?>
                    </div>
                    <h3 class="ergo-program-card__label">Рабочая программа</h3>
                    <h2 class="ergo-program-card__title">
                        <a href="<?php the_permalink(); ?>" class="ergo-program-card__title-link"><?php the_title(); ?></a>
                    </h2>
                    <?php if ( has_excerpt() ) : ?><p class="ergo-program-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p><?php endif; ?>
                    <div class="ergo-program-card__actions">
                        <a href="<?php the_permalink(); ?>" class="ergo-btn ergo-btn--primary ergo-btn--sm">Подробнее</a>
                        <?php if ( $file ) : ?><a href="<?php echo esc_url( $file ); ?>" class="ergo-btn ergo-btn--outline ergo-btn--sm" target="_blank" rel="noopener">Скачать PDF</a><?php endif; ?>
                    </div>
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
            <p class="ergo-catalog-empty">Рабочие программы пока не добавлены. Добавьте их через админ-панель WordPress.</p>
            <?php if ( current_user_can( 'edit_posts' ) ) : ?>
            <p style="margin-top:1rem;"><a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ergo_work_program' ) ); ?>" class="ergo-btn ergo-btn--primary">Добавить программу</a></p>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer();
