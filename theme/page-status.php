<?php
/**
 * Template Name: Platform Status
 * 
 * Platform statistics and status monitoring.
 * 
 * @package Ergonosphera
 */

get_header();

$themes        = ergo_get_data_themes();
$countries     = ergo_get_countries_count();
$with_data     = ergo_get_countries_with_data_count();
$last_update   = ergo_get_last_update_date();
?>

<main id="main-content" class="ergo-main ergo-status-page">
    <div class="ergo-container">

        <div class="ergo-page-header">
            <h1 class="ergo-page-header__title"><?php echo esc_html( 'Статус платформы' ); ?></h1>
            <p class="ergo-page-header__subtitle"><?php echo esc_html( 'Текущая статистика и состояние платформы' ); ?></p>
        </div>

        <!-- System Status -->
        <section class="ergo-status-overview">
            <div class="ergo-status-indicator ergo-status-indicator--ok">
                <span class="ergo-status-indicator__dot"></span>
                <span class="ergo-status-indicator__text"><?php echo esc_html( 'Все системы работают' ); ?></span>
            </div>
        </section>

        <!-- Stats Cards -->
        <section class="ergo-status-stats">
            <div class="ergo-status-card">
                <div class="ergo-status-card__value"><?php echo esc_html( count( $themes ) ); ?></div>
                <div class="ergo-status-card__label"><?php echo esc_html( 'Активные темы данных' ); ?></div>
            </div>
            <div class="ergo-status-card">
                <div class="ergo-status-card__value"><?php echo esc_html( $countries ); ?></div>
                <div class="ergo-status-card__label"><?php echo esc_html( 'Всего стран' ); ?></div>
            </div>
            <div class="ergo-status-card">
                <div class="ergo-status-card__value"><?php echo esc_html( $with_data ); ?></div>
                <div class="ergo-status-card__label"><?php echo esc_html( 'Стран с данными' ); ?></div>
            </div>
            <div class="ergo-status-card">
                <div class="ergo-status-card__value"><?php echo esc_html( $last_update ); ?></div>
                <div class="ergo-status-card__label"><?php echo esc_html( 'Последнее обновление' ); ?></div>
            </div>
        </section>

        <!-- Active Themes Status -->
        <section class="ergo-status-section">
            <h2><?php echo esc_html( 'Активные темы данных' ); ?></h2>
            <?php if ( ! empty( $themes ) ) : ?>
                <div class="ergo-table-responsive">
                    <table class="ergo-table">
                        <thead>
                            <tr>
                                <th><?php echo esc_html( 'Тема' ); ?></th>
                                <th><?php echo esc_html( 'Версия' ); ?></th>
                                <th><?php echo esc_html( 'Покрытие' ); ?></th>
                                <th><?php echo esc_html( 'Обновлено' ); ?></th>
                                <th><?php echo esc_html( 'Источник' ); ?></th>
                                <th><?php echo esc_html( 'Статус' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $themes as $theme ) : ?>
                                <tr>
                                    <td>
                                        <?php if ( ! empty( $theme['icon'] ) ) : ?>
                                            <span class="dashicons <?php echo esc_attr( $theme['icon'] ); ?>"></span>
                                        <?php endif; ?>
                                        <?php echo esc_html( $theme['name'] ); ?>
                                    </td>
                                    <td><?php echo esc_html( $theme['version'] ?? '1.0' ); ?></td>
                                    <td><?php echo esc_html( ( $theme['coverage'] ?? '—' ) . ' стран' ); ?></td>
                                    <td><?php echo esc_html( $theme['last_update'] ?? '—' ); ?></td>
                                    <td><?php echo esc_html( $theme['source'] ?? '—' ); ?></td>
                                    <td>
                                        <span class="ergo-badge ergo-badge--success"><?php echo esc_html( 'Активна' ); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="ergo-text-muted"><?php echo esc_html( 'Нет активных тем данных.' ); ?></p>
            <?php endif; ?>
        </section>

        <!-- Platform Info -->
        <section class="ergo-status-section">
            <h2><?php echo esc_html( 'Информация о платформе' ); ?></h2>
            <div class="ergo-table-responsive">
                <table class="ergo-table">
                    <tbody>
                        <tr>
                            <td><strong><?php echo esc_html( 'Платформа' ); ?></strong></td>
                            <td>Ergonosphera</td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html( 'Версия' ); ?></strong></td>
                            <td><?php echo esc_html( ERGO_VERSION ); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html( 'WordPress' ); ?></strong></td>
                            <td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html( 'PHP' ); ?></strong></td>
                            <td><?php echo esc_html( PHP_VERSION ); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html( 'REST API' ); ?></strong></td>
                            <td>
                                <span class="ergo-badge ergo-badge--success"><?php echo esc_html( 'Доступен' ); ?></span>
                                <code><?php echo esc_html( rest_url( 'ergonosphera/v1/' ) ); ?></code>
                            </td>
                        </tr>
                        <tr>
                            <td><strong><?php echo esc_html( 'Время сервера' ); ?></strong></td>
                            <td><?php echo esc_html( current_time( 'Y-m-d H:i:s' ) ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Activity Log -->
        <section class="ergo-status-section">
            <h2><?php echo esc_html( 'Последняя активность' ); ?></h2>
            <div class="ergo-activity-log" id="activity-log">
                <div class="ergo-activity-log__item">
                    <span class="ergo-activity-log__time"><?php echo esc_html( current_time( 'Y-m-d H:i' ) ); ?></span>
                    <span class="ergo-activity-log__text"><?php echo esc_html( 'Страница статуса загружена успешно' ); ?></span>
                </div>
                <?php
                // Show recent country posts
                $recent = new WP_Query( array(
                    'post_type'      => 'country',
                    'posts_per_page' => 5,
                    'orderby'        => 'modified',
                    'order'          => 'DESC',
                ) );
                if ( $recent->have_posts() ) :
                    while ( $recent->have_posts() ) : $recent->the_post();
                ?>
                    <div class="ergo-activity-log__item">
                        <span class="ergo-activity-log__time"><?php echo esc_html( get_the_modified_date( 'Y-m-d H:i' ) ); ?></span>
                        <span class="ergo-activity-log__text">
                            <?php printf( 'Страна обновлена: %s', esc_html( get_the_title() ) ); ?>
                        </span>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </section>

    </div>
</main>

<?php get_footer();
