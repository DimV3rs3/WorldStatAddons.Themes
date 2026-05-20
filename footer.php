<footer class="ergo-footer">
    <div class="ergo-container">
        <div class="ergo-footer__grid">
            <div class="ergo-footer__about">
                <h3 class="ergo-footer__title"><?php bloginfo( 'name' ); ?></h3>
                <p class="ergo-footer__desc">
                    Открытая платформа для визуализации глобальных данных. Исследуйте статистические данные по странам мира с помощью интерактивных карт и тем данных.
                </p>
            </div>

            <div class="ergo-footer__links">
                <h4 class="ergo-footer__heading">Студентам</h4>
                <ul>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'o-globalistike' ) ); ?>">О глобалистике</a></li>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'studencheskie-seminari' ) ); ?>">Студенческие семинары</a></li>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'programmi-kursov' ) ); ?>">Программы курсов</a></li>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'glossariy' ) ); ?>">Глоссарий</a></li>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'podkasty' ) ); ?>">Подкасты</a></li>
                </ul>
            </div>

            <div class="ergo-footer__links">
                <h4 class="ergo-footer__heading">Научная жизнь</h4>
                <ul>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'seminar-globalistiki' ) ); ?>">Семинар по глобалистике</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'conference' ) ?: ergo_get_page_url( 'konferencii' ) ); ?>">Конференции</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_news' ) ?: ergo_get_page_url( 'novosti' ) ); ?>">Новости</a></li>
                </ul>
            </div>

            <div class="ergo-footer__links">
                <h4 class="ergo-footer__heading">Библиотека</h4>
                <ul>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_directory' ) ?: ergo_get_page_url( 'spravochnaya-literatura' ) ); ?>">Справочники</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_library' ) ?: ergo_get_page_url( 'elektronnye-biblioteki' ) ); ?>">Библиотеки</a></li>
                    <li><a href="<?php echo esc_url( ergo_get_page_url( 'statyi' ) ); ?>">Статьи</a></li>
                </ul>
            </div>

            <div class="ergo-footer__links">
                <h4 class="ergo-footer__heading">О проекте</h4>
                <ul>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'ergo_scientist' ) ?: ergo_get_page_url( 'uchenye' ) ); ?>">Учёные</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">О нас</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#ergo-map' ) ); ?>">Карта</a></li>
                </ul>
            </div>
        </div>

        <div class="ergo-footer__bottom">
            <p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
                Открытая платформа данных на WordPress.
            </p>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'ergo-footer__bottom-nav',
                'depth'          => 1,
                'fallback_cb'    => false,
            ) );
            ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
