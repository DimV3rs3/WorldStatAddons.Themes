<?php
/**
 * Template Name: API Documentation
 * 
 * REST API reference with interactive explorer.
 * 
 * @package Ergonosphera
 */

get_header();

$base_url = rest_url( 'ergonosphera/v1' );
?>

<main id="main-content" class="ergo-main ergo-api-page">
    <div class="ergo-container">
        <div class="ergo-docs-layout">

            <!-- Sidebar -->
            <aside class="ergo-docs-sidebar">
                <nav class="ergo-docs-nav">
                    <h3><?php echo esc_html( 'Справочник API' ); ?></h3>
                    <ul>
                        <li><a href="#overview"><?php echo esc_html( 'Обзор' ); ?></a></li>
                        <li><a href="#authentication"><?php echo esc_html( 'Аутентификация' ); ?></a></li>
                        <li><a href="#rate-limits"><?php echo esc_html( 'Ограничения запросов' ); ?></a></li>
                        <li><a href="#endpoints"><?php echo esc_html( 'Конечные точки' ); ?></a>
                            <ul>
                                <li><a href="#ep-countries">GET /countries</a></li>
                                <li><a href="#ep-country">GET /country/{code}</a></li>
                                <li><a href="#ep-themes">GET /themes</a></li>
                                <li><a href="#ep-theme-country">GET /{theme}/country/{code}</a></li>
                                <li><a href="#ep-map">GET /map/{theme}</a></li>
                                <li><a href="#ep-compare">GET /compare</a></li>
                                <li><a href="#ep-status">GET /status</a></li>
                            </ul>
                        </li>
                        <li><a href="#explorer"><?php echo esc_html( 'Проводник API' ); ?></a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Content -->
            <div class="ergo-docs-content">
                <div class="ergo-page-header">
                    <h1 class="ergo-page-header__title"><?php echo esc_html( 'Документация API' ); ?></h1>
                    <p class="ergo-page-header__subtitle"><?php echo esc_html( 'Справочник REST API для программного доступа к данным платформы' ); ?></p>
                </div>

                <section id="overview" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Обзор' ); ?></h2>
                    <p><?php echo esc_html( 'REST API Ergonosphera предоставляет доступ ко всем данным по странам и информации о темах данных. Все конечные точки возвращают JSON.' ); ?></p>
                    <div class="ergo-docs-info">
                        <strong><?php echo esc_html( 'Базовый URL:' ); ?></strong>
                        <code><?php echo esc_html( $base_url ); ?></code>
                    </div>
                </section>

                <section id="authentication" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Аутентификация' ); ?></h2>
                    <p><?php echo esc_html( 'Все GET-запросы общедоступны без аутентификации. Операции записи требуют аутентификации WordPress.' ); ?></p>
                </section>

                <section id="rate-limits" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Ограничения запросов' ); ?></h2>
                    <p><?php echo esc_html( 'Стандартные ограничения: 100 запросов в минуту для анонимных пользователей, 1000 для аутентифицированных.' ); ?></p>
                </section>

                <section id="endpoints" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Конечные точки' ); ?></h2>

                    <div id="ep-countries" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/countries</code>
                        </div>
                        <p><?php echo esc_html( 'Возвращает список всех стран с основной информацией.' ); ?></p>
                        <h4><?php echo esc_html( 'Пример ответа:' ); ?></h4>
                        <pre class="ergo-code"><code>[
  {
    "id": 42,
    "name": "Germany",
    "code": "DE",
    "code3": "DEU",
    "capital": "Berlin",
    "flag": "🇩🇪",
    "lat": 51.1657,
    "lng": 10.4515,
    "region": "Europe",
    "url": "/country/germany/",
    "has_data": true
  }
]</code></pre>
                    </div>

                    <div id="ep-country" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/country/{code}</code>
                        </div>
                        <p><?php echo esc_html( 'Возвращает подробную информацию по одной стране, включая доступные темы.' ); ?></p>
                        <h4><?php echo esc_html( 'Параметры:' ); ?></h4>
                        <table class="ergo-table ergo-table--compact">
                            <tr><td><code>code</code></td><td><?php echo esc_html( 'Код ISO 3166-1 alpha-2 (например, DE, US, JP)' ); ?></td></tr>
                        </table>
                    </div>

                    <div id="ep-themes" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/themes</code>
                        </div>
                        <p><?php echo esc_html( 'Возвращает список всех активных тем данных (плагинов).' ); ?></p>
                    </div>

                    <div id="ep-theme-country" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/{theme}/country/{code}</code>
                        </div>
                        <p><?php echo esc_html( 'Возвращает данные темы для указанной страны.' ); ?></p>
                    </div>

                    <div id="ep-map" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/map/{theme}</code>
                        </div>
                        <p><?php echo esc_html( 'Возвращает данные для раскраски карты и легенду по теме.' ); ?></p>
                    </div>

                    <div id="ep-compare" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/compare?countries=DE,JP,US&amp;theme=automotive</code>
                        </div>
                        <p><?php echo esc_html( 'Сравнение данных нескольких стран в рамках темы.' ); ?></p>
                    </div>

                    <div id="ep-status" class="ergo-endpoint">
                        <div class="ergo-endpoint__header">
                            <span class="ergo-endpoint__method ergo-endpoint__method--get">GET</span>
                            <code class="ergo-endpoint__path">/status</code>
                        </div>
                        <p><?php echo esc_html( 'Возвращает статус платформы и статистику.' ); ?></p>
                    </div>
                </section>

                <!-- API Explorer -->
                <section id="explorer" class="ergo-docs-section">
                    <h2><?php echo esc_html( 'Проводник API' ); ?></h2>
                    <div class="ergo-api-explorer">
                        <div class="ergo-api-explorer__input">
                            <span class="ergo-api-explorer__method">GET</span>
                            <input type="text" id="api-explorer-url" class="ergo-input" 
                                value="<?php echo esc_attr( $base_url . '/status' ); ?>"
                                placeholder="<?php echo esc_attr( 'Введите URL конечной точки API' ); ?>">
                            <button id="api-explorer-send" class="ergo-btn ergo-btn--primary"><?php echo esc_html( 'Отправить' ); ?></button>
                        </div>
                        <div class="ergo-api-explorer__response">
                            <pre id="api-explorer-result"><code><?php echo esc_html( '// Ответ появится здесь' ); ?></code></pre>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>

<?php get_footer();
