<?php
/**
 * Template Name: Программы курсов
 * Каталог рабочих программ в стиле Netology
 *
 * @package Ergonosphera
 */

get_header();

// Получаем уникальные уровни из мета (для фильтра)
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

$levels = array_merge( array( '' => 'Все программы' ), array_combine( $levels_raw, $levels_raw ) );

while ( have_posts() ) :
    the_post();
    $current_level = isset( $_GET['level'] ) ? sanitize_text_field( wp_unslash( $_GET['level'] ) ) : '';
?>
<main id="main-content" class="ergo-main ergo-page ergo-catalog-programmi ergo-catalog-netology">
    <section class="ergo-catalog-hero">
        <div class="ergo-container">
            <h1 class="ergo-catalog-hero__title"><?php the_title(); ?></h1>
            <p class="ergo-catalog-hero__subtitle"><?php echo has_excerpt() ? esc_html( get_the_excerpt() ) : 'Выберите направление и начните изучение нужной дисциплины'; ?></p>
        </div>
    </section>

    <section class="ergo-catalog-content">
        <div class="ergo-container">
            <?php if ( ! empty( $levels_raw ) ) : ?>
            <div class="ergo-catalog-filters" role="tablist">
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="ergo-catalog-filter<?php echo $current_level === '' ? ' is-active' : ''; ?>">Все программы</a>
                <?php foreach ( $levels_raw as $l ) : ?>
                <a href="<?php echo esc_url( add_query_arg( 'level', rawurlencode( $l ), get_permalink() ) ); ?>" class="ergo-catalog-filter<?php echo $current_level === $l ? ' is-active' : ''; ?>"><?php echo esc_html( $l ); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php
            $args = array(
                'post_type'      => 'ergo_work_program',
                'posts_per_page' => 24,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            );
            if ( $current_level ) {
                $args['meta_query'] = array(
                    array( 'key' => 'work_program_level', 'value' => $current_level, 'compare' => '=' ),
                );
            }
            $q = new WP_Query( $args );
            if ( $q->have_posts() ) :
            ?>
            <div class="ergo-catalog-grid ergo-catalog-programs">
                <?php while ( $q->have_posts() ) : $q->the_post();
                    $code   = get_post_meta( get_the_ID(), 'work_program_code', true );
                    $level  = get_post_meta( get_the_ID(), 'work_program_level', true );
                    $dept   = get_post_meta( get_the_ID(), 'work_program_department', true );
                    $year   = get_post_meta( get_the_ID(), 'work_program_year', true );
                    $file   = get_post_meta( get_the_ID(), 'work_program_file', true );
                ?>
                <article class="ergo-catalog-card ergo-program-card" data-level="<?php echo esc_attr( $level ); ?>">
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
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php
            $programs_url = get_post_type_archive_link( 'ergo_work_program' );
            if ( $programs_url && $q->found_posts > 0 ) :
                if ( $current_level ) {
                    $programs_url = add_query_arg( 'level', rawurlencode( $current_level ), $programs_url );
                }
            ?>
            <p class="ergo-catalog-more">
                <a href="<?php echo esc_url( $programs_url ); ?>" class="ergo-btn ergo-btn--outline">Все рабочие программы &rarr;</a>
            </p>
            <?php endif; ?>
            <?php else : ?>
            <p class="ergo-catalog-empty">Рабочие программы пока не добавлены. Добавьте их в разделе «Рабочие программы» админ-панели WordPress.</p>
            <?php endif; ?>

            <?php if ( get_the_content() ) : ?>
            <div class="ergo-catalog-intro ergo-section__content">
                <?php the_content(); ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
endwhile;
get_footer();
