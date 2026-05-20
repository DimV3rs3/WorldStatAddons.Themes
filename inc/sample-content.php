<?php
/**
 * Демо-контент: страницы, записи, конференции, новые CPT.
 * SVG-плейсхолдеры удалены — пользователь назначает изображения через Медиабиблиотеку.
 *
 * @package Ergonosphera
 */

defined( 'ABSPATH' ) || exit;

function ergo_maybe_create_sample_content() {
    if ( get_option( 'ergo_sample_v7', false ) ) {
        return;
    }
    if ( ! current_user_can( 'edit_posts' ) ) {
        return;
    }
    ergo_create_sample_content();
    update_option( 'ergo_sample_v7', true );
}
add_action( 'admin_init', 'ergo_maybe_create_sample_content', 99 );

/**
 * Создаёт одну оформленную демо-конференцию (шаблон events.spbu.ru)
 * Выполняется один раз при посещении админки.
 */
function ergo_maybe_create_demo_conference() {
    if ( ! current_user_can( 'edit_posts' ) ) return;
    if ( get_option( 'ergo_demo_conference_created', false ) ) return;

    // Сначала обновить старые конференции
    ergo_upgrade_old_conferences();

    $title = 'IX Российский философский конгресс «Философия в контексте современных вызовов»';
    if ( ergo_post_exists_by_title( $title, 'conference' ) ) {
        update_option( 'ergo_demo_conference_created', true );
        return;
    }

    $meta = array(
        'conference_date'                 => '18—20 июня 2026',
        'conference_place'                => 'Санкт-Петербург, СПбГУ',
        'conference_organizer'            => 'СПбГУ, Институт философии',
        'conference_url'                 => 'https://events.spbu.ru/philosophy-congress',
        'conference_announcement'        => 'В связи с многочисленными обращениями философского сообщества приём заявок, статей и орг.взносов продлен до 30 декабря 2025 года.',
        'conference_info_letter_url'     => 'https://events.spbu.ru/philosophy-congress',
        'conference_registration_url'     => 'https://events.spbu.ru/philosophy-congress',
        'conference_tab_requirements'     => '<p><strong>Требования к оформлению статей</strong></p><p>От одного автора принимается не более 2-х статей. Количество соавторов — не более 2-х человек. К опубликованию принимаются статьи объемом от 10 до 12 тыс. знаков с пробелами, выполненные в редакторе Microsoft Word.</p><p><strong>Параметры форматирования:</strong></p><ul><li>поля 20 мм со всех сторон</li><li>шрифт Times New Roman, размер — 12</li><li>межстрочный интервал — одинарный</li><li>выравнивание текста по ширине</li><li>ориентация листа — книжная</li></ul>',
        'conference_tab_program_committee' => '<p><strong>Председатели:</strong></p><ul><li>Кропачев Николай Михайлович, д.ю.н., проф., чл.-корр. РАН, ректор СПбГУ (Санкт-Петербург)</li><li>Смирнов Андрей Вадимович, д.филос.н., акад. РАН, президент РФО, ВРИО первого заместителя ИФ РАН (Москва)</li></ul><p><strong>Сопредседатели:</strong></p><ul><li>Гусейнов Абдусалам Абдулкеримович, акад. РАН, д.филос.н., проф., ВРИО Директора Института философии РАН, вице-президент РФО (Москва)</li><li>Лекторский Владислав Александрович, акад. РАН, д.филос.н., проф., г.н.с. Института философии РАН, вице-президент РФО (Москва)</li></ul>',
        'conference_tab_organizing_committee' => '<p><strong>Председатель:</strong> Кузнецов Никита Всеволодович, д.филос.н., проф., директор Института философии СПбГУ, вице-президент РФО (Санкт-Петербург).</p><p><strong>Сопредседатель:</strong> Резник Юрий Михайлович, д.филос.н., проф., главный научный сотрудник ИФ РАН, вице-президент РФО (Москва).</p><p><strong>Заместитель председателя:</strong> Сунами Артём Николаевич, к.полит.н., доцент, заместитель директора Института философии СПбГУ (Санкт-Петербург).</p>',
        'conference_tab_program'          => '<h4>18 июня 2026</h4><p><strong>ПЛЕНАРНОЕ ЗАСЕДАНИЕ</strong></p><p>11:00−11:40 Приветственные слова</p><p>11:40−14:00 Пленарные доклады</p><p>14:00−15:30 Обед</p><p>16:00−18:00 Конференция РФО. Вручение почетных грамот</p><h4>19 июня 2026</h4><p><strong>СЕКЦИИ И КРУГЛЫЕ СТОЛЫ</strong></p><p>11:00−19:00 Работа секций и круглых столов. Обеденный перерыв 14:00−15:00</p><h4>20 июня 2026</h4><p>11:00−14:00 Заключительное пленарное заседание в форме дискуссии «Вызовы для российской философии»</p><p>14:00−15:00 Обеденный перерыв</p><p>18:00 Заседание Президиума РФО</p>',
        'conference_tab_contacts'          => '<p><strong>По вопросам регистрации, программы и участия:</strong></p><p>Сунами Артём Николаевич<br>К.п.н., доцент кафедры конфликтологии<br>rfk-2026@spbu.ru<br>+7 (812) 363-60-00</p><p><strong>По вопросам организации мероприятия:</strong></p><p>Смирнова Юлия Владимировна<br>y.v.smirnova@spbu.ru<br>+7 (812) 363-60-44</p>',
    );

    $content = '<p>27 ноября 2024 года Президиум РФО принял решение о переносе IX Российского философского конгресса «Философия в контексте современных вызовов» в Санкт-Петербурге. Конгресс пройдёт на базе Санкт-Петербургского государственного университета (СПбГУ).</p><p>Сообщаем, что принять участие в конгрессе имеют право все, кто оплатит регистрационные взносы. Участие в конгрессе может быть различным: очным и/или в качестве автора публикации. Дистанционное участие не предусмотрено.</p><p>Все доклады проходят двойное слепое рецензирование. Регистрационный взнос является обязательным условием участия с докладом. Оплата проезда и проживания участников осуществляется за счет направляющей стороны.</p>';

    $id = ergo_insert_cpt( $title, 'conference', $content, mb_substr( wp_strip_all_tags( $content ), 0, 160 ), $meta );
    if ( $id && ! is_wp_error( $id ) ) {
        update_option( 'ergo_demo_conference_created', true );
    }
}
add_action( 'admin_init', 'ergo_maybe_create_demo_conference', 100 );

