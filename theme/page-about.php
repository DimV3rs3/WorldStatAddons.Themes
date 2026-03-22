<?php
/**
 * Template Name: About Platform
 * 
 * @package Ergonosphera
 */

get_header();

$themes_count    = ergo_get_active_themes_count();
$countries_count = ergo_get_countries_count();
?>

<main id="main-content" class="ergo-main ergo-about-page">

    <!-- Hero -->
    <section class="ergo-about-hero">
        <div class="ergo-container">
            <h1 class="ergo-about-hero__title"><?php printf( 'О платформе %s', esc_html( get_bloginfo( 'name' ) ) ); ?></h1>
            <p class="ergo-about-hero__subtitle"><?php echo esc_html( 'Открытая платформа для визуализации глобальных данных' ); ?></p>
        </div>
    </section>

    <!-- What is this platform -->
    <section class="ergo-about-section">
        <div class="ergo-container">
            <h2><?php echo esc_html( 'Что такое эта платформа?' ); ?></h2>
            <div class="ergo-about-grid">
                <div class="ergo-about-feature">
                    <div class="ergo-about-feature__icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2"/><rect x="28" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2"/><rect x="4" y="28" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2"/><rect x="28" y="28" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3><?php echo esc_html( 'Модульная платформа' ); ?></h3>
                    <p><?php echo esc_html( 'Построена как модульная система, в которой плагины данных предоставляют различные типы статистической информации по странам мира.' ); ?></p>
                </div>
                <div class="ergo-about-feature">
                    <div class="ergo-about-feature__icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2"/><path d="M12 24c0-6.6 5.4-12 12-12s12 5.4 12 12" stroke="currentColor" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="currentColor"/></svg>
                    </div>
                    <h3><?php echo esc_html( 'Плагины как источники данных' ); ?></h3>
                    <p><?php echo esc_html( 'Каждая тема данных — это плагин WordPress, предоставляющий статистические данные, визуализации и загружаемые наборы данных.' ); ?></p>
                </div>
                <div class="ergo-about-feature">
                    <div class="ergo-about-feature__icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2"/><ellipse cx="24" cy="24" rx="8" ry="20" stroke="currentColor" stroke-width="1.5"/><line x1="4" y1="24" x2="44" y2="24" stroke="currentColor" stroke-width="1.5"/></svg>
                    </div>
                    <h3><?php echo esc_html( 'Интерактивные карты' ); ?></h3>
                    <p><?php echo esc_html( 'Визуализация данных через интерактивные SVG-карты с цветовой кодировкой стран, легендами и подробными подсказками.' ); ?></p>
                </div>
                <div class="ergo-about-feature">
                    <div class="ergo-about-feature__icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M8 8h32v32H8z" stroke="currentColor" stroke-width="2" rx="2"/><path d="M8 16h32M16 8v32" stroke="currentColor" stroke-width="1.5" opacity="0.5"/></svg>
                    </div>
                    <h3><?php echo esc_html( 'Открытые данные' ); ?></h3>
                    <p><?php echo esc_html( 'Все данные доступны через REST API и загружаются в стандартных форматах: CSV, XLSX и JSON.' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="ergo-about-section ergo-about-section--alt">
        <div class="ergo-container">
            <h2><?php echo esc_html( 'Как это работает' ); ?></h2>
            <div class="ergo-about-process">
                <div class="ergo-about-process__step">
                    <span class="ergo-about-process__number">1</span>
                    <h3><?php echo esc_html( 'Разработчики создают плагины' ); ?></h3>
                    <p><?php echo esc_html( 'Разработчики создают плагины тем данных, предоставляющие статистику через стандартизированные хуки WordPress.' ); ?></p>
                </div>
                <div class="ergo-about-process__arrow">&rarr;</div>
                <div class="ergo-about-process__step">
                    <span class="ergo-about-process__number">2</span>
                    <h3><?php echo esc_html( 'Администраторы устанавливают плагины' ); ?></h3>
                    <p><?php echo esc_html( 'Администраторы сайта устанавливают и активируют нужные плагины тем данных через панель управления WordPress.' ); ?></p>
                </div>
                <div class="ergo-about-process__arrow">&rarr;</div>
                <div class="ergo-about-process__step">
                    <span class="ergo-about-process__number">3</span>
                    <h3><?php echo esc_html( 'Пользователи изучают данные' ); ?></h3>
                    <p><?php echo esc_html( 'Пользователи изучают данные через интерактивные карты, графики, таблицы и загружаемые наборы данных.' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- For Developers -->
    <section class="ergo-about-section">
        <div class="ergo-container">
            <div class="ergo-about-audiences">
                <div class="ergo-about-audience">
                    <h2><?php echo esc_html( 'Для разработчиков' ); ?></h2>
                    <p><?php echo esc_html( 'Создайте свой плагин темы данных и поделитесь им с сообществом.' ); ?></p>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/documentation/' ) ); ?>"><?php echo esc_html( 'Документация для разработчиков' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/api-docs/' ) ); ?>"><?php echo esc_html( 'Справочник API' ); ?></a></li>
                        <li><a href="https://github.com/" target="_blank" rel="noopener"><?php echo esc_html( 'Репозиторий GitHub' ); ?></a></li>
                    </ul>
                    <a href="<?php echo esc_url( home_url( '/documentation/' ) ); ?>" class="ergo-btn ergo-btn--primary"><?php echo esc_html( 'Начать разработку' ); ?></a>
                </div>
                <div class="ergo-about-audience">
                    <h2><?php echo esc_html( 'Для поставщиков данных' ); ?></h2>
                    <p><?php echo esc_html( 'Поделитесь своими наборами данных с мировой аудиторией через платформу.' ); ?></p>
                    <ul>
                        <li><?php echo esc_html( 'Стандартизированный формат данных' ); ?></li>
                        <li><?php echo esc_html( 'Автоматическая визуализация' ); ?></li>
                        <li><?php echo esc_html( 'Цитирование и указание авторства' ); ?></li>
                    </ul>
                    <a href="<?php echo esc_url( home_url( '/documentation/#data-format' ) ); ?>" class="ergo-btn ergo-btn--outline"><?php echo esc_html( 'Подробнее' ); ?></a>
                </div>
                <div class="ergo-about-audience">
                    <h2><?php echo esc_html( 'Для исследователей' ); ?></h2>
                    <p><?php echo esc_html( 'Используйте наши данные для академических исследований и анализа.' ); ?></p>
                    <ul>
                        <li><?php echo esc_html( 'Загружаемые наборы данных' ); ?></li>
                        <li><?php echo esc_html( 'Доступ через REST API' ); ?></li>
                        <li><?php echo esc_html( 'Открытая лицензия (CC BY 4.0)' ); ?></li>
                    </ul>
                    <a href="<?php echo esc_url( home_url( '/data-downloads/' ) ); ?>" class="ergo-btn ergo-btn--outline"><?php echo esc_html( 'Доступ к данным' ); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack -->
    <section class="ergo-about-section ergo-about-section--alt">
        <div class="ergo-container">
            <h2><?php echo esc_html( 'Технологический стек' ); ?></h2>
            <div class="ergo-tech-stack">
                <div class="ergo-tech-item">WordPress</div>
                <div class="ergo-tech-item">SVG Maps</div>
                <div class="ergo-tech-item">Chart.js</div>
                <div class="ergo-tech-item">Leaflet.js</div>
                <div class="ergo-tech-item">DataTables</div>
                <div class="ergo-tech-item">REST API</div>
                <div class="ergo-tech-item">AJAX</div>
                <div class="ergo-tech-item">Open Source</div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="ergo-about-section" id="faq">
        <div class="ergo-container">
            <h2><?php echo esc_html( 'Часто задаваемые вопросы' ); ?></h2>
            <div class="ergo-faq">
                <details class="ergo-faq__item">
                    <summary><?php echo esc_html( 'Как установить плагины тем данных?' ); ?></summary>
                    <p><?php echo esc_html( 'Перейдите в Админка WordPress > Плагины > Добавить новый, найдите плагины тем данных, установите и активируйте их. Они автоматически зарегистрируются в платформе.' ); ?></p>
                </details>
                <details class="ergo-faq__item">
                    <summary><?php echo esc_html( 'Могу ли я создать свой плагин?' ); ?></summary>
                    <p><?php echo 'Да! Ознакомьтесь с нашей <a href="' . esc_url( home_url( '/documentation/' ) ) . '">документацией для разработчиков</a> для подробных инструкций по созданию плагинов тем данных.'; ?></p>
                </details>
                <details class="ergo-faq__item">
                    <summary><?php echo esc_html( 'Какие форматы данных поддерживаются?' ); ?></summary>
                    <p><?php echo esc_html( 'Платформа поддерживает форматы CSV, XLSX, JSON и GeoJSON для загрузки данных. Компоненты визуализации поддерживают линейные графики, столбчатые диаграммы, круговые диаграммы, таблицы, карты и временные шкалы.' ); ?></p>
                </details>
                <details class="ergo-faq__item">
                    <summary><?php echo esc_html( 'Какая лицензия у платформы?' ); ?></summary>
                    <p><?php echo esc_html( 'Тема платформы распространяется под лицензией GPL v2. Данные, предоставляемые плагинами, могут иметь собственные лицензии — проверьте документацию каждого плагина.' ); ?></p>
                </details>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
