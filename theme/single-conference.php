<?php
/**
 * Single Conference — страница одной конференции (шаблон в стиле events.spbu.ru)
 *
 * @package Ergonosphera
 */

get_header();

while ( have_posts() ) :
    the_post();
    $date         = get_post_meta( get_the_ID(), 'conference_date', true );
    $place        = get_post_meta( get_the_ID(), 'conference_place', true );
    $org          = get_post_meta( get_the_ID(), 'conference_organizer', true );
    $url          = get_post_meta( get_the_ID(), 'conference_url', true );
    $announcement = get_post_meta( get_the_ID(), 'conference_announcement', true );
    $info_letter  = get_post_meta( get_the_ID(), 'conference_info_letter_url', true );
    $registration = get_post_meta( get_the_ID(), 'conference_registration_url', true );
    $tab_req      = get_post_meta( get_the_ID(), 'conference_tab_requirements', true );
    $tab_prog     = get_post_meta( get_the_ID(), 'conference_tab_program_committee', true );
    $tab_org      = get_post_meta( get_the_ID(), 'conference_tab_organizing_committee', true );
    $tab_program  = get_post_meta( get_the_ID(), 'conference_tab_program', true );
    $tab_contacts = get_post_meta( get_the_ID(), 'conference_tab_contacts', true );

    $tabs = array();
    if ( $tab_req )      $tabs[] = array( 'id' => 'requirements',   'label' => 'Требования к статьям',       'content' => $tab_req );
    if ( $tab_prog )     $tabs[] = array( 'id' => 'program-committee', 'label' => 'Программный комитет',    'content' => $tab_prog );
    if ( $tab_org )      $tabs[] = array( 'id' => 'organizing-committee', 'label' => 'Организационный комитет', 'content' => $tab_org );
    if ( $tab_program )  $tabs[] = array( 'id' => 'program',         'label' => 'Предварительная программа', 'content' => $tab_program );
    if ( $tab_contacts ) $tabs[] = array( 'id' => 'contacts',       'label' => 'Контакты',                    'content' => $tab_contacts );

    $archive_url = get_post_type_archive_link( 'conference' ) ?: ergo_get_page_url( 'konferencii' );
?>
<main id="main-content" class="ergo-main ergo-page ergo-single-conference ergo-conference-event">
    <div class="ergo-container">
        <?php ergo_breadcrumbs( array(
            array( 'url' => $archive_url, 'label' => 'Конференции' ),
            array( 'label' => get_the_title() ),
        ) ); ?>

        <article class="ergo-conference-event__article">
            <header class="ergo-conference-event__header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ergo-conference-event__thumb"><?php the_post_thumbnail( 'ergo-hero' ); ?></div>
                <?php endif; ?>

                <div class="ergo-conference-event__hero">
                    <?php if ( $place ) : ?><p class="ergo-conference-event__label"><?php echo esc_html( $place ); ?></p><?php endif; ?>
                    <?php if ( $date ) : ?>
                        <p class="ergo-conference-event__date"><?php echo esc_html( $date ); ?></p>
                    <?php endif; ?>
                    <h1 class="ergo-conference-event__title"><?php the_title(); ?></h1>
                </div>

                <?php if ( $announcement ) : ?>
                    <div class="ergo-conference-event__announcement">
                        <?php echo esc_html( $announcement ); ?>
                    </div>
                <?php endif; ?>

                <div class="ergo-conference-event__content ergo-section__content">
                    <?php the_content(); ?>
                </div>

                <?php if ( $info_letter || $registration || $url ) : ?>
                    <div class="ergo-conference-event__actions">
                        <?php if ( $info_letter ) : ?>
                            <a href="<?php echo esc_url( $info_letter ); ?>" class="ergo-btn ergo-btn--primary" target="_blank" rel="noopener">Информационное письмо</a>
                        <?php endif; ?>
                        <?php if ( $registration ) : ?>
                            <a href="<?php echo esc_url( $registration ); ?>" class="ergo-btn ergo-btn--primary" target="_blank" rel="noopener">Регистрация</a>
                        <?php endif; ?>
                        <?php if ( $url ) : ?>
                            <a href="<?php echo esc_url( $url ); ?>" class="ergo-btn ergo-btn--outline" target="_blank" rel="noopener">Сайт конференции</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ( ! empty( $tabs ) ) : ?>
                <section class="ergo-conference-event__tabs-section">
                    <h2 class="ergo-conference-event__tabs-title">Подробнее о мероприятии</h2>
                    <div class="ergo-conference-event__tabs-nav" role="tablist">
                        <?php foreach ( $tabs as $i => $tab ) : ?>
                            <button type="button" class="ergo-conference-event__tab-btn <?php echo $i === 0 ? 'is-active' : ''; ?>" role="tab" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="tab-<?php echo esc_attr( $tab['id'] ); ?>" id="btn-<?php echo esc_attr( $tab['id'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="ergo-conference-event__tabs-panels">
                        <?php foreach ( $tabs as $i => $tab ) : ?>
                            <div id="tab-<?php echo esc_attr( $tab['id'] ); ?>" class="ergo-conference-event__tab-panel <?php echo $i === 0 ? 'is-active' : ''; ?>" role="tabpanel" aria-labelledby="btn-<?php echo esc_attr( $tab['id'] ); ?>" <?php echo $i !== 0 ? 'hidden' : ''; ?>>
                                <div class="ergo-conference-event__tab-content">
                                    <?php echo wp_kses_post( $tab['content'] ); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ( $org ) : ?>
                <p class="ergo-conference-event__organizer">Организатор: <?php echo esc_html( $org ); ?></p>
            <?php endif; ?>
        </article>

        <nav class="ergo-conference-single__back">
            <a href="<?php echo esc_url( $archive_url ); ?>" class="ergo-btn ergo-btn--outline">&larr; Все конференции</a>
        </nav>
    </div>
</main>

<?php if ( ! empty( $tabs ) ) : ?>
<script>
(function(){
    var btns = document.querySelectorAll('.ergo-conference-event__tab-btn');
    var panels = document.querySelectorAll('.ergo-conference-event__tab-panel');
    btns.forEach(function(btn, idx){
        btn.addEventListener('click', function(){
            btns.forEach(function(b){ b.classList.remove('is-active'); b.setAttribute('aria-selected','false'); });
            panels.forEach(function(p){ p.classList.remove('is-active'); p.hidden = true; });
            btn.classList.add('is-active');
            btn.setAttribute('aria-selected','true');
            if(panels[idx]){ panels[idx].classList.add('is-active'); panels[idx].hidden = false; }
        });
    });
})();
</script>
<?php endif; ?>
<?php
endwhile;
get_footer();