/**
 * Заполняет программу «Глобалистика» полным контентом в стиле academy.dpomipk.ru
 */
function ergo_maybe_populate_globalistika_program() {
    if ( ! current_user_can( 'edit_posts' ) ) return;
    if ( get_option( 'ergo_globalistika_populated_v2', false ) ) return;

    $posts = get_posts( array( 'post_type' => 'ergo_work_program', 'posts_per_page' => -1 ) );
    $post = null;
    foreach ( $posts as $p ) {
        if ( $p->post_title === 'Глобалистика: теория, история и основные проблемы человечества' ) {
            $post = $p;
            break;
        }
    }
    if ( ! $post ) return;

    $programs_url = ergo_get_page_url( 'programmi-kursov' ) ?: get_post_type_archive_link( 'ergo_work_program' );
    $archive_url = get_post_type_archive_link( 'ergo_work_program' );
    $directories_url = get_post_type_archive_link( 'ergo_directory' ) ?: ergo_get_page_url( 'spravochnaya-literatura' );
    $conf_url = get_post_type_archive_link( 'conference' ) ?: ergo_get_page_url( 'konferencii' );
    $prog_link = $programs_url ? '<a href="' . esc_url( $programs_url ) . '">каталоге рабочих программ</a>' : 'разделе рабочих программ';
    $enc_all = get_posts( array( 'post_type' => 'ergo_directory', 'posts_per_page' => -1 ) );
    $enc_url = $directories_url ?: '#';
    foreach ( $enc_all as $ep ) {
        if ( $ep->post_title === 'Глобалистика: Энциклопедия' ) {
            $enc_url = get_permalink( $ep );
            break;
        }
    }

    $content = '<p>Дисциплина «Глобалистика» знакомит студентов с основными теоретическими подходами к изучению глобальных процессов, историей формирования глобалистики как междисциплинарной области знания и ключевыми проблемами современного человечества.</p><p>Курс формирует целостное представление о глобальных процессах, методах их исследования и возможностях применения полученных знаний. Студенты осваивают понятийный аппарат глобалистики, учатся анализировать современные вызовы и ориентироваться в актуальной научной литературе. Подробнее о других дисциплинах — в ' . $prog_link . '. Актуальные мероприятия — в <a href="' . ( $conf_url ? esc_url( $conf_url ) : '#' ) . '">разделе конференций</a>.</p>';

    $goals = '<p><strong>Цель освоения дисциплины</strong> — формирование у обучающихся систематизированных знаний о глобальных процессах, их истории, теоретическом осмыслении и практическом значении.</p><p><strong>Задачи:</strong></p><ul><li>ознакомить с основными понятиями и категориями глобалистики</li><li>раскрыть теоретические подходы к изучению глобальных процессов</li><li>сформировать представление об истории глобализации и глобальных проблемах</li><li>развить навыки анализа глобальных явлений и процессов</li></ul>';

    $target = '<div class="ergo-target-grid"><div class="ergo-target-card"><h4>Студентам бакалавриата</h4><p>Освоите базовые концепции глобалистики и получите междисциплинарную основу для дальнейшего изучения глобальных процессов.</p></div><div class="ergo-target-card"><h4>Будущим исследователям</h4><p>Сформируете теоретическую базу для научной работы в области глобальных исследований и международных отношений.</p></div><div class="ergo-target-card"><h4>Специалистам смежных областей</h4><p>Познакомитесь с глобальным контекстом и сможете применять знания в политологии, экономике, социологии, экологии.</p></div></div>';

    $curriculum = '<ol>
<li><strong>Введение в глобалистику</strong>
<p><strong>Модуль I. Предмет и метод глобалистики</strong><br>Тема 1. Глобалистика как междисциплинарная область. Основные понятия: глобализация, глобальные процессы, глобальные проблемы.<br>Тема 2. Методология глобальных исследований. Междисциплинарный синтез.<br>Тема 3. История формирования глобалистики как научного направления.</p>
<p><em>Практические задания:</em> подготовить реферат по одной из ключевых концепций глобалистики.</p></li>
<li><strong>Теоретические основы глобальных исследований</strong>
<p><strong>Модуль II. Основные теоретические парадигмы</strong><br>Тема 1. Модернизационная парадигма и теории развития.<br>Тема 2. Мир-системный анализ И. Валлерстайна.<br>Тема 3. Теории глобализации: гиперглобалисты, скептики, трансформационалисты.<br>Тема 4. Критические и постколониальные подходы.</p></li>
<li><strong>История глобальных процессов</strong>
<p><strong>Модуль III. Этапы глобализации</strong><br>Тема 1. Предыстория глобализации. Великие цивилизации древности.<br>Тема 2. Эпоха великих географических открытий и формирование мировой торговли.<br>Тема 3. Промышленная революция и колониализм.<br>Тема 4. Современная фаза глобализации (с конца XX в.).</p></li>
<li><strong>Глобальные проблемы человечества</strong>
<p><strong>Модуль IV. Классификация и анализ</strong><br>Тема 1. Экологические вызовы: изменение климата, истощение ресурсов.<br>Тема 2. Демография, миграция, урбанизация.<br>Тема 3. Геополитика и глобальное управление.<br>Тема 4. Цели устойчивого развития ООН.</p></li>
<li><strong>Будущее глобального мира</strong>
<p><strong>Модуль V. Сценарии развития</strong><br>Тема 1. Прогнозирование глобальных процессов.<br>Тема 2. Устойчивое развитие и глобальное гражданское общество.<br>Тема 3. Риски и возможности глобализации.</p>
<p><em>Практические задания:</em> подготовить эссе по выбранной глобальной проблеме.</p></li>
</ol>';

    $outcomes = '<p><strong>В результате освоения дисциплины обучающийся должен:</strong></p><ul><li><strong>знать</strong> основные понятия, теории и историю глобалистики</li><li><strong>понимать</strong> логику глобальных процессов и механизмы глобального управления</li><li><strong>уметь</strong> анализировать глобальные явления с междисциплинарных позиций</li><li><strong>владеть</strong> методами критической оценки информации о глобальных процессах</li></ul>';

    $literature = '<p><strong>Основная:</strong></p><ul>
<li>Чумаков А.Н. <a href="https://www.elibrary.ru/" target="_blank" rel="noopener">Глобалистика как область научных исследований</a> // Вопросы философии.</li>
<li>Мазур И.И., Чумаков А.Н. (ред.) <a href="' . esc_url( $enc_url ) . '">Глобалистика: Энциклопедия</a>. М.: Радуга, 2003.</li>
<li>Валлерстайн И. Мир-системный анализ: Введение. М.: Территория будущего, 2006.</li>
</ul><p><strong>Дополнительная:</strong></p><ul>
<li>Бек У. Что такое глобализация? М.: Прогресс-Традиция, 2001.</li>
<li>Гидденс Э. Ускользающий мир: как глобализация меняет нашу жизнь. М.: Весь мир, 2004.</li>
<li>Яковец Ю.В. Глобализация и взаимодействие цивилизаций. М.: Экономика, 2003.</li>
</ul><p>Полный список литературы — в <a href="' . esc_url( get_permalink( $post ) ) . '">рабочей программе дисциплины</a>.</p>';

    $how = '<div class="ergo-how-grid"><div class="ergo-how-item"><span class="ergo-how-icon dashicons dashicons-book"></span><h4>Изучение лекций</h4><p>Теоретический материал по каждому модулю, дополнительные материалы в <a href="' . ( $archive_url ? esc_url( $archive_url ) : '#' ) . '">каталоге программ</a>.</p></div><div class="ergo-how-item"><span class="ergo-how-icon dashicons dashicons-groups"></span><h4>Семинары</h4><p>Обсуждение ключевых тем, дискуссии, презентации.</p></div><div class="ergo-how-item"><span class="ergo-how-icon dashicons dashicons-edit"></span><h4>Практические задания</h4><p>Рефераты, эссе, тесты по модулям.</p></div><div class="ergo-how-item"><span class="ergo-how-icon dashicons dashicons-awards"></span><h4>Контроль знаний</h4><p>Зачёт или экзамен по итогам освоения дисциплины.</p></div></div>';

    $faq = '<div class="ergo-faq-list"><div class="ergo-faq-item"><h4>Нужна ли предварительная подготовка?</h4><p>Дисциплина рассчитана на студентов, освоивших базовый курс философии и имеющих общие представления об истории и обществознании.</p></div><div class="ergo-faq-item"><h4>Какой объём самостоятельной работы?</h4><p>Около 36 часов: подготовка к семинарам, написание реферата и эссе, работа с литературой.</p></div><div class="ergo-faq-item"><h4>Где найти другие рабочие программы?</h4><p>Все программы размещены в <a href="' . ( $programs_url ? esc_url( $programs_url ) : '#' ) . '">разделе «Рабочие программы дисциплин»</a>.</p></div><div class="ergo-faq-item"><h4>Можно ли скачать программу в PDF?</h4><p>Да, ссылка на скачивание размещена в начале страницы и в конце.</p></div></div>';

    wp_update_post( array( 'ID' => $post->ID, 'post_content' => $content, 'post_excerpt' => 'За 1 семестр освойте основы глобалистики: теоретические подходы, историю глобальных процессов и ключевые проблемы современного человечества' ) );
    update_post_meta( $post->ID, 'work_program_hours', '72' );
    update_post_meta( $post->ID, 'work_program_modules_count', '5' );
    update_post_meta( $post->ID, 'work_program_goals', $goals );
    update_post_meta( $post->ID, 'work_program_curriculum', $curriculum );
    update_post_meta( $post->ID, 'work_program_outcomes', $outcomes );
    update_post_meta( $post->ID, 'work_program_target_audience', $target );
    update_post_meta( $post->ID, 'work_program_literature', $literature );
    update_post_meta( $post->ID, 'work_program_how_it_works', $how );
    update_post_meta( $post->ID, 'work_program_faq', $faq );

    update_option( 'ergo_globalistika_populated_v2', true );
}
add_action( 'admin_init', 'ergo_maybe_populate_globalistika_program', 101 );

