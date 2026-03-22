<?php
/**
 * Template Name: Data Downloads
 * 
 * Universal page for downloading datasets from all plugins.
 * 
 * @package Ergonosphera
 */

get_header();

$themes    = ergo_get_data_themes();
$downloads = ergo_get_all_downloads();
?>

<main id="main-content" class="ergo-main ergo-downloads-page">
    <div class="ergo-container">

        <div class="ergo-page-header">
            <h1 class="ergo-page-header__title"><?php echo esc_html( 'Скачать наборы данных' ); ?></h1>
            <p class="ergo-page-header__subtitle"><?php echo esc_html( 'Доступ к необработанным данным в различных форматах' ); ?></p>
        </div>

        <?php if ( ! empty( $downloads ) ) : ?>

            <!-- Filters -->
            <div class="ergo-filters ergo-downloads-filters">
                <div class="ergo-filters__row">
                    <div class="ergo-filter-group">
                        <select id="dl-format-filter" class="ergo-select">
                            <option value=""><?php echo esc_html( 'Все форматы' ); ?></option>
                            <option value="csv">CSV</option>
                            <option value="xlsx">XLSX</option>
                            <option value="json">JSON</option>
                            <option value="geojson">GeoJSON</option>
                        </select>
                    </div>
                    <div class="ergo-filter-group">
                        <select id="dl-sort" class="ergo-select">
                            <option value="newest"><?php echo esc_html( 'Сначала новые' ); ?></option>
                            <option value="oldest"><?php echo esc_html( 'Сначала старые' ); ?></option>
                            <option value="largest"><?php echo esc_html( 'По размеру (убыв.)' ); ?></option>
                            <option value="smallest"><?php echo esc_html( 'По размеру (возр.)' ); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Downloads by Theme -->
            <?php foreach ( $downloads as $theme_dl ) : ?>
                <section class="ergo-download-theme" data-theme="<?php echo esc_attr( $theme_dl['theme_id'] ?? '' ); ?>">
                    <div class="ergo-download-theme__header">
                        <h2><?php echo esc_html( $theme_dl['theme_name'] ?? '' ); ?></h2>
                        <?php if ( ! empty( $theme_dl['description'] ) ) : ?>
                            <p><?php echo esc_html( $theme_dl['description'] ); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $theme_dl['files'] ) ) : ?>
                        <div class="ergo-table-responsive">
                            <table class="ergo-table ergo-downloads-table">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html( 'Название набора данных' ); ?></th>
                                        <th><?php echo esc_html( 'Стран' ); ?></th>
                                        <th><?php echo esc_html( 'Обновлено' ); ?></th>
                                        <th><?php echo esc_html( 'Формат' ); ?></th>
                                        <th><?php echo esc_html( 'Размер' ); ?></th>
                                        <th><?php echo esc_html( 'Скачать' ); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ( $theme_dl['files'] as $file ) : ?>
                                        <tr data-formats="<?php echo esc_attr( implode( ',', (array) ( $file['formats'] ?? array() ) ) ); ?>">
                                            <td class="ergo-downloads-table__name"><?php echo esc_html( $file['name'] ?? '' ); ?></td>
                                            <td><?php echo esc_html( $file['countries'] ?? '—' ); ?></td>
                                            <td><?php echo esc_html( $file['updated'] ?? '—' ); ?></td>
                                            <td>
                                                <?php foreach ( (array) ( $file['formats'] ?? array() ) as $fmt ) : ?>
                                                    <span class="ergo-badge ergo-badge--format"><?php echo esc_html( strtoupper( $fmt ) ); ?></span>
                                                <?php endforeach; ?>
                                            </td>
                                            <td><?php echo esc_html( $file['size'] ?? '—' ); ?></td>
                                            <td class="ergo-downloads-table__actions">
                                                <?php foreach ( (array) ( $file['formats'] ?? array() ) as $fmt ) : ?>
                                                    <a href="<?php echo esc_url( add_query_arg( array(
                                                        'action' => 'ergo_download',
                                                        'theme'  => $theme_dl['theme_id'],
                                                        'file'   => $file['id'] ?? '',
                                                        'format' => $fmt,
                                                    ), admin_url( 'admin-ajax.php' ) ) ); ?>" 
                                                    class="ergo-btn ergo-btn--sm ergo-btn--outline" download>
                                                        <?php echo esc_html( strtoupper( $fmt ) ); ?> ↓
                                                    </a>
                                                <?php endforeach; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ( ! empty( $theme_dl['bulk_url'] ) ) : ?>
                            <div class="ergo-download-theme__bulk">
                                <a href="<?php echo esc_url( $theme_dl['bulk_url'] ); ?>" class="ergo-btn ergo-btn--primary" download>
                                    <?php echo esc_html( 'Скачать всё (ZIP)' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>

        <?php else : ?>
            <?php ergo_render_no_data( 'themes' ); ?>
        <?php endif; ?>

        <!-- API Section -->
        <section class="ergo-api-section">
            <h2 class="ergo-section-title"><?php echo esc_html( 'Доступ к данным через API' ); ?></h2>
            <p class="ergo-section-subtitle"><?php echo esc_html( 'Или доступ к данным программно через REST API' ); ?></p>

            <div class="ergo-code-examples">
                <pre class="ergo-code"><code>GET /wp-json/ergonosphera/v1/countries
GET /wp-json/ergonosphera/v1/country/DE
GET /wp-json/ergonosphera/v1/themes
GET /wp-json/ergonosphera/v1/{theme-id}/country/{code}</code></pre>
            </div>

            <a href="<?php echo esc_url( home_url( '/api-docs/' ) ); ?>" class="ergo-btn ergo-btn--outline">
                <?php echo esc_html( 'Полная документация API' ); ?> &rarr;
            </a>
        </section>

        <!-- License -->
        <section class="ergo-license-section">
            <h2 class="ergo-section-title"><?php echo esc_html( 'Лицензия и цитирование' ); ?></h2>
            <div class="ergo-license-content">
                <div class="ergo-license-block">
                    <h3><?php echo esc_html( 'Лицензия на данные' ); ?></h3>
                    <p><?php echo esc_html( 'Если не указано иное, наборы данных предоставляются по лицензии Creative Commons Attribution 4.0 (CC BY 4.0). Проверьте лицензии отдельных наборов данных, так как они могут отличаться в зависимости от плагина.' ); ?></p>
                </div>
                <div class="ergo-license-block">
                    <h3><?php echo esc_html( 'Как цитировать' ); ?></h3>
                    <pre class="ergo-code"><code>@misc{ergonosphera,
  title = {Ergonosphera Data Platform},
  url = {<?php echo esc_url( home_url() ); ?>},
  year = {<?php echo esc_html( gmdate( 'Y' ) ); ?>}
}</code></pre>
                </div>
            </div>
        </section>

    </div>
</main>

<?php get_footer();
