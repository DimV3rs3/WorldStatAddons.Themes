<?php
/**
 * Single Work Program — шаблон в стиле academy.dpomipk.ru
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $pid = get_the_ID();
    $code       = get_post_meta( $pid, 'work_program_code', true );
    $level      = get_post_meta( $pid, 'work_program_level', true );
    $department = get_post_meta( $pid, 'work_program_department', true );
    $year       = get_post_meta( $pid, 'work_program_year', true );
    $hours      = get_post_meta( $pid, 'work_program_hours', true );
    $file_url   = get_post_meta( $pid, 'work_program_file', true );
    $modules_n  = get_post_meta( $pid, 'work_program_modules_count', true );
    $goals      = get_post_meta( $pid, 'work_program_goals', true );
    $curriculum = get_post_meta( $pid, 'work_program_curriculum', true );
    $outcomes   = get_post_meta( $pid, 'work_program_outcomes', true );
    $target     = get_post_meta( $pid, 'work_program_target_audience', true );
    $literature = get_post_meta( $pid, 'work_program_literature', true );
    $faq        = get_post_meta( $pid, 'work_program_faq', true );
    $how        = get_post_meta( $pid, 'work_program_how_it_works', true );

    $programs_url = ergo_get_page_url( 'programmi-kursov' ) ?: get_post_type_archive_link( 'ergo_work_program' );
    $related = get_posts( array( 'post_type' => 'ergo_work_program', 'posts_per_page' => 3, 'post__not_in' => array( $pid ), 'orderby' => 'rand' ) );
?>
<main id="main-content" class="ergo-main ergo-page ergo-course-single ergo-course-academy">
    <div class="ergo-container">
        <?php ergo_breadcrumbs( array(
            array( 'url' => $programs_url, 'label' => 'Рабочие программы' ),
            array( 'label' => get_the_title() ),
        ) ); ?>

        <article class="ergo-course-article">
            <header class="ergo-course-hero">
                <h1 class="ergo-course-hero__title"><?php the_title(); ?></h1>
                <?php if ( has_excerpt() ) : ?>
                    <p class="ergo-course-hero__desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
                <?php endif; ?>
                <?php if ( $file_url ) : ?>
                    <a href="<?php echo esc_url( $file_url ); ?>" class="ergo-btn ergo-btn--primary ergo-course-hero__cta" target="_blank" rel="noopener">
                        <span class="dashicons dashicons-download" style="font-size:18px;width:18px;height:18px;vertical-align:middle;"></span> Скачать рабочую программу (PDF)
                    </a>
                <?php endif; ?>

                <div class="ergo-course-badges">
                    <?php if ( $level ) : ?><span class="ergo-course-badge"><?php echo esc_html( $level ); ?></span><?php endif; ?>
                    <?php if ( $code ) : ?><span class="ergo-course-badge"><?php echo esc_html( $code ); ?></span><?php endif; ?>
                    <?php if ( $hours ) : ?><span class="ergo-course-badge"><?php echo esc_html( $hours ); ?> академ. часов</span><?php endif; ?>
                    <?php if ( $department ) : ?><span class="ergo-course-badge"><?php echo esc_html( $department ); ?></span><?php endif; ?>
                    <?php if ( $year ) : ?><span class="ergo-course-badge"><?php echo esc_html( $year ); ?> г.</span><?php endif; ?>
                    <span class="ergo-course-badge">Дисциплина</span>
                </div>
            </header>

            <?php if ( $target ) : ?>
            <section class="ergo-course-section ergo-course-target">
                <h2 class="ergo-course-section__title">Кому подойдёт дисциплина</h2>
                <div class="ergo-course-section__content ergo-target-cards">
                    <?php echo wp_kses_post( $target ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( get_the_content() ) : ?>
            <section class="ergo-course-section ergo-course-about">
                <h2 class="ergo-course-section__title">О дисциплине</h2>
                <div class="ergo-course-section__content ergo-section__content">
                    <?php the_content(); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( $hours || $modules_n || $level ) : ?>
            <section class="ergo-course-section">
                <h2 class="ergo-course-section__title">Программа обучения</h2>
                <div class="ergo-course-stats ergo-course-stats--big">
                    <?php if ( $hours ) : ?>
                    <div class="ergo-course-stat ergo-course-stat--big">
                        <span class="ergo-course-stat__value"><?php echo esc_html( $hours ); ?></span>
                        <span class="ergo-course-stat__label">академических часов</span>
                    </div>
                    <?php endif; ?>
                    <?php if ( $modules_n ) : ?>
                    <div class="ergo-course-stat ergo-course-stat--big">
                        <span class="ergo-course-stat__value"><?php echo esc_html( $modules_n ); ?></span>
                        <span class="ergo-course-stat__label">тематических модулей</span>
                    </div>
                    <?php endif; ?>
                    <?php if ( $level ) : ?>
                    <div class="ergo-course-stat ergo-course-stat--big">
                        <span class="ergo-course-stat__value"><?php echo esc_html( $level ); ?></span>
                        <span class="ergo-course-stat__label">уровень подготовки</span>
                    </div>
                    <?php endif; ?>
                </div>
                <p class="ergo-course-note">Программа разработана в соответствии с федеральными государственными образовательными стандартами высшего образования.</p>
            </section>
            <?php endif; ?>

            <?php if ( $goals ) : ?>
            <section class="ergo-course-section">
                <h2 class="ergo-course-section__title">Цели и задачи освоения дисциплины</h2>
                <div class="ergo-course-section__content ergo-section__content">
                    <?php echo wp_kses_post( $goals ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( $curriculum ) : ?>
            <section class="ergo-course-section">
                <h2 class="ergo-course-section__title">Учебный план</h2>
                <div class="ergo-course-section__content ergo-course-curriculum ergo-section__content">
                    <?php echo wp_kses_post( $curriculum ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( $outcomes ) : ?>
            <section class="ergo-course-section ergo-course-outcomes">
                <h2 class="ergo-course-section__title">Результаты освоения дисциплины</h2>
                <div class="ergo-course-section__content ergo-section__content">
                    <?php echo wp_kses_post( $outcomes ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( $literature ) : ?>
            <section class="ergo-course-section">
                <h2 class="ergo-course-section__title">Основная и дополнительная литература</h2>
                <div class="ergo-course-section__content ergo-course-literature ergo-section__content">
                    <?php echo wp_kses_post( $literature ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( $how ) : ?>
            <section class="ergo-course-section">
                <h2 class="ergo-course-section__title">Как проходит обучение</h2>
                <div class="ergo-course-section__content ergo-course-how ergo-section__content">
                    <?php echo wp_kses_post( $how ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( $faq ) : ?>
            <section class="ergo-course-section">
                <h2 class="ergo-course-section__title">Вопрос-ответ</h2>
                <div class="ergo-course-section__content ergo-course-faq ergo-section__content">
                    <?php echo wp_kses_post( $faq ); ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if ( ! empty( $related ) ) : ?>
            <section class="ergo-course-section ergo-course-related">
                <h2 class="ergo-course-section__title">Рекомендуемые программы</h2>
                <div class="ergo-course-related__grid">
                    <?php foreach ( $related as $rel ) :
                        $rel_code = get_post_meta( $rel->ID, 'work_program_code', true );
                        $rel_level = get_post_meta( $rel->ID, 'work_program_level', true );
                    ?>
                    <a href="<?php echo esc_url( get_permalink( $rel ) ); ?>" class="ergo-course-related__card">
                        <span class="ergo-course-related__badge"><?php echo esc_html( $rel_level ?: $rel_code ?: 'Программа' ); ?></span>
                        <h3 class="ergo-course-related__title"><?php echo esc_html( $rel->post_title ); ?></h3>
                        <span class="ergo-course-related__link">Подробнее &rarr;</span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <nav class="ergo-course-back">
                <a href="<?php echo esc_url( $programs_url ?: get_post_type_archive_link( 'ergo_work_program' ) ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все рабочие программы</a>
                <?php if ( $file_url ) : ?>
                    <a href="<?php echo esc_url( $file_url ); ?>" class="ergo-btn ergo-btn--primary" target="_blank" rel="noopener">Скачать PDF</a>
                <?php endif; ?>
            </nav>
        </article>
    </div>
</main>
<?php
endwhile;
get_footer();