/**
 * Добавляет поля нового шаблона к старым конференциям (у которых пусты табы)
 */
function ergo_upgrade_old_conferences() {
    if ( get_option( 'ergo_conferences_upgraded', false ) ) return;

    $posts = get_posts( array(
        'post_type'      => 'conference',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ) );

    foreach ( $posts as $post ) {
        $tab_prog = get_post_meta( $post->ID, 'conference_tab_program_committee', true );
        if ( ! empty( $tab_prog ) ) continue; // уже обновлена

        $org = get_post_meta( $post->ID, 'conference_organizer', true );
        $place = get_post_meta( $post->ID, 'conference_place', true );
        $date = get_post_meta( $post->ID, 'conference_date', true );

        $default_comm = '<p><strong>Организатор:</strong> ' . esc_html( $org ?: '—' ) . '</p>';
        $default_comm .= '<p><strong>Место и дата:</strong> ' . esc_html( ( $place ? $place . '. ' : '' ) . ( $date ?: '' ) ) . '</p>';
        $default_comm .= '<p>Подробная информация уточняется.</p>';

        update_post_meta( $post->ID, 'conference_tab_requirements', '<p>Требования к материалам уточняются организатором.</p>' );
        update_post_meta( $post->ID, 'conference_tab_program_committee', $default_comm );
        update_post_meta( $post->ID, 'conference_tab_organizing_committee', $default_comm );
        update_post_meta( $post->ID, 'conference_tab_program', '<h4>Программа</h4><p>Программа формируется. Следите за обновлениями.</p>' );
        update_post_meta( $post->ID, 'conference_tab_contacts', '<p>По вопросам участия обращайтесь к организатору: ' . esc_html( $org ?: '—' ) . '</p>' );
    }

    update_option( 'ergo_conferences_upgraded', true );
}

/* =====================================================================
   Утилиты
   ===================================================================== */

