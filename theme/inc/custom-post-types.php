<?php
/**
 * Custom Post Types and Taxonomies
 * 
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Country post type
 */
function ergo_register_post_types() {
    $labels = array(
        'name'               => 'Страны',
        'singular_name'      => 'Страна',
        'add_new'            => 'Добавить страну',
        'add_new_item'       => 'Добавить новую страну',
        'edit_item'          => 'Редактировать страну',
        'view_item'          => 'Просмотреть страну',
        'all_items'          => 'Все страны',
        'search_items'       => 'Поиск стран',
        'not_found'          => 'Страны не найдены',
        'not_found_in_trash' => 'В корзине стран не найдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'country', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-site-alt3',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
    );

    register_post_type( 'country', $args );

    // Конференции
    $conf_labels = array(
        'name'               => 'Конференции',
        'singular_name'      => 'Конференция',
        'add_new'            => 'Добавить конференцию',
        'add_new_item'       => 'Добавить конференцию',
        'edit_item'          => 'Редактировать конференцию',
        'view_item'          => 'Просмотреть конференцию',
        'all_items'          => 'Все конференции',
        'search_items'       => 'Поиск конференций',
        'not_found'          => 'Конференции не найдены',
        'not_found_in_trash' => 'В корзине конференций не найдено',
    );
    $conf_args = array(
        'labels'             => $conf_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'conferences', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    );
    register_post_type( 'conference', $conf_args );

    // Region taxonomy
    register_taxonomy( 'region', 'country', array(
        'labels' => array(
            'name'          => 'Регионы',
            'singular_name' => 'Регион',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'region' ),
    ) );

    // ─── Новости (ergo_news) ──────────────────────────────────────────
    register_post_type( 'ergo_news', array(
        'labels' => array(
            'name'               => 'Новости',
            'singular_name'      => 'Новость',
            'add_new'            => 'Добавить новость',
            'add_new_item'       => 'Добавить новость',
            'edit_item'          => 'Редактировать новость',
            'view_item'          => 'Просмотреть новость',
            'all_items'          => 'Все новости',
            'search_items'       => 'Поиск новостей',
            'not_found'          => 'Новости не найдены',
            'not_found_in_trash' => 'В корзине новостей не найдено',
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'news', 'with_front' => false ),
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-megaphone',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    // ─── Справочники (ergo_directory) ─────────────────────────────────
    register_post_type( 'ergo_directory', array(
        'labels' => array(
            'name'               => 'Справочники',
            'singular_name'      => 'Справочник',
            'add_new'            => 'Добавить справочник',
            'add_new_item'       => 'Добавить справочник',
            'edit_item'          => 'Редактировать справочник',
            'view_item'          => 'Просмотреть справочник',
            'all_items'          => 'Все справочники',
            'search_items'       => 'Поиск справочников',
            'not_found'          => 'Справочники не найдены',
            'not_found_in_trash' => 'В корзине справочников не найдено',
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'directories', 'with_front' => false ),
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    register_taxonomy( 'directory_type', 'ergo_directory', array(
        'labels' => array(
            'name'          => 'Типы справочников',
            'singular_name' => 'Тип справочника',
            'add_new_item'  => 'Добавить тип',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'directory-type' ),
    ) );

    // ─── Семинары (ergo_seminar) ──────────────────────────────────────
    register_post_type( 'ergo_seminar', array(
        'labels' => array(
            'name'               => 'Семинары',
            'singular_name'      => 'Семинар',
            'add_new'            => 'Добавить семинар',
            'add_new_item'       => 'Добавить семинар',
            'edit_item'          => 'Редактировать семинар',
            'view_item'          => 'Просмотреть семинар',
            'all_items'          => 'Все семинары',
            'search_items'       => 'Поиск семинаров',
            'not_found'          => 'Семинары не найдены',
            'not_found_in_trash' => 'В корзине семинаров не найдено',
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'seminars', 'with_front' => false ),
        'menu_position'      => 9,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    register_taxonomy( 'seminar_type', 'ergo_seminar', array(
        'labels' => array(
            'name'          => 'Типы семинаров',
            'singular_name' => 'Тип семинара',
            'add_new_item'  => 'Добавить тип',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'seminar-type' ),
    ) );

    // ─── Учёные (ergo_scientist) ──────────────────────────────────────
    register_post_type( 'ergo_scientist', array(
        'labels' => array(
            'name'               => 'Учёные',
            'singular_name'      => 'Учёный',
            'add_new'            => 'Добавить учёного',
            'add_new_item'       => 'Добавить учёного',
            'edit_item'          => 'Редактировать учёного',
            'view_item'          => 'Просмотреть учёного',
            'all_items'          => 'Все учёные',
            'search_items'       => 'Поиск учёных',
            'not_found'          => 'Учёные не найдены',
            'not_found_in_trash' => 'В корзине учёных не найдено',
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'scientists', 'with_front' => false ),
        'menu_position'      => 10,
        'menu_icon'          => 'dashicons-id-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    // ─── Библиотеки (ergo_library) ───────────────────────────────────
    register_post_type( 'ergo_library', array(
        'labels' => array(
            'name'               => 'Библиотеки',
            'singular_name'      => 'Библиотека',
            'add_new'            => 'Добавить библиотеку',
            'add_new_item'       => 'Добавить библиотеку',
            'edit_item'          => 'Редактировать библиотеку',
            'view_item'          => 'Просмотреть библиотеку',
            'all_items'          => 'Все библиотеки',
            'search_items'       => 'Поиск библиотек',
            'not_found'          => 'Библиотеки не найдены',
            'not_found_in_trash' => 'В корзине библиотек не найдено',
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'libraries', 'with_front' => false ),
        'menu_position'      => 11,
        'menu_icon'          => 'dashicons-book',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    register_taxonomy( 'library_type', 'ergo_library', array(
        'labels' => array(
            'name'          => 'Типы библиотек',
            'singular_name' => 'Тип библиотеки',
            'add_new_item'  => 'Добавить тип',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'library-type' ),
    ) );

    // ─── Рабочие программы дисциплин (ergo_work_program) ─────────────────
    register_post_type( 'ergo_work_program', array(
        'labels' => array(
            'name'               => 'Рабочие программы',
            'singular_name'      => 'Рабочая программа',
            'add_new'            => 'Добавить программу',
            'add_new_item'       => 'Добавить рабочую программу',
            'edit_item'          => 'Редактировать программу',
            'view_item'          => 'Просмотреть программу',
            'all_items'          => 'Все рабочие программы',
            'search_items'       => 'Поиск программ',
            'not_found'          => 'Рабочие программы не найдены',
            'not_found_in_trash' => 'В корзине программ не найдено',
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'rabochee-programmy', 'with_front' => false ),
        'menu_position'      => 12,
        'menu_icon'          => 'dashicons-welcome-write-blog',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    register_taxonomy( 'work_program_level', 'ergo_work_program', array(
        'labels' => array(
            'name'          => 'Уровень',
            'singular_name' => 'Уровень',
            'add_new_item'  => 'Добавить уровень',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'level' ),
    ) );
}
add_action( 'init', 'ergo_register_post_types' );

/**
 * Мета конференции: дата, место, кнопки, табы
 */
function ergo_register_conference_meta() {
    $fields = array(
        'conference_date'               => 'string',
        'conference_place'               => 'string',
        'conference_organizer'           => 'string',
        'conference_url'                 => 'string',
        'conference_announcement'        => 'string',
        'conference_info_letter_url'     => 'string',
        'conference_registration_url'    => 'string',
        'conference_tab_requirements'    => 'string',
        'conference_tab_program_committee'   => 'string',
        'conference_tab_organizing_committee' => 'string',
        'conference_tab_program'         => 'string',
        'conference_tab_contacts'        => 'string',
    );
    foreach ( $fields as $key => $type ) {
        register_post_meta( 'conference', $key, array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
        ) );
    }
}
add_action( 'init', 'ergo_register_conference_meta' );

/**
 * Register meta fields for countries
 */
function ergo_register_country_meta() {
    $meta_fields = array(
        'country_code'    => 'string',
        'country_code_3'  => 'string',
        'capital'         => 'string',
        'region'          => 'string',
        'subregion'       => 'string',
        'latitude'        => 'number',
        'longitude'       => 'number',
        'flag_emoji'      => 'string',
        'flag_svg'        => 'string',
        'population'      => 'integer',
        'area_km2'        => 'number',
    );

    foreach ( $meta_fields as $key => $type ) {
        register_post_meta( 'country', $key, array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
        ) );
    }
}
add_action( 'init', 'ergo_register_country_meta' );

/**
 * Add meta boxes for country editing
 */
function ergo_country_meta_boxes() {
    add_meta_box(
        'ergo_country_info',
        'Информация о стране',
        'ergo_country_info_callback',
        'country',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'ergo_country_meta_boxes' );

/**
 * Мета-боксы конференции
 */
function ergo_conference_meta_boxes() {
    add_meta_box(
        'ergo_conference_info',
        'Дата и место проведения',
        'ergo_conference_info_callback',
        'conference',
        'normal',
        'high'
    );
    add_meta_box(
        'ergo_conference_details',
        'Подробности мероприятия (кнопки и табы)',
        'ergo_conference_details_callback',
        'conference',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'ergo_conference_meta_boxes' );

function ergo_conference_info_callback( $post ) {
    wp_nonce_field( 'ergo_conference_meta', 'ergo_conference_meta_nonce' );
    $date  = get_post_meta( $post->ID, 'conference_date', true );
    $place = get_post_meta( $post->ID, 'conference_place', true );
    $org   = get_post_meta( $post->ID, 'conference_organizer', true );
    $url   = get_post_meta( $post->ID, 'conference_url', true );
    ?>
    <p>
        <label for="conference_date">Дата проведения</label><br>
        <input type="text" id="conference_date" name="conference_date" value="<?php echo esc_attr( $date ); ?>" class="regular-text" placeholder="например: 18—20 июня 2026">
    </p>
    <p>
        <label for="conference_place">Место проведения</label><br>
        <input type="text" id="conference_place" name="conference_place" value="<?php echo esc_attr( $place ); ?>" class="regular-text" placeholder="например: Санкт-Петербург, СПбГУ">
    </p>
    <p>
        <label for="conference_organizer">Организатор</label><br>
        <input type="text" id="conference_organizer" name="conference_organizer" value="<?php echo esc_attr( $org ); ?>" class="regular-text" placeholder="например: МГУ, ФГП">
    </p>
    <p>
        <label for="conference_url">Сайт конференции</label><br>
        <input type="url" id="conference_url" name="conference_url" value="<?php echo esc_attr( $url ); ?>" class="regular-text" placeholder="https://...">
    </p>
    <?php
}

function ergo_conference_details_callback( $post ) {
    wp_nonce_field( 'ergo_conference_details_meta', 'ergo_conference_details_nonce' );
    $announcement = get_post_meta( $post->ID, 'conference_announcement', true );
    $info_letter  = get_post_meta( $post->ID, 'conference_info_letter_url', true );
    $registration = get_post_meta( $post->ID, 'conference_registration_url', true );
    $tab_req      = get_post_meta( $post->ID, 'conference_tab_requirements', true );
    $tab_prog_comm = get_post_meta( $post->ID, 'conference_tab_program_committee', true );
    $tab_org_comm  = get_post_meta( $post->ID, 'conference_tab_organizing_committee', true );
    $tab_program   = get_post_meta( $post->ID, 'conference_tab_program', true );
    $tab_contacts  = get_post_meta( $post->ID, 'conference_tab_contacts', true );
    ?>
    <p>
        <label for="conference_announcement"><strong>Важное объявление</strong></label><br>
        <input type="text" id="conference_announcement" name="conference_announcement" value="<?php echo esc_attr( $announcement ); ?>" class="large-text" placeholder="например: Приём заявок продлен до 30 декабря 2025 года">
    </p>
    <p><strong>Кнопки действий:</strong></p>
    <p>
        <label for="conference_info_letter_url">Информационное письмо (ссылка)</label><br>
        <input type="url" id="conference_info_letter_url" name="conference_info_letter_url" value="<?php echo esc_attr( $info_letter ); ?>" class="large-text" placeholder="https://...">
    </p>
    <p>
        <label for="conference_registration_url">Регистрация (ссылка)</label><br>
        <input type="url" id="conference_registration_url" name="conference_registration_url" value="<?php echo esc_attr( $registration ); ?>" class="large-text" placeholder="https://...">
    </p>
    <hr>
    <p><strong>Табы «Подробнее о мероприятии» (можно оставить пустыми — таб не покажется):</strong></p>
    <p>
        <label for="conference_tab_requirements">Требования к статьям</label><br>
        <?php wp_editor( $tab_req, 'conference_tab_requirements', array( 'textarea_rows' => 6, 'media_buttons' => true ) ); ?>
    </p>
    <p>
        <label for="conference_tab_program_committee">Программный комитет</label><br>
        <?php wp_editor( $tab_prog_comm, 'conference_tab_program_committee', array( 'textarea_rows' => 6, 'media_buttons' => true ) ); ?>
    </p>
    <p>
        <label for="conference_tab_organizing_committee">Организационный комитет</label><br>
        <?php wp_editor( $tab_org_comm, 'conference_tab_organizing_committee', array( 'textarea_rows' => 6, 'media_buttons' => true ) ); ?>
    </p>
    <p>
        <label for="conference_tab_program">Предварительная программа</label><br>
        <?php wp_editor( $tab_program, 'conference_tab_program', array( 'textarea_rows' => 8, 'media_buttons' => true ) ); ?>
    </p>
    <p>
        <label for="conference_tab_contacts">Контакты</label><br>
        <?php wp_editor( $tab_contacts, 'conference_tab_contacts', array( 'textarea_rows' => 4, 'media_buttons' => false ) ); ?>
    </p>
    <?php
}

function ergo_save_conference_meta( $post_id ) {
    if ( ! isset( $_POST['ergo_conference_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ergo_conference_meta_nonce'], 'ergo_conference_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['conference_date'] ) ) update_post_meta( $post_id, 'conference_date', sanitize_text_field( $_POST['conference_date'] ) );
    if ( isset( $_POST['conference_place'] ) ) update_post_meta( $post_id, 'conference_place', sanitize_text_field( $_POST['conference_place'] ) );
    if ( isset( $_POST['conference_organizer'] ) ) update_post_meta( $post_id, 'conference_organizer', sanitize_text_field( $_POST['conference_organizer'] ) );
    if ( isset( $_POST['conference_url'] ) ) update_post_meta( $post_id, 'conference_url', esc_url_raw( $_POST['conference_url'] ) );
}
add_action( 'save_post_conference', 'ergo_save_conference_meta' );

function ergo_save_conference_details_meta( $post_id ) {
    if ( ! isset( $_POST['ergo_conference_details_nonce'] ) || ! wp_verify_nonce( $_POST['ergo_conference_details_nonce'], 'ergo_conference_details_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    $keys = array(
        'conference_announcement', 'conference_info_letter_url', 'conference_registration_url',
        'conference_tab_requirements', 'conference_tab_program_committee', 'conference_tab_organizing_committee',
        'conference_tab_program', 'conference_tab_contacts',
    );
    foreach ( $keys as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            $val = $_POST[ $key ];
            if ( in_array( $key, array( 'conference_info_letter_url', 'conference_registration_url' ), true ) ) {
                $val = esc_url_raw( $val );
            } else {
                $val = wp_kses_post( $val );
            }
            update_post_meta( $post_id, $key, $val );
        }
    }
}
add_action( 'save_post_conference', 'ergo_save_conference_details_meta' );

/**
 * Country info meta box callback
 */
function ergo_country_info_callback( $post ) {
    wp_nonce_field( 'ergo_country_meta', 'ergo_country_meta_nonce' );

    $fields = array(
        'country_code'   => array( 'label' => 'Код ISO (2 буквы)', 'type' => 'text' ),
        'country_code_3' => array( 'label' => 'Код ISO (3 буквы)', 'type' => 'text' ),
        'capital'        => array( 'label' => 'Столица', 'type' => 'text' ),
        'flag_emoji'     => array( 'label' => 'Флаг (эмодзи)', 'type' => 'text' ),
        'latitude'       => array( 'label' => 'Широта', 'type' => 'number' ),
        'longitude'      => array( 'label' => 'Долгота', 'type' => 'number' ),
        'population'     => array( 'label' => 'Население', 'type' => 'number' ),
        'area_km2'       => array( 'label' => 'Площадь (км²)', 'type' => 'number' ),
    );

    echo '<table class="form-table"><tbody>';
    foreach ( $fields as $key => $field ) {
        $value = get_post_meta( $post->ID, $key, true );
        printf(
            '<tr><th><label for="%1$s">%2$s</label></th><td><input type="%3$s" id="%1$s" name="%1$s" value="%4$s" class="regular-text" step="any"></td></tr>',
            esc_attr( $key ),
            esc_html( $field['label'] ),
            esc_attr( $field['type'] ),
            esc_attr( $value )
        );
    }
    echo '</tbody></table>';
}

/**
 * Save country meta
 */
function ergo_save_country_meta( $post_id ) {
    if ( ! isset( $_POST['ergo_country_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ergo_country_meta_nonce'], 'ergo_country_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array( 'country_code', 'country_code_3', 'capital', 'flag_emoji', 'latitude', 'longitude', 'population', 'area_km2' );
    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }
}
add_action( 'save_post_country', 'ergo_save_country_meta' );

/* =====================================================================
   Мета-поля для новых CPT
   ===================================================================== */

function ergo_register_new_cpt_meta() {
    $meta_map = array(
        'ergo_news'        => array( 'news_date' => 'string', 'news_source' => 'string' ),
        'ergo_directory'   => array( 'directory_author' => 'string', 'directory_year' => 'string', 'directory_isbn' => 'string', 'directory_url' => 'string' ),
        'ergo_seminar'     => array( 'seminar_date' => 'string', 'seminar_place' => 'string', 'seminar_speaker' => 'string' ),
        'ergo_scientist'   => array( 'scientist_position' => 'string', 'scientist_organization' => 'string', 'scientist_email' => 'string', 'scientist_field' => 'string' ),
        'ergo_library'     => array( 'library_url' => 'string', 'library_description' => 'string' ),
        'ergo_work_program' => array(
            'work_program_code' => 'string', 'work_program_level' => 'string', 'work_program_department' => 'string',
            'work_program_year' => 'string', 'work_program_file' => 'string', 'work_program_hours' => 'string',
            'work_program_curriculum' => 'string', 'work_program_goals' => 'string', 'work_program_outcomes' => 'string',
            'work_program_target_audience' => 'string', 'work_program_literature' => 'string',
            'work_program_faq' => 'string', 'work_program_how_it_works' => 'string', 'work_program_modules_count' => 'string',
        ),
    );

    foreach ( $meta_map as $post_type => $fields ) {
        foreach ( $fields as $key => $type ) {
            register_post_meta( $post_type, $key, array(
                'show_in_rest'  => true,
                'single'        => true,
                'type'          => $type,
                'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
            ) );
        }
    }
}
add_action( 'init', 'ergo_register_new_cpt_meta' );

/* =====================================================================
   Мета-боксы новых CPT
   ===================================================================== */

function ergo_new_cpt_meta_boxes() {
    add_meta_box( 'ergo_news_info', 'Дата и источник', 'ergo_news_info_cb', 'ergo_news', 'normal', 'high' );
    add_meta_box( 'ergo_directory_info', 'Информация о справочнике', 'ergo_directory_info_cb', 'ergo_directory', 'normal', 'high' );
    add_meta_box( 'ergo_seminar_info', 'Дата, место и докладчик', 'ergo_seminar_info_cb', 'ergo_seminar', 'normal', 'high' );
    add_meta_box( 'ergo_scientist_info', 'Информация об учёном', 'ergo_scientist_info_cb', 'ergo_scientist', 'normal', 'high' );
    add_meta_box( 'ergo_library_info', 'Информация о библиотеке', 'ergo_library_info_cb', 'ergo_library', 'normal', 'high' );
    add_meta_box( 'ergo_work_program_info', 'Данные рабочей программы', 'ergo_work_program_info_cb', 'ergo_work_program', 'normal', 'high' );
    add_meta_box( 'ergo_work_program_extra', 'Учебный план, цели и результаты', 'ergo_work_program_extra_cb', 'ergo_work_program', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'ergo_new_cpt_meta_boxes' );

function ergo_work_program_extra_cb( $post ) {
    wp_nonce_field( 'ergo_wp_extra', 'ergo_wp_extra_nonce' );
    $goals = get_post_meta( $post->ID, 'work_program_goals', true );
    $curriculum = get_post_meta( $post->ID, 'work_program_curriculum', true );
    $outcomes = get_post_meta( $post->ID, 'work_program_outcomes', true );
    $target = get_post_meta( $post->ID, 'work_program_target_audience', true );
    $literature = get_post_meta( $post->ID, 'work_program_literature', true );
    $faq = get_post_meta( $post->ID, 'work_program_faq', true );
    $how = get_post_meta( $post->ID, 'work_program_how_it_works', true );
    $modules = get_post_meta( $post->ID, 'work_program_modules_count', true );
    ?>
    <p><label><strong>Количество модулей (для блока «Программа обучения»)</strong></label><br>
    <input type="text" name="work_program_modules_count" value="<?php echo esc_attr( $modules ); ?>" class="small-text" placeholder="5"></p>
    <p><label><strong>Цели и задачи освоения дисциплины</strong></label></p>
    <?php wp_editor( $goals, 'work_program_goals', array( 'textarea_rows' => 6 ) ); ?>
    <p><label><strong>Кому подойдёт (карточки целевой аудитории)</strong></label></p>
    <?php wp_editor( $target, 'work_program_target_audience', array( 'textarea_rows' => 8 ) ); ?>
    <p><label><strong>Содержание программы (учебный план, модули и темы)</strong></label></p>
    <?php wp_editor( $curriculum, 'work_program_curriculum', array( 'textarea_rows' => 14 ) ); ?>
    <p><label><strong>Результаты освоения (компетенции)</strong></label></p>
    <?php wp_editor( $outcomes, 'work_program_outcomes', array( 'textarea_rows' => 6 ) ); ?>
    <p><label><strong>Основная и дополнительная литература (со ссылками)</strong></label></p>
    <?php wp_editor( $literature, 'work_program_literature', array( 'textarea_rows' => 8 ) ); ?>
    <p><label><strong>Как проходит обучение (этапы)</strong></label></p>
    <?php wp_editor( $how, 'work_program_how_it_works', array( 'textarea_rows' => 6 ) ); ?>
    <p><label><strong>Вопрос-ответ (FAQ)</strong></label></p>
    <?php wp_editor( $faq, 'work_program_faq', array( 'textarea_rows' => 8 ) ); ?>
    <?php
}

function ergo_render_meta_fields( $post, $fields ) {
    wp_nonce_field( 'ergo_cpt_meta', 'ergo_cpt_meta_nonce' );
    echo '<table class="form-table"><tbody>';
    foreach ( $fields as $key => $field ) {
        $value = get_post_meta( $post->ID, $key, true );
        printf(
            '<tr><th><label for="%1$s">%2$s</label></th><td><input type="%3$s" id="%1$s" name="%1$s" value="%4$s" class="regular-text" placeholder="%5$s"></td></tr>',
            esc_attr( $key ),
            esc_html( $field['label'] ),
            esc_attr( $field['type'] ?? 'text' ),
            esc_attr( $value ),
            esc_attr( $field['placeholder'] ?? '' )
        );
    }
    echo '</tbody></table>';
}

function ergo_news_info_cb( $post ) {
    ergo_render_meta_fields( $post, array(
        'news_date'   => array( 'label' => 'Дата события', 'placeholder' => '10 марта 2026 г.' ),
        'news_source' => array( 'label' => 'Источник', 'placeholder' => 'МГУ, пресс-служба' ),
    ) );
}

function ergo_directory_info_cb( $post ) {
    ergo_render_meta_fields( $post, array(
        'directory_author' => array( 'label' => 'Автор / Редактор', 'placeholder' => 'Чумаков А.Н.' ),
        'directory_year'   => array( 'label' => 'Год издания', 'placeholder' => '2003' ),
        'directory_isbn'   => array( 'label' => 'ISBN', 'placeholder' => '978-5-...' ),
        'directory_url'    => array( 'label' => 'Ссылка', 'placeholder' => 'https://...', 'type' => 'url' ),
    ) );
}

function ergo_seminar_info_cb( $post ) {
    ergo_render_meta_fields( $post, array(
        'seminar_date'    => array( 'label' => 'Дата проведения', 'placeholder' => '25 марта 2026 г., 18:00' ),
        'seminar_place'   => array( 'label' => 'Место', 'placeholder' => 'Москва, МГУ / Онлайн' ),
        'seminar_speaker' => array( 'label' => 'Докладчик', 'placeholder' => 'Иванов М.А.' ),
    ) );
}

function ergo_scientist_info_cb( $post ) {
    ergo_render_meta_fields( $post, array(
        'scientist_position'     => array( 'label' => 'Должность', 'placeholder' => 'Профессор' ),
        'scientist_organization' => array( 'label' => 'Организация', 'placeholder' => 'МГУ имени М.В. Ломоносова' ),
        'scientist_email'        => array( 'label' => 'Email', 'placeholder' => 'email@example.com', 'type' => 'email' ),
        'scientist_field'        => array( 'label' => 'Область исследований', 'placeholder' => 'Глобалистика, философия' ),
    ) );
}

function ergo_library_info_cb( $post ) {
    ergo_render_meta_fields( $post, array(
        'library_url'         => array( 'label' => 'URL библиотеки', 'placeholder' => 'https://elibrary.ru', 'type' => 'url' ),
        'library_description' => array( 'label' => 'Краткое описание', 'placeholder' => 'Крупнейшая библиотека...' ),
    ) );
}

function ergo_work_program_info_cb( $post ) {
    ergo_render_meta_fields( $post, array(
        'work_program_code'       => array( 'label' => 'Код дисциплины', 'placeholder' => 'Б1.О.01' ),
        'work_program_level'      => array( 'label' => 'Уровень', 'placeholder' => 'Бакалавриат / Магистратура' ),
        'work_program_department' => array( 'label' => 'Кафедра / Направление', 'placeholder' => 'Философский факультет' ),
        'work_program_year'       => array( 'label' => 'Год', 'placeholder' => '2025' ),
        'work_program_hours'      => array( 'label' => 'Академических часов', 'placeholder' => '72' ),
        'work_program_file'       => array( 'label' => 'Ссылка на PDF', 'placeholder' => 'https://...', 'type' => 'url' ),
    ) );
}

/**
 * Сохранение мета-полей всех новых CPT.
 */
function ergo_save_new_cpt_meta( $post_id ) {
    if ( ! isset( $_POST['ergo_cpt_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ergo_cpt_meta_nonce'], 'ergo_cpt_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $all_fields = array(
        'news_date', 'news_source',
        'directory_author', 'directory_year', 'directory_isbn', 'directory_url',
        'seminar_date', 'seminar_place', 'seminar_speaker',
        'scientist_position', 'scientist_organization', 'scientist_email', 'scientist_field',
        'library_url', 'library_description',
        'work_program_code', 'work_program_level', 'work_program_department', 'work_program_year', 'work_program_hours', 'work_program_file',
    );

    foreach ( $all_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }
}
add_action( 'save_post_ergo_news', 'ergo_save_new_cpt_meta' );
add_action( 'save_post_ergo_directory', 'ergo_save_new_cpt_meta' );
add_action( 'save_post_ergo_seminar', 'ergo_save_new_cpt_meta' );
add_action( 'save_post_ergo_scientist', 'ergo_save_new_cpt_meta' );
add_action( 'save_post_ergo_library', 'ergo_save_new_cpt_meta' );
add_action( 'save_post_ergo_work_program', 'ergo_save_new_cpt_meta' );

function ergo_save_work_program_extra( $post_id ) {
    if ( ! isset( $_POST['ergo_wp_extra_nonce'] ) || ! wp_verify_nonce( $_POST['ergo_wp_extra_nonce'], 'ergo_wp_extra' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    $html_keys = array( 'work_program_goals', 'work_program_curriculum', 'work_program_outcomes',
        'work_program_target_audience', 'work_program_literature', 'work_program_faq', 'work_program_how_it_works' );
    foreach ( $html_keys as $key ) {
        if ( isset( $_POST[ $key ] ) ) update_post_meta( $post_id, $key, wp_kses_post( $_POST[ $key ] ) );
    }
    if ( isset( $_POST['work_program_modules_count'] ) ) update_post_meta( $post_id, 'work_program_modules_count', sanitize_text_field( $_POST['work_program_modules_count'] ) );
}
add_action( 'save_post_ergo_work_program', 'ergo_save_work_program_extra' );

/**
 * Фильтр архивa рабочих программ по уровню (?level=...)
 */
function ergo_filter_work_programs_by_level( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'ergo_work_program' ) ) {
        $level = isset( $_GET['level'] ) ? sanitize_text_field( wp_unslash( $_GET['level'] ) ) : '';
        if ( $level ) {
            $query->set( 'meta_query', array(
                array( 'key' => 'work_program_level', 'value' => $level, 'compare' => '=' ),
            ) );
        }
    }
}
add_action( 'pre_get_posts', 'ergo_filter_work_programs_by_level' );
