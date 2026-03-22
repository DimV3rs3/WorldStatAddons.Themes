<?php
/**
 * Component: Table Section
 * 
 * Sortable, searchable table via DataTables
 * 
 * @package Ergonosphera
 * @var array $section Section data
 * @var int   $section_index
 */

defined( 'ABSPATH' ) || exit;

$table_id = 'ergo-table-' . $section_index . '-' . wp_rand( 1000, 9999 );
$headers  = $section['headers'] ?? array();
$rows     = $section['rows'] ?? array();
?>
<div class="ergo-section ergo-section--table" id="section-<?php echo esc_attr( $section_index ); ?>">
    <?php if ( ! empty( $section['title'] ) ) : ?>
        <h3 class="ergo-section__title"><?php echo esc_html( $section['title'] ); ?></h3>
    <?php endif; ?>

    <div class="ergo-table-responsive">
        <table id="<?php echo esc_attr( $table_id ); ?>" class="ergo-table ergo-datatable">
            <?php if ( ! empty( $headers ) ) : ?>
                <thead>
                    <tr>
                        <?php foreach ( $headers as $header ) : ?>
                            <th><?php echo esc_html( $header ); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
            <?php endif; ?>
            <tbody>
                <?php foreach ( $rows as $row ) : ?>
                    <tr>
                        <?php foreach ( (array) $row as $cell ) : ?>
                            <td><?php echo esc_html( $cell ); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="ergo-table-actions">
        <button class="ergo-btn ergo-btn--sm ergo-btn--ghost ergo-table-export" data-table="<?php echo esc_attr( $table_id ); ?>" data-format="csv">
            Экспорт CSV
        </button>
    </div>
</div>