function ergo_post_exists_by_title( $title, $post_type = 'post' ) {
    $q = new WP_Query( array(
        'post_type'              => $post_type,
        'title'                  => $title,
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'fields'                 => 'ids',
    ) );
    return ! empty( $q->posts );
}

function ergo_ensure_category( $name ) {
    $term = term_exists( $name, 'category' );
    if ( $term ) {
        return is_array( $term ) ? (int) $term['term_id'] : (int) $term;
    }
    $result = wp_insert_term( $name, 'category' );
    if ( is_wp_error( $result ) ) {
        return 1;
    }
    return (int) $result['term_id'];
}

function ergo_ensure_term( $name, $taxonomy ) {
    $term = term_exists( $name, $taxonomy );
    if ( $term ) {
        return is_array( $term ) ? (int) $term['term_id'] : (int) $term;
    }
    $result = wp_insert_term( $name, $taxonomy );
    if ( is_wp_error( $result ) ) {
        return 0;
    }
    return (int) $result['term_id'];
}

function ergo_insert_page( $slug, $title, $content, $template = 'page-portal-section.php', $excerpt = '' ) {
    if ( get_page_by_path( $slug, OBJECT, 'page' ) ) {
        return;
    }
    $id = wp_insert_post( array(
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_excerpt' => $excerpt,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => 1,
    ) );
    if ( $id && ! is_wp_error( $id ) ) {
        update_post_meta( $id, '_wp_page_template', $template );
    }
}

function ergo_insert_cpt( $title, $post_type, $content, $excerpt = '', $meta = array() ) {
    if ( ergo_post_exists_by_title( $title, $post_type ) ) {
        return;
    }
    $id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_excerpt' => $excerpt,
        'post_status'  => 'publish',
        'post_type'    => $post_type,
        'post_author'  => 1,
    ) );
    if ( $id && ! is_wp_error( $id ) ) {
        foreach ( $meta as $key => $value ) {
            update_post_meta( $id, $key, $value );
        }
    }
    return $id;
}

/* =====================================================================
   Основная функция создания контента
   ===================================================================== */

