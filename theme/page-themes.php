<?php
/**
 * Template Name: Data Themes
 * 
 * Shows all available data themes (active plugins).
 * 
 * @package Ergonosphera
 */

get_header();

$themes = ergo_get_data_themes();
$coming_soon = ergo_get_coming_soon_themes();
?>

<main id="main-content" class="ergo-main ergo-themes-page">
    <div class="ergo-container">

        <!-- Page Header -->
        <div class="ergo-page-header">
            <h1 class="ergo-page-header__title"><?php echo esc_html( 'Темы данных' ); ?></h1>
            <p class="ergo-page-header__subtitle">
                <?php echo esc_html( 'Изучайте различные статистические перспективы по странам мира' ); ?>
            </p>
        </div>

        <!-- Active Themes -->
        <?php if ( ! empty( $themes ) ) : ?>
            <div class="ergo-themes-showcase">
                <?php foreach ( $themes as $theme ) : ?>
                    <div class="ergo-theme-showcase-card" style="--theme-color: <?php echo esc_attr( $theme['color'] ?? '#6366f1' ); ?>">
                        <div class="ergo-theme-showcase-card__header">
                            <?php if ( ! empty( $theme['icon'] ) ) : ?>
                                <span class="ergo-theme-showcase-card__icon dashicons <?php echo esc_attr( $theme['icon'] ); ?>"></span>
                            <?php endif; ?>
                            <div>
                                <h2 class="ergo-theme-showcase-card__title"><?php echo esc_html( $theme['name'] ); ?></h2>
                                <?php if ( ! empty( $theme['author'] ) ) : ?>
                                    <span class="ergo-theme-showcase-card__author">
                                        <?php printf( esc_html( 'от %s' ), esc_html( $theme['author'] ) ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ( ! empty( $theme['description'] ) ) : ?>
                            <p class="ergo-theme-showcase-card__desc"><?php echo esc_html( $theme['description'] ); ?></p>
                        <?php endif; ?>

                        <div class="ergo-theme-showcase-card__stats">
                            <?php if ( ! empty( $theme['coverage'] ) ) : ?>
                                <div class="ergo-stat-item">
                                    <span class="ergo-stat-item__value"><?php echo esc_html( $theme['coverage'] ); ?></span>
                                    <span class="ergo-stat-item__label"><?php echo esc_html( 'Стран' ); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty( $theme['last_update'] ) ) : ?>
                                <div class="ergo-stat-item">
                                    <span class="ergo-stat-item__value"><?php echo esc_html( $theme['last_update'] ); ?></span>
                                    <span class="ergo-stat-item__label"><?php echo esc_html( 'Обновлено' ); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty( $theme['source'] ) ) : ?>
                                <div class="ergo-stat-item">
                                    <span class="ergo-stat-item__value"><?php echo esc_html( $theme['source'] ); ?></span>
                                    <span class="ergo-stat-item__label"><?php echo esc_html( 'Источник данных' ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Preview mini-map -->
                        <div class="ergo-theme-showcase-card__map" data-theme="<?php echo esc_attr( $theme['id'] ); ?>"></div>

                        <div class="ergo-theme-showcase-card__actions">
                            <a href="<?php echo esc_url( home_url( '/?theme=' . $theme['id'] ) ); ?>" class="ergo-btn ergo-btn--primary">
                                <?php echo esc_html( 'Показать на карте' ); ?>
                            </a>
                            <a href="<?php echo esc_url( home_url( '/country/?theme=' . $theme['id'] ) ); ?>" class="ergo-btn ergo-btn--outline">
                                <?php echo esc_html( 'Обзор стран' ); ?>
                            </a>
                            <a href="<?php echo esc_url( home_url( '/data-downloads/?theme=' . $theme['id'] ) ); ?>" class="ergo-btn ergo-btn--ghost">
                                <?php echo esc_html( 'Скачать данные' ); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class="ergo-empty-state">
                <div class="ergo-empty-state__icon">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none">
                        <circle cx="60" cy="60" r="56" stroke="currentColor" stroke-width="2" opacity="0.15"/>
                        <path d="M40 50h40v30H40z" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                        <path d="M50 50V40l10-8 10 8v10" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                        <circle cx="60" cy="65" r="5" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                    </svg>
                </div>
                <h2><?php echo esc_html( 'Не установлены темы данных' ); ?></h2>
                <p><?php echo esc_html( 'Темы данных — это плагины WordPress, предоставляющие статистические данные для визуализации на платформе.' ); ?></p>
                <div class="ergo-empty-state__steps">
                    <h3><?php echo esc_html( 'Как установить:' ); ?></h3>
                    <ol>
                        <li><?php echo esc_html( 'Перейдите в Консоль WordPress > Плагины > Добавить новый' ); ?></li>
                        <li><?php echo esc_html( 'Найдите «ergonosphera data theme»' ); ?></li>
                        <li><?php echo esc_html( 'Установите и активируйте плагин' ); ?></li>
                        <li><?php echo esc_html( 'Тема появится здесь автоматически' ); ?></li>
                    </ol>
                </div>
                <div class="ergo-empty-state__actions">
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php' ) ); ?>" class="ergo-btn ergo-btn--primary">
                        <?php echo esc_html( 'Просмотреть плагины' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/documentation/' ) ); ?>" class="ergo-btn ergo-btn--outline">
                        <?php echo esc_html( 'Документация разработчика' ); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Coming Soon Themes -->
        <?php if ( ! empty( $coming_soon ) ) : ?>
            <section class="ergo-coming-soon">
                <h2 class="ergo-section-title"><?php echo esc_html( 'Скоро' ); ?></h2>
                <p class="ergo-section-subtitle"><?php echo esc_html( 'Новые темы данных в разработке' ); ?></p>
                <div class="ergo-coming-soon__grid">
                    <?php foreach ( $coming_soon as $cs ) : ?>
                        <div class="ergo-coming-soon__card">
                            <?php if ( ! empty( $cs['icon'] ) ) : ?>
                                <span class="dashicons <?php echo esc_attr( $cs['icon'] ); ?>"></span>
                            <?php endif; ?>
                            <h3><?php echo esc_html( $cs['name'] ); ?></h3>
                            <?php if ( ! empty( $cs['description'] ) ) : ?>
                                <p><?php echo esc_html( $cs['description'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

    </div>
</main>

<?php get_footer();
