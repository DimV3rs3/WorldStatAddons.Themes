/**
 * Main Theme JavaScript
 * 
 * Handles navigation, theme selector, AJAX interactions,
 * country filtering, and general UI behavior.
 * 
 * @package Ergonosphera
 */

(function($) {
    'use strict';

    const Ergonosphera = {

        /**
         * Initialize
         */
        init: function() {
            this.initHeader();
            this.initBannerSlider();
            this.initThemeSelector();
            this.initCountryTabs();
            this.initCountryFilters();
            this.initSidebar();
            this.initApiExplorer();
            this.initCompare();
            this.initSmoothScroll();
            this.initCopyLink();
            this.initFAQ();
            this.initDocsNav();
        },

        /**
         * Sticky header & mobile menu
         */
        initHeader: function() {
            const header = document.getElementById('ergo-header');
            const toggle = document.getElementById('ergo-menu-toggle');
            const nav = document.getElementById('ergo-nav');

            if (!header) return;

            // Sticky header
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;
                if (currentScroll > 60) {
                    header.classList.add('is-sticky');
                } else {
                    header.classList.remove('is-sticky');
                }
                lastScroll = currentScroll;
            });

            // Mobile menu toggle
            if (toggle && nav) {
                toggle.addEventListener('click', function() {
                    const expanded = toggle.getAttribute('aria-expanded') === 'true';
                    toggle.setAttribute('aria-expanded', !expanded);
                    nav.classList.toggle('is-open');
                    document.body.classList.toggle('menu-open');
                });
            }

            // Mobile: toggle sub-menus on click
            nav.querySelectorAll('.ergo-nav__item--has-children > a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        link.parentElement.classList.toggle('is-open');
                    }
                });
            });
        },

        /**
         * Баннер на главной: переключение слайдов по точкам
         */
        initBannerSlider: function() {
            const banner = document.getElementById('front-banner');
            if (!banner) return;
            const slides = banner.querySelectorAll('.ergo-front-banner__slide');
            const dots = banner.querySelectorAll('.ergo-front-banner__dot');
            if (slides.length <= 1) return;

            let current = 0;
            function goTo(index) {
                current = (index + slides.length) % slides.length;
                slides.forEach(function(s, i) {
                    s.classList.toggle('is-active', i === current);
                });
                dots.forEach(function(d, i) {
                    d.classList.toggle('is-active', i === current);
                });
            }
            dots.forEach(function(dot, i) {
                dot.addEventListener('click', function() {
                    goTo(i);
                });
            });
            setInterval(function() {
                goTo(current + 1);
            }, 6000);
        },

        /**
         * Theme selector on home page
         */
        initThemeSelector: function() {
            const select = document.getElementById('ergo-theme-select');
            if (!select) return;

            const infoBox = document.getElementById('theme-info');
            const nameEl = document.getElementById('theme-name');
            const descEl = document.getElementById('theme-description');
            const iconEl = document.getElementById('theme-icon');

            select.addEventListener('change', function() {
                const value = select.value;
                const option = select.options[select.selectedIndex];

                if (value) {
                    const desc = option.getAttribute('data-description');
                    const icon = option.getAttribute('data-icon');
                    const color = option.getAttribute('data-color');

                    if (nameEl) nameEl.textContent = option.textContent.trim();
                    if (descEl) descEl.textContent = desc || '';
                    if (iconEl) {
                        iconEl.className = 'ergo-theme-selector__icon';
                        if (icon) {
                            iconEl.innerHTML = '<span class="dashicons ' + icon + '" style="color:' + (color || '#6366f1') + '"></span>';
                        }
                    }
                    if (infoBox) infoBox.hidden = false;

                    // Load map data
                    if (window.ErgoMap) {
                        window.ErgoMap.loadThemeData(value);
                    }

                    // Update URL without reload
                    const url = new URL(window.location);
                    url.searchParams.set('theme', value);
                    history.replaceState(null, '', url);
                } else {
                    if (infoBox) infoBox.hidden = true;
                    if (window.ErgoMap) {
                        window.ErgoMap.loadThemeData(null);
                    }
                    const url = new URL(window.location);
                    url.searchParams.delete('theme');
                    history.replaceState(null, '', url);
                }
            });
        },

        /**
         * Country page tabs (AJAX)
         */
        initCountryTabs: function() {
            const tabs = document.querySelectorAll('.ergo-tab[data-tab]');
            if (!tabs.length) return;

            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    const tabId = tab.getAttribute('data-tab');
                    const panel = document.getElementById('tab-panel-' + tabId);

                    // Update active states
                    document.querySelectorAll('.ergo-tab').forEach(function(t) {
                        t.classList.remove('is-active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    document.querySelectorAll('.ergo-tab-panel').forEach(function(p) {
                        p.classList.remove('is-active');
                    });

                    tab.classList.add('is-active');
                    tab.setAttribute('aria-selected', 'true');
                    if (panel) panel.classList.add('is-active');

                    // Load content via AJAX if not already loaded
                    if (panel && panel.getAttribute('data-loaded') !== 'true') {
                        const countryCode = panel.getAttribute('data-country');
                        Ergonosphera.loadTabContent(panel, tabId, countryCode);
                    }
                });
            });
        },

        /**
         * Load tab content via AJAX
         */
        loadTabContent: function(panel, tabId, countryCode) {
            const formData = new FormData();
            formData.append('action', 'ergo_get_tab_content');
            formData.append('nonce', ergoData.nonce);
            formData.append('country_code', countryCode);
            formData.append('tab_id', tabId);

            fetch(ergoData.ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(function(r) { return r.json(); })
            .then(function(response) {
                if (response.success && response.data.content) {
                    const content = response.data.content;
                    if (content.sections) {
                        window.ErgoComponents.renderSections(panel, content.sections);

                        // Информация об источнике
                        if (content.source) {
                            const sourceDiv = document.createElement('div');
                            sourceDiv.className = 'ergo-source-info';
                            sourceDiv.innerHTML = '<span>Источник:</span> ' + 
                                (content.source_url ? '<a href="' + content.source_url + '" target="_blank">' + content.source + '</a>' : content.source);
                            panel.appendChild(sourceDiv);
                        }

                        // Кнопки скачивания
                        const dlDiv = document.createElement('div');
                        dlDiv.className = 'ergo-download-section';
                        ['csv', 'xlsx', 'json'].forEach(function(fmt) {
                            const btn = document.createElement('button');
                            btn.className = 'ergo-btn ergo-btn--outline ergo-btn--sm';
                            btn.textContent = 'Скачать ' + fmt.toUpperCase();
                            btn.setAttribute('data-download', fmt);
                            btn.setAttribute('data-theme', tabId);
                            btn.setAttribute('data-country', countryCode);
                            dlDiv.appendChild(btn);
                        });
                        panel.appendChild(dlDiv);
                    } else {
                        panel.innerHTML = '<div class="ergo-no-data"><h3>Данные отсутствуют</h3></div>';
                    }
                    panel.setAttribute('data-loaded', 'true');
                } else {
                    panel.innerHTML = '<div class="ergo-no-data"><h3>Данные отсутствуют</h3></div>';
                    panel.setAttribute('data-loaded', 'true');
                }
            })
            .catch(function(err) {
                panel.innerHTML = '<div class="ergo-no-data"><h3>Ошибка загрузки данных</h3><p>' + err.message + '</p></div>';
            });
        },

        /**
         * Country archive page filters
         */
        initCountryFilters: function() {
            const grid = document.getElementById('countries-grid');
            if (!grid) return;

            const search = document.getElementById('country-search');
            const regionFilter = document.getElementById('filter-region');
            const dataFilter = document.getElementById('filter-data');
            const themeFilters = document.querySelectorAll('.theme-filter');
            const clearBtn = document.getElementById('clear-filters');
            const showingCount = document.getElementById('showing-count');
            const emptyState = document.getElementById('countries-empty');

            const filterCards = function() {
                const searchVal = search ? search.value.toLowerCase() : '';
                const regionVal = regionFilter ? regionFilter.value : '';
                const dataVal = dataFilter ? dataFilter.value : '';
                
                const cards = grid.querySelectorAll('.ergo-country-card');
                let visible = 0;

                cards.forEach(function(card) {
                    const name = (card.querySelector('.ergo-country-card__name a') || {}).textContent || '';
                    const region = (card.querySelector('.ergo-country-card__region') || {}).textContent || '';
                    const badges = card.querySelectorAll('.ergo-badge:not(.ergo-badge--muted)');
                    const hasData = badges.length > 0;

                    let show = true;

                    // Search
                    if (searchVal && name.toLowerCase().indexOf(searchVal) === -1) show = false;

                    // Region
                    if (regionVal && region !== regionVal) show = false;

                    // Data availability
                    if (dataVal === 'with_data' && !hasData) show = false;
                    if (dataVal === 'without_data' && hasData) show = false;

                    card.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                if (showingCount) showingCount.textContent = visible;
                if (emptyState) emptyState.hidden = visible > 0;
                if (grid) grid.style.display = visible > 0 ? '' : 'none';
            };

            if (search) search.addEventListener('input', filterCards);
            if (regionFilter) regionFilter.addEventListener('change', filterCards);
            if (dataFilter) dataFilter.addEventListener('change', filterCards);
            themeFilters.forEach(function(cb) { cb.addEventListener('change', filterCards); });

            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    if (search) search.value = '';
                    if (regionFilter) regionFilter.value = '';
                    if (dataFilter) dataFilter.value = '';
                    themeFilters.forEach(function(cb) { cb.checked = false; });
                    filterCards();
                });
            }
        },

        /**
         * Country sidebar search
         */
        initSidebar: function() {
            const search = document.getElementById('sidebar-country-search');
            const list = document.getElementById('sidebar-country-list');
            if (!search || !list) return;

            search.addEventListener('input', function() {
                const val = search.value.toLowerCase();
                const items = list.querySelectorAll('li');
                items.forEach(function(li) {
                    const name = li.textContent.toLowerCase();
                    li.style.display = (!val || name.indexOf(val) !== -1) ? '' : 'none';
                });

                // Show/hide region headers
                const regions = list.querySelectorAll('.ergo-country-sidebar__region');
                regions.forEach(function(region) {
                    const visibleItems = region.querySelectorAll('li[style=""], li:not([style])');
                    region.style.display = visibleItems.length > 0 ? '' : 'none';
                });
            });

            // Sticky sidebar
            const sidebar = document.getElementById('country-sidebar');
            if (sidebar) {
                const offset = sidebar.offsetTop;
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > offset) {
                        sidebar.classList.add('is-sticky');
                    } else {
                        sidebar.classList.remove('is-sticky');
                    }
                });
            }
        },

        /**
         * API Explorer
         */
        initApiExplorer: function() {
            const sendBtn = document.getElementById('api-explorer-send');
            const urlInput = document.getElementById('api-explorer-url');
            const resultEl = document.getElementById('api-explorer-result');

            if (!sendBtn || !urlInput) return;

            sendBtn.addEventListener('click', function() {
                const url = urlInput.value;
                if (!url) return;

                resultEl.querySelector('code').textContent = 'Загрузка...';

                fetch(url)
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        resultEl.querySelector('code').textContent = JSON.stringify(data, null, 2);
                    })
                    .catch(function(err) {
                        resultEl.querySelector('code').textContent = 'Ошибка: ' + err.message;
                    });
            });
        },

        /**
         * Compare page
         */
        initCompare: function() {
            const compareBtn = document.getElementById('compare-btn');
            if (!compareBtn) return;

            const selects = document.querySelectorAll('.country-select');
            const themeSelect = document.getElementById('compare-theme');
            const results = document.getElementById('compare-results');
            const empty = document.getElementById('compare-empty');
            const loading = document.getElementById('compare-loading');

            // Enable/disable compare button
            const checkReady = function() {
                const countries = [];
                selects.forEach(function(s) { if (s.value) countries.push(s.value); });
                const theme = themeSelect ? themeSelect.value : '';
                compareBtn.disabled = countries.length < 2 || !theme;
            };

            selects.forEach(function(s) { s.addEventListener('change', checkReady); });
            if (themeSelect) themeSelect.addEventListener('change', checkReady);

            compareBtn.addEventListener('click', function() {
                const countries = [];
                selects.forEach(function(s) { if (s.value) countries.push(s.value); });
                const theme = themeSelect.value;

                if (countries.length < 2 || !theme) return;

                if (empty) empty.hidden = true;
                if (results) results.hidden = false;
                if (loading) loading.hidden = false;

                // Load comparison data via AJAX
                const formData = new FormData();
                formData.append('action', 'ergo_compare_countries');
                formData.append('nonce', ergoData.nonce);
                formData.append('theme_id', theme);
                countries.forEach(function(c) { formData.append('countries[]', c); });

                fetch(ergoData.ajaxUrl, {
                    method: 'POST',
                    body: formData,
                })
                .then(function(r) { return r.json(); })
                .then(function(response) {
                    if (loading) loading.hidden = true;
                    if (response.success && response.data.data) {
                        Ergonosphera.renderComparison(response.data.data, countries);
                    }
                })
                .catch(function(err) {
                    if (loading) loading.hidden = true;
                    console.error('Compare error:', err);
                });

                // Update URL
                const url = new URL(window.location);
                url.searchParams.set('countries', countries.join(','));
                url.searchParams.set('theme', theme);
                history.replaceState(null, '', url);
            });

            // Auto-trigger if URL params exist
            checkReady();
            if (!compareBtn.disabled) {
                compareBtn.click();
            }
        },

        /**
         * Render comparison results
         */
        renderComparison: function(data, countries) {
            const chartsContainer = document.getElementById('charts-container');
            const detailedTable = document.getElementById('detailed-compare-table');

            if (chartsContainer && data.charts) {
                chartsContainer.innerHTML = '';
                data.charts.forEach(function(chartData, idx) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'ergo-compare-chart-item';
                    const canvas = document.createElement('canvas');
                    canvas.id = 'compare-chart-' + idx;
                    canvas.className = 'ergo-chart';
                    canvas.setAttribute('data-chart-type', chartData.type || 'bar');
                    canvas.setAttribute('data-chart-data', JSON.stringify(chartData.data || {}));
                    
                    if (chartData.title) {
                        const title = document.createElement('h3');
                        title.textContent = chartData.title;
                        wrapper.appendChild(title);
                    }
                    wrapper.appendChild(canvas);
                    chartsContainer.appendChild(wrapper);
                });
                window.ErgoComponents.initCharts();
            }

            if (detailedTable && data.table) {
                let html = '<thead><tr><th></th>';
                countries.forEach(function(c) { html += '<th>' + c + '</th>'; });
                html += '</tr></thead><tbody>';
                if (data.table.rows) {
                    data.table.rows.forEach(function(row) {
                        html += '<tr>';
                        row.forEach(function(cell) { html += '<td>' + cell + '</td>'; });
                        html += '</tr>';
                    });
                }
                html += '</tbody>';
                detailedTable.innerHTML = html;
            }
        },

        /**
         * Smooth scroll for anchor links
         */
        initSmoothScroll: function() {
            document.querySelectorAll('a[href^="#"]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        },

        /**
         * Copy link button
         */
        initCopyLink: function() {
            const btn = document.getElementById('copy-link-btn');
            if (!btn) return;

            btn.addEventListener('click', function() {
                navigator.clipboard.writeText(window.location.href).then(function() {
                    btn.title = 'Скопировано!';
                    setTimeout(function() { btn.title = 'Копировать ссылку'; }, 2000);
                });
            });
        },

        /**
         * FAQ accordion
         */
        initFAQ: function() {
            // details/summary works natively, but we add smooth animation
            document.querySelectorAll('.ergo-faq__item').forEach(function(item) {
                item.addEventListener('toggle', function() {
                    if (item.open) {
                        const content = item.querySelector('p');
                        if (content) {
                            content.style.maxHeight = '0';
                            requestAnimationFrame(function() {
                                content.style.maxHeight = content.scrollHeight + 'px';
                            });
                        }
                    }
                });
            });
        },

        /**
         * Documentation sidebar navigation
         */
        initDocsNav: function() {
            const links = document.querySelectorAll('.ergo-docs-nav a');
            if (!links.length) return;

            const sections = document.querySelectorAll('.ergo-docs-section');
            
            window.addEventListener('scroll', function() {
                let current = '';
                sections.forEach(function(section) {
                    if (window.pageYOffset >= section.offsetTop - 100) {
                        current = section.id;
                    }
                });

                links.forEach(function(link) {
                    link.classList.remove('is-active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('is-active');
                    }
                });
            });
        }
    };

    // Init on DOM ready
    $(document).ready(function() {
        Ergonosphera.init();
    });

    window.Ergonosphera = Ergonosphera;

})(jQuery);