function ergo_create_sample_content() {

    // ─── Баннер по умолчанию (без изображения, только текст) ─────────
    if ( ! get_theme_mod( 'ergo_banner_title_1' ) ) {
        set_theme_mod( 'ergo_banner_title_1', 'Платформа визуализации глобальных данных' );
        set_theme_mod( 'ergo_banner_text_1', 'Изучайте статистические данные по странам мира с помощью интерактивных карт и аналитических инструментов' );
    }
    if ( ! get_theme_mod( 'ergo_banner_title_2' ) ) {
        set_theme_mod( 'ergo_banner_title_2', 'Междисциплинарные исследования' );
        set_theme_mod( 'ergo_banner_text_2', 'Объединяем науку, образование и практику для изучения глобальных процессов' );
    }

    // ─── Категории ──────────────────────────────────────────────────
    $cat_news     = ergo_ensure_category( 'Новости' );
    $cat_articles = ergo_ensure_category( 'Статьи' );

    // ─── Таксономии для CPT ─────────────────────────────────────────
    $term_glossary    = ergo_ensure_term( 'Глоссарий', 'directory_type' );
    $term_encyclopedia = ergo_ensure_term( 'Энциклопедия', 'directory_type' );
    $term_reference   = ergo_ensure_term( 'Справочник', 'directory_type' );
    $term_sem_student = ergo_ensure_term( 'Студенческий', 'seminar_type' );
    $term_sem_science = ergo_ensure_term( 'Научный', 'seminar_type' );
    $term_lib_digital = ergo_ensure_term( 'Электронная', 'library_type' );
    $term_lib_ref     = ergo_ensure_term( 'Справочная литература', 'library_type' );
    $term_lib_edu     = ergo_ensure_term( 'Учебная литература', 'library_type' );

    // =================================================================
    // СТРАНИЦЫ — существующие шаблоны
    // =================================================================
    ergo_insert_page( 'novosti', 'Новости',
        '<p>Актуальные новости платформы и события в области глобальных исследований.</p>',
        'page-novosti.php',
        'Актуальные новости и события.'
    );

    ergo_insert_page( 'statyi', 'Интересные статьи',
        '<p>Подборка статей по глобалистике, визуализации данных и смежным темам.</p>',
        'page-statyi.php',
        'Подборка статей по глобалистике.'
    );

    ergo_insert_page( 'konferencii', 'Конференции',
        '<p>Международные и всероссийские конференции по глобальным процессам.</p>',
        'page-konferencii.php',
        'Конференции и конгрессы.'
    );

    // =================================================================
    //  СТУДЕНТАМ (portal pages)
    // =================================================================
    ergo_insert_page( 'o-globalistike', 'О глобалистике',
        '<h2>Что такое глобалистика?</h2>
<p>Термин <strong>«глобалистика»</strong> появился в последней четверти ХХ столетия и означает сферу теоретической и практической деятельности, направленной на осмысление структуры и процессов глобального мира.</p>
<p>В глобалистике выделяются теоретическая и прикладная составляющие:</p>
<ul>
<li><strong>Теоретическая глобалистика</strong> — интегративная область междисциплинарных научных исследований.</li>
<li><strong>Прикладная глобалистика</strong> — совокупность практических действий, ориентированных на преодоление противоречий общечеловеческого характера.</li>
</ul>',
        'page-portal-section.php',
        'Глобалистика: теория, история и основные проблемы человечества.'
    );

    ergo_insert_page( 'studencheskie-seminari', 'Научные студенческие семинары',
        '<h2>Что такое научные студенческие семинары?</h2>
<p>Научные студенческие семинары (НСС) — это платформа, на которой любой может выступить со своим докладом и получить обратную связь. Они открыты для всех: школьников, бакалавров, магистров, аспирантов.</p>',
        'page-portal-section.php',
        'Платформа, на которой любой может выступить со своим докладом.'
    );

    ergo_insert_page( 'programmi-kursov', 'Рабочие программы дисциплин',
        '<h2>Рабочие программы дисциплин (модулей)</h2>
<p>Рабочие программы курсов, связанных с глобалистикой и смежными дисциплинами для бакалавриата и магистратуры. Ниже представлен список доступных программ.</p>',
        'page-programmi-kursov.php',
        'Рабочие программы дисциплин для бакалавриата и магистратуры.'
    );

    ergo_insert_page( 'elektronnye-biblioteki', 'Научные электронные библиотеки',
        '<h2>Важные ресурсы для студентов и исследователей</h2>
<p>Электронные библиотеки — незаменимый инструмент для современного исследователя.</p>',
        'page-portal-section.php',
        'Электронные библиотеки и ресурсы.'
    );

    ergo_insert_page( 'glossariy', 'Глоссарий',
        '<h2>Глоссарий терминов глобалистики</h2>
<p>Словарь наиболее часто встречающихся терминов, понятий и явлений от ведущих авторов.</p>',
        'page-portal-section.php',
        'Словарь понятий, терминов и явлений.'
    );

    ergo_insert_page( 'podkasty', 'Подкасты',
        '<h2>Подкасты об актуальных событиях и проблемах</h2>
<p>В разделе публикуются подкасты на актуальные темы глобалистики.</p>',
        'page-portal-section.php',
        'Подкасты про учёных и глобальные проблемы.'
    );

    // НАУЧНАЯ ЖИЗНЬ
    ergo_insert_page( 'seminar-globalistiki', 'Семинар «Актуальные проблемы глобалистики»',
        '<h2>Междисциплинарный семинар</h2>
<p>Постоянно действующий семинар, посвящённый актуальным проблемам глобалистики. Основан в 2001 году д.ф.н., профессором А.Н. Чумаковым.</p>',
        'page-portal-section.php',
        'Междисциплинарный постоянно действующий семинар по глобалистике.'
    );

    // БИБЛИОТЕКА
    ergo_insert_page( 'spravochnaya-literatura', 'Справочная литература',
        '<h2>Справочные издания по глобалистике</h2>
<p>В данном разделе представлены ключевые справочные издания.</p>',
        'page-portal-section.php',
        'Энциклопедия «Глобалистика», энциклопедический словарь и др.'
    );

    ergo_insert_page( 'uchebnaya-literatura', 'Учебная литература',
        '<h2>Учебная литература</h2>
<p>Учебники и пособия по глобалистике и смежным дисциплинам.</p>',
        'page-portal-section.php',
        'Учебники и пособия по глобалистике.'
    );

    ergo_insert_page( 'literatura-po-globalistike', 'Литература по глобалистике',
        '<h2>Литература по глобалистике</h2>
<p>Литература по четырём основным направлениям.</p>',
        'page-portal-section.php',
        'Естественно-научная, гуманитарная, политическая и экономическая литература.'
    );

    // УЧЁНЫЕ И ОРГАНИЗАЦИИ
    ergo_insert_page( 'uchenye', 'Учёные',
        '<h2>Учёные</h2>
<p>Отечественные и зарубежные учёные, которые внесли свой вклад в развитие глобалистики.</p>',
        'page-portal-section.php',
        'Российские и зарубежные учёные в области глобалистики.'
    );

    ergo_insert_page( 'pozdravleniya', 'Поздравления',
        '<h2>Поздравления</h2>
<p>Дни рождения, юбилеи и знаменательные даты учёных и коллег.</p>',
        'page-portal-section.php',
        'Дни рождения, юбилеи и знаменательные даты.'
    );

    ergo_insert_page( 'pamyati-kolleg', 'Памяти коллег',
        '<h2>Памяти коллег</h2>
<p>Раздел посвящён памяти коллег, которые внесли значительный вклад в развитие глобалистики.</p>',
        'page-portal-section.php',
        'Коллеги, которых мы потеряли.'
    );

    // =================================================================
    //  НОВОСТИ (CPT ergo_news)
    // =================================================================

    $news_items = array(
        array(
            'title'   => 'Запущен новый раздел визуализации данных по экологии',
            'content' => '<p>На платформе появился новый раздел, посвящённый визуализации экологических данных. Теперь пользователи могут отслеживать выбросы CO₂, уровень загрязнения воздуха и водных ресурсов по каждой стране мира.</p>',
            'meta'    => array( 'news_date' => '5 марта 2026 г.', 'news_source' => 'Пресс-служба' ),
        ),
        array(
            'title'   => 'Обновление статистики по странам за 2024 год',
            'content' => '<p>Обновлена база данных по всем странам мира за 2024 год. В обновление вошли демографические показатели, экономическая статистика, данные по образованию и здравоохранению.</p>',
            'meta'    => array( 'news_date' => '20 февраля 2026 г.', 'news_source' => 'Аналитический отдел' ),
        ),
        array(
            'title'   => 'Итоги семинара «Актуальные проблемы глобалистики»',
            'content' => '<p>29 января 2026 года состоялось очередное заседание семинара. Тема: «Искусственный интеллект и глобальное управление». В дискуссии приняли участие более 60 человек из 12 стран.</p>',
            'meta'    => array( 'news_date' => '30 января 2026 г.', 'news_source' => 'МГУ, ФГП' ),
        ),
        array(
            'title'   => 'Открыт API для разработчиков: документация и примеры',
            'content' => '<p>Разработчики теперь могут получить доступ к данным платформы через REST API. Документация с примерами запросов опубликована в разделе «Для разработчиков».</p>',
            'meta'    => array( 'news_date' => '15 января 2026 г.', 'news_source' => 'Техническая команда' ),
        ),
        array(
            'title'   => 'Новые возможности сравнительного анализа стран',
            'content' => '<p>Обновлён инструмент сравнения стран. Теперь можно сравнивать до 4 стран одновременно по любым доступным показателям.</p>',
            'meta'    => array( 'news_date' => '10 января 2026 г.', 'news_source' => 'Пресс-служба' ),
        ),
    );

    foreach ( $news_items as $n ) {
        ergo_insert_cpt( $n['title'], 'ergo_news', $n['content'], mb_substr( wp_strip_all_tags( $n['content'] ), 0, 160 ), $n['meta'] );
    }

    // =================================================================
    //  СТАТЬИ (обычные записи)
    // =================================================================

    $articles = array(
        array( 'title' => 'Устойчивое развитие: междисциплинарный взгляд',
               'content' => '<p>Концепция устойчивого развития стала одной из центральных парадигм современной глобалистики.</p>' ),
        array( 'title' => 'Визуализация больших данных: методы и инструменты',
               'content' => '<p>В эпоху Big Data визуализация становится ключевым инструментом для осмысления сложных наборов данных.</p>' ),
        array( 'title' => 'Глобалистика как наука: история и современность',
               'content' => '<p>Глобалистика как самостоятельная научная область сформировалась в последней четверти XX века.</p>' ),
    );

    foreach ( $articles as $a ) {
        if ( ergo_post_exists_by_title( $a['title'], 'post' ) ) {
            continue;
        }
        wp_insert_post( array(
            'post_title'    => $a['title'],
            'post_content'  => $a['content'],
            'post_excerpt'  => mb_substr( wp_strip_all_tags( $a['content'] ), 0, 160 ),
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_author'   => 1,
            'post_category' => array( $cat_articles ),
        ) );
    }

    // =================================================================
    //  КОНФЕРЕНЦИИ (CPT conference)
    // =================================================================

    $conferences = array(
        array(
            'title'   => 'VIII Международный научный конгресс «Глобалистика-2025»',
            'content' => '<p>VIII Международный научный конгресс «Глобалистика» — крупнейший форум исследователей глобальных процессов. Конгресс проводится ежегодно с 2011 года, объединяя более 500 учёных из 40 стран мира.</p><p>Регистрация участников и приём заявок открываются за 3 месяца до начала конгресса. Участие может быть очным или заочным.</p>',
            'meta'    => array(
                'conference_date'               => '22—25 октября 2025 г.',
                'conference_place'              => 'Москва, МГУ имени М.В. Ломоносова',
                'conference_organizer'          => 'МГУ, Факультет глобальных процессов',
                'conference_announcement'       => 'В связи с многочисленными обращениями приём заявок продлен до 1 сентября 2025 года.',
                'conference_info_letter_url'   => '',
                'conference_registration_url'   => '',
                'conference_tab_requirements'   => '<p>От одного автора принимается не более 2 статей. Объём статьи — от 10 до 12 тыс. знаков с пробелами.</p><p><strong>Параметры форматирования:</strong></p><ul><li>шрифт Times New Roman, 12 pt</li><li>межстрочный интервал — одинарный</li><li>поля 20 мм со всех сторон</li></ul>',
                'conference_tab_program_committee' => '<p><strong>Председатели:</strong></p><ul><li>Иванов И.И., д.ф.н., проф., директор Института глобалистики МГУ</li><li>Петров П.П., д.э.н., проф., зав. кафедрой МГУ</li></ul><p><strong>Программный комитет:</strong></p><p>В состав комитета входят ведущие специалисты в области глобальных исследований.</p>',
                'conference_tab_organizing_committee' => '<p><strong>Председатель:</strong> Сидоров С.С., к.ф.н., доцент МГУ</p><p><strong>Координатор:</strong> тел. +7 (495) 123-45-67, conf@example.ru</p>',
                'conference_tab_program'        => '<h4>22 октября</h4><p>09:00—10:00 Регистрация</p><p>10:00—12:00 Пленарное заседание</p><p>12:00—14:00 Обед</p><p>14:00—18:00 Секционные заседания</p><h4>23—25 октября</h4><p>Работа секций по направлениям</p>',
                'conference_tab_contacts'       => '<p><strong>По вопросам участия:</strong></p><p>Иванова Анна, conf@example.ru, +7 (495) 123-45-67</p><p><strong>По организационным вопросам:</strong></p><p>Петрова Мария, org@example.ru</p>',
            ),
        ),
        array(
            'title'   => 'Устойчивое развитие в контексте глобальных процессов',
            'content' => '<p>Международная конференция посвящена обсуждению реализации Целей устойчивого развития ООН.</p>',
            'meta'    => array( 'conference_date' => '17—21 апреля 2025 г.', 'conference_place' => 'Онлайн', 'conference_organizer' => 'МГУ, ФГП' ),
        ),
        array(
            'title'   => 'Междисциплинарный семинар «Актуальные проблемы»',
            'content' => '<p>Постоянно действующий семинар при МГУ. Проводится каждую последнюю среду месяца. Основан в 2001 году д.ф.н., профессором А.Н. Чумаковым.</p>',
            'meta'    => array( 'conference_date' => 'Ежемесячно', 'conference_place' => 'Москва / Онлайн', 'conference_organizer' => 'МГУ, кафедра глобалистики' ),
        ),
    );

    foreach ( $conferences as $c ) {
        ergo_insert_cpt( $c['title'], 'conference', $c['content'], mb_substr( wp_strip_all_tags( $c['content'] ), 0, 160 ), $c['meta'] );
    }

    // =================================================================
    //  СПРАВОЧНИКИ (CPT ergo_directory)
    // =================================================================

    $directories = array(
        array(
            'title'   => 'Глобалистика: Энциклопедия',
            'content' => '<p>Первая в мире энциклопедия по глобалистике на русском языке. Гл. ред. И.И. Мазур, А.Н. Чумаков. — М.: Издательство «Радуга», 2003. — 1328 с.</p>',
            'meta'    => array( 'directory_author' => 'И.И. Мазур, А.Н. Чумаков', 'directory_year' => '2003' ),
            'term'    => $term_encyclopedia,
        ),
        array(
            'title'   => 'Глобалистика: Международный энциклопедический словарь',
            'content' => '<p>Более 3000 статей на русском, английском и французском языках. М.–СПб.–Нью-Йорк: Элима, Питер, 2006.</p>',
            'meta'    => array( 'directory_author' => 'И.И. Мазур, А.Н. Чумаков', 'directory_year' => '2006' ),
            'term'    => $term_encyclopedia,
        ),
        array(
            'title'   => 'Глобалистика: Персоналии, организации, труды',
            'content' => '<p>Биографический справочник ведущих учёных. Гл. ред. И.В. Ильин, И.И. Мазур, А.Н. Чумаков. — М.: «Альфа-М», 2012.</p>',
            'meta'    => array( 'directory_author' => 'И.В. Ильин, И.И. Мазур, А.Н. Чумаков', 'directory_year' => '2012' ),
            'term'    => $term_reference,
        ),
        array(
            'title'   => 'Global Studies Encyclopedic Dictionary',
            'content' => '<p>International English-language edition. Ed. by A.N. Chumakov, I.I. Mazour, W.C. Gay. — Rodopi, Amsterdam/New York, 2014.</p>',
            'meta'    => array( 'directory_author' => 'A.N. Chumakov, I.I. Mazour, W.C. Gay', 'directory_year' => '2014' ),
            'term'    => $term_encyclopedia,
        ),
    );

    foreach ( $directories as $d ) {
        $id = ergo_insert_cpt( $d['title'], 'ergo_directory', $d['content'], mb_substr( wp_strip_all_tags( $d['content'] ), 0, 160 ), $d['meta'] );
        if ( $id && ! empty( $d['term'] ) ) {
            wp_set_object_terms( $id, array( $d['term'] ), 'directory_type' );
        }
    }

    // =================================================================
    //  СЕМИНАРЫ (CPT ergo_seminar)
    // =================================================================

    $seminars = array(
        array(
            'title'   => '«Глобализация и культура»',
            'content' => '<p>Научный студенческий семинар. Обсуждение взаимовлияния глобализационных процессов и национальных культур.</p>',
            'meta'    => array( 'seminar_date' => '25 марта 2026 г., 18:00', 'seminar_place' => 'Онлайн', 'seminar_speaker' => 'Иванов М.А.' ),
            'term'    => $term_sem_student,
        ),
        array(
            'title'   => '«Цифровое общество»',
            'content' => '<p>Студенческий семинар о цифровой трансформации общества и её глобальных последствиях.</p>',
            'meta'    => array( 'seminar_date' => '15 апреля 2026 г., 18:00', 'seminar_place' => 'Москва, МГУ, ауд. 314', 'seminar_speaker' => 'Петрова Е.С.' ),
            'term'    => $term_sem_student,
        ),
        array(
            'title'   => '«Экологическая безопасность»',
            'content' => '<p>Студенческий семинар. Экологические риски и глобальная безопасность.</p>',
            'meta'    => array( 'seminar_date' => '29 апреля 2026 г., 18:00', 'seminar_place' => 'Онлайн', 'seminar_speaker' => 'Сидоров К.В.' ),
            'term'    => $term_sem_student,
        ),
        array(
            'title'   => 'Заседание №245: Глобальные риски 2026 года',
            'content' => '<p>Научный семинар «Актуальные проблемы глобалистики». Докладчик — проф. Смирнов А.В.</p>',
            'meta'    => array( 'seminar_date' => '26 февраля 2026 г., 18:00', 'seminar_place' => 'Москва, МГУ / Онлайн', 'seminar_speaker' => 'проф. Смирнов А.В.' ),
            'term'    => $term_sem_science,
        ),
        array(
            'title'   => 'Заседание №244: Искусственный интеллект и глобальное управление',
            'content' => '<p>Научный семинар. Обсуждение влияния ИИ на глобальные процессы управления.</p>',
            'meta'    => array( 'seminar_date' => '29 января 2026 г., 18:00', 'seminar_place' => 'Москва, МГУ / Онлайн', 'seminar_speaker' => 'проф. Кузнецова Е.М.' ),
            'term'    => $term_sem_science,
        ),
    );

    foreach ( $seminars as $s ) {
        $id = ergo_insert_cpt( $s['title'], 'ergo_seminar', $s['content'], mb_substr( wp_strip_all_tags( $s['content'] ), 0, 160 ), $s['meta'] );
        if ( $id && ! empty( $s['term'] ) ) {
            wp_set_object_terms( $id, array( $s['term'] ), 'seminar_type' );
        }
    }

    // =================================================================
    //  УЧЁНЫЕ (CPT ergo_scientist)
    // =================================================================

    $scientists = array(
        array(
            'title'   => 'Вернадский Владимир Иванович',
            'content' => '<p>1863–1945. Создатель учения о биосфере и ноосфере. Основоположник комплекса современных наук о Земле.</p>',
            'meta'    => array( 'scientist_position' => 'Академик', 'scientist_organization' => 'Российская академия наук', 'scientist_field' => 'Биосфера, ноосфера, геохимия' ),
        ),
        array(
            'title'   => 'Моисеев Никита Николаевич',
            'content' => '<p>1917–2000. Академик РАН. Разработчик концепции «ядерной зимы». Автор трудов по коэволюции природы и общества.</p>',
            'meta'    => array( 'scientist_position' => 'Академик РАН', 'scientist_organization' => 'Вычислительный центр РАН', 'scientist_field' => 'Математическое моделирование, экология' ),
        ),
        array(
            'title'   => 'Чумаков Александр Николаевич',
            'content' => '<p>Д.ф.н., профессор МГУ. Основатель портала globalistika.ru. Специалист в области философии и теории глобалистики.</p>',
            'meta'    => array( 'scientist_position' => 'Д.ф.н., профессор', 'scientist_organization' => 'МГУ имени М.В. Ломоносова', 'scientist_field' => 'Философия, глобалистика', 'scientist_email' => 'info@globalistika.ru' ),
        ),
        array(
            'title'   => 'Ильин Илья Вячеславович',
            'content' => '<p>Д.полит.н., декан факультета глобальных процессов МГУ. Автор работ по теории глобализации.</p>',
            'meta'    => array( 'scientist_position' => 'Д.полит.н., декан', 'scientist_organization' => 'МГУ, ФГП', 'scientist_field' => 'Глобализация, политология' ),
        ),
        array(
            'title'   => 'Печчеи Аурелио',
            'content' => '<p>1908–1984. Итальянский промышленник. Основатель и первый президент Римского клуба (1968).</p>',
            'meta'    => array( 'scientist_position' => 'Президент Римского клуба', 'scientist_organization' => 'Римский клуб', 'scientist_field' => 'Глобальные проблемы' ),
        ),
        array(
            'title'   => 'Медоуз Деннис',
            'content' => '<p>Р. 1942. Американский учёный. Ведущий автор доклада «Пределы роста» (1972) Римскому клубу.</p>',
            'meta'    => array( 'scientist_position' => 'Профессор', 'scientist_organization' => 'MIT', 'scientist_field' => 'Системная динамика, экология' ),
        ),
    );

    foreach ( $scientists as $s ) {
        ergo_insert_cpt( $s['title'], 'ergo_scientist', $s['content'], mb_substr( wp_strip_all_tags( $s['content'] ), 0, 160 ), $s['meta'] );
    }

    // =================================================================
    //  БИБЛИОТЕКИ (CPT ergo_library)
    // =================================================================

    $libraries = array(
        array(
            'title'   => 'eLIBRARY.RU',
            'content' => '<p>Крупнейшая в России электронная библиотека научных публикаций. Более 38 млн статей и публикаций.</p>',
            'meta'    => array( 'library_url' => 'https://elibrary.ru', 'library_description' => 'Крупнейшая электронная научная библиотека России' ),
            'term'    => $term_lib_digital,
        ),
        array(
            'title'   => 'КиберЛенинка',
            'content' => '<p>Национальная электронная библиотека открытого доступа. Бесплатный доступ к научным статьям.</p>',
            'meta'    => array( 'library_url' => 'https://cyberleninka.ru', 'library_description' => 'Научная электронная библиотека открытого доступа' ),
            'term'    => $term_lib_digital,
        ),
        array(
            'title'   => 'Google Scholar',
            'content' => '<p>Бесплатная поисковая система по полным текстам научных публикаций всех форматов и дисциплин.</p>',
            'meta'    => array( 'library_url' => 'https://scholar.google.com', 'library_description' => 'Поисковая система по научным публикациям' ),
            'term'    => $term_lib_digital,
        ),
        array(
            'title'   => 'JSTOR',
            'content' => '<p>Цифровая библиотека академических журналов, книг и первоисточников.</p>',
            'meta'    => array( 'library_url' => 'https://jstor.org', 'library_description' => 'Цифровая библиотека академических журналов' ),
            'term'    => $term_lib_digital,
        ),
        array(
            'title'   => 'ResearchGate',
            'content' => '<p>Социальная сеть для учёных с доступом к 135 млн публикаций.</p>',
            'meta'    => array( 'library_url' => 'https://researchgate.net', 'library_description' => 'Социальная сеть для учёных' ),
            'term'    => $term_lib_digital,
        ),
    );

    foreach ( $libraries as $lib ) {
        $id = ergo_insert_cpt( $lib['title'], 'ergo_library', $lib['content'], mb_substr( wp_strip_all_tags( $lib['content'] ), 0, 160 ), $lib['meta'] );
        if ( $id && ! empty( $lib['term'] ) ) {
            wp_set_object_terms( $id, array( $lib['term'] ), 'library_type' );
        }
    }

    // =================================================================
    //  РАБОЧИЕ ПРОГРАММЫ (CPT ergo_work_program)
    // =================================================================

    $work_programs = array(
        array(
            'title'   => 'Глобалистика: теория, история и основные проблемы человечества',
            'content' => '<p>Курс знакомит с основными теоретическими подходами к изучению глобальных процессов, историей формирования глобалистики как междисциплинарной области и ключевыми проблемами современного человечества.</p><h3>Содержание курса</h3><ul><li>Введение в глобалистику</li><li>Теоретические основы глобальных исследований</li><li>История глобальных процессов</li><li>Актуальные глобальные проблемы</li></ul>',
            'meta'    => array( 'work_program_code' => 'Б1.О.01', 'work_program_level' => 'Бакалавриат', 'work_program_department' => 'Философский факультет', 'work_program_year' => '2025' ),
        ),
        array(
            'title'   => 'Прикладная глобалистика',
            'content' => '<p>Курс посвящён практическим аспектам глобальных исследований: управление глобальными процессами, международное сотрудничество, устойчивое развитие.</p>',
            'meta'    => array( 'work_program_code' => 'Б1.В.02', 'work_program_level' => 'Бакалавриат', 'work_program_department' => 'Философский факультет', 'work_program_year' => '2025' ),
        ),
        array(
            'title'   => 'Методология глобальных исследований',
            'content' => '<p>Методологические подходы и методы исследования глобальных процессов. Междисциплинарность как принцип глобалистики.</p>',
            'meta'    => array( 'work_program_code' => 'М1.О.03', 'work_program_level' => 'Магистратура', 'work_program_department' => 'Философский факультет', 'work_program_year' => '2025' ),
        ),
    );

    foreach ( $work_programs as $wp ) {
        ergo_insert_cpt( $wp['title'], 'ergo_work_program', $wp['content'], mb_substr( wp_strip_all_tags( $wp['content'] ), 0, 160 ), $wp['meta'] );
    }

    // Обновить шаблон страницы «Программы курсов» для существующих установок
    $programs_page = get_page_by_path( 'programmi-kursov', OBJECT, 'page' );
    if ( $programs_page ) {
        update_post_meta( $programs_page->ID, '_wp_page_template', 'page-programmi-kursov.php' );
        wp_update_post( array( 'ID' => $programs_page->ID, 'post_title' => 'Рабочие программы дисциплин' ) );
    }

    // =================================================================
    //  ЗАПИСИ-НОВОСТИ (для обратной совместимости со старым page-novosti.php)
    // =================================================================

    $post_news = array(
        array( 'title' => 'Запущен новый раздел визуализации данных по экологии',
               'content' => '<p>На платформе появился новый раздел экологических данных.</p>' ),
        array( 'title' => 'Обновление статистики по странам за 2024 год',
               'content' => '<p>Обновлена база данных по всем странам мира.</p>' ),
        array( 'title' => 'Итоги семинара «Актуальные проблемы глобалистики»',
               'content' => '<p>Состоялось заседание семинара. Тема: «ИИ и глобальное управление».</p>' ),
    );

    foreach ( $post_news as $pn ) {
        if ( ergo_post_exists_by_title( $pn['title'], 'post' ) ) {
            continue;
        }
        wp_insert_post( array(
            'post_title'    => $pn['title'],
            'post_content'  => $pn['content'],
            'post_excerpt'  => mb_substr( wp_strip_all_tags( $pn['content'] ), 0, 160 ),
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_author'   => 1,
            'post_category' => array( $cat_news ),
        ) );
    }

    flush_rewrite_rules();
}
