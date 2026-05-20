/**
 * Universal Components
 * 
 * Handles chart rendering, table initialization, Leaflet maps, etc.
 * 
 * @package Ergonosphera
 */

(function() {
    'use strict';

    const ErgoComponents = {

        chartInstances: {},

        /**
         * Initialize all components on page
         */
        init: function() {
            this.initCharts();
            this.initDataTables();
            this.initLeafletMaps();
            this.initChartDownloads();
            this.initTableExports();
        },

        /**
         * Initialize Chart.js charts
         */
        initCharts: function() {
            const canvases = document.querySelectorAll('.ergo-chart[data-chart-data]');
            const self = this;

            canvases.forEach(function(canvas) {
                self.createChart(canvas);
            });
        },

        /**
         * Create a single chart
         */
        createChart: function(canvas) {
            if (typeof Chart === 'undefined') return;

            const chartType = canvas.getAttribute('data-chart-type') || 'bar';
            let chartData;

            try {
                chartData = JSON.parse(canvas.getAttribute('data-chart-data'));
            } catch (e) {
                console.error('Invalid chart data:', e);
                return;
            }

            if (!chartData) return;

            const ctx = canvas.getContext('2d');
            
            // Default chart options
            const options = {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Inter, sans-serif', size: 12 },
                            padding: 16,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleFont: { family: 'Inter, sans-serif', size: 13 },
                        bodyFont: { family: 'Inter, sans-serif', size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                    }
                },
                scales: {}
            };

            // Add scales for non-pie charts
            if (chartType !== 'pie' && chartType !== 'doughnut') {
                options.scales = {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter, sans-serif', size: 11 } }
                    },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.06)' },
                        ticks: { font: { family: 'Inter, sans-serif', size: 11 } }
                    }
                };
            }

            // Handle area chart type
            const type = chartType === 'area' ? 'line' : chartType;
            if (chartType === 'area' && chartData.datasets) {
                chartData.datasets.forEach(function(ds) {
                    ds.fill = true;
                });
            }

            const chart = new Chart(ctx, {
                type: type,
                data: chartData,
                options: options
            });

            this.chartInstances[canvas.id] = chart;
            return chart;
        },

        /**
         * Initialize DataTables
         */
        initDataTables: function() {
            if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') return;

            jQuery('.ergo-datatable').each(function() {
                if (!jQuery.fn.DataTable.isDataTable(this)) {
                    jQuery(this).DataTable({
                        pageLength: 25,
                        responsive: true,
                        language: {
                            search: 'Поиск:',
                            emptyTable: 'Данные отсутствуют',
                            info: 'Показано _START_ — _END_ из _TOTAL_ записей',
                            infoEmpty: 'Нет записей',
                            infoFiltered: '(отфильтровано из _MAX_ записей)',
                            lengthMenu: 'Показать _MENU_ записей',
                            zeroRecords: 'Ничего не найдено',
                            paginate: {
                                first: 'Первая',
                                last: 'Последняя',
                                next: 'Следующая',
                                previous: 'Предыдущая'
                            }
                        },
                        dom: '<"ergo-dt-top"lf>rt<"ergo-dt-bottom"ip>',
                    });
                }
            });
        },

        /**
         * Initialize Leaflet maps
         */
        initLeafletMaps: function() {
            if (typeof L === 'undefined') return;

            const maps = document.querySelectorAll('.ergo-leaflet-map[data-markers]');
            maps.forEach(function(el) {
                let center, zoom, markers;
                try {
                    center = JSON.parse(el.getAttribute('data-center')) || [20, 0];
                    zoom = parseInt(el.getAttribute('data-zoom')) || 3;
                    markers = JSON.parse(el.getAttribute('data-markers')) || [];
                } catch (e) {
                    console.error('Invalid map data:', e);
                    return;
                }

                const map = L.map(el.id).setView(center, zoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 18,
                }).addTo(map);

                markers.forEach(function(m) {
                    if (m.lat && m.lng) {
                        const marker = L.marker([m.lat, m.lng]).addTo(map);
                        if (m.popup) {
                            marker.bindPopup(
                                '<strong>' + (m.title || '') + '</strong>' +
                                (m.description ? '<br>' + m.description : '')
                            );
                        }
                    }
                });

                // Fit bounds if markers exist
                if (markers.length > 1) {
                    const bounds = markers
                        .filter(function(m) { return m.lat && m.lng; })
                        .map(function(m) { return [m.lat, m.lng]; });
                    if (bounds.length > 0) {
                        map.fitBounds(bounds, { padding: [30, 30] });
                    }
                }
            });
        },

        /**
         * Chart download as PNG
         */
        initChartDownloads: function() {
            const self = this;
            document.querySelectorAll('.ergo-chart-download').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const chartId = btn.getAttribute('data-chart');
                    const chart = self.chartInstances[chartId];
                    if (chart) {
                        const a = document.createElement('a');
                        a.href = chart.toBase64Image();
                        a.download = chartId + '.png';
                        a.click();
                    }
                });
            });
        },

        /**
         * Table export to CSV
         */
        initTableExports: function() {
            document.querySelectorAll('.ergo-table-export').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const tableId = btn.getAttribute('data-table');
                    const table = document.getElementById(tableId);
                    if (!table) return;

                    const rows = table.querySelectorAll('tr');
                    let csv = [];

                    rows.forEach(function(row) {
                        const cells = row.querySelectorAll('th, td');
                        const rowData = [];
                        cells.forEach(function(cell) {
                            let text = cell.textContent.trim().replace(/"/g, '""');
                            rowData.push('"' + text + '"');
                        });
                        csv.push(rowData.join(','));
                    });

                    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = tableId + '.csv';
                    a.click();
                });
            });
        },

        /**
         * Render sections from AJAX data
         */
        renderSections: function(container, sections) {
            if (!container || !sections) return;
            container.innerHTML = '';

            const self = this;
            sections.forEach(function(section, idx) {
                const el = self.createSectionElement(section, idx);
                container.appendChild(el);
            });

            // Re-init components for new elements
            this.initCharts();
            this.initDataTables();
            this.initLeafletMaps();
            this.initChartDownloads();
            this.initTableExports();
        },

        /**
         * Create section DOM element
         */
        createSectionElement: function(section, idx) {
            const div = document.createElement('div');
            div.className = 'ergo-section ergo-section--' + (section.type || 'text');
            div.id = 'section-' + idx;

            let html = '';

            if (section.title) {
                html += '<h3 class="ergo-section__title">' + this.escHtml(section.title) + '</h3>';
            }

            switch (section.type) {
                case 'text_with_stats':
                    if (section.stats) {
                        html += '<div class="ergo-stats-cards">';
                        section.stats.forEach(function(stat) {
                            html += '<div class="ergo-stat-card">';
                            html += '<div class="ergo-stat-card__value">' + this.escHtml(stat.value) + '</div>';
                            html += '<div class="ergo-stat-card__label">' + this.escHtml(stat.label) + '</div>';
                            if (stat.unit) html += '<div class="ergo-stat-card__unit">' + this.escHtml(stat.unit) + '</div>';
                            html += '</div>';
                        }.bind(this));
                        html += '</div>';
                    }
                    if (section.content) {
                        html += '<div class="ergo-section__content">' + section.content + '</div>';
                    }
                    break;

                case 'chart':
                    var chartId = 'ergo-chart-ajax-' + idx + '-' + Math.floor(Math.random() * 10000);
                    html += '<div class="ergo-chart-wrapper">';
                    html += '<canvas id="' + chartId + '" class="ergo-chart" data-chart-type="' + (section.chart_type || 'bar') + '" data-chart-data=\'' + JSON.stringify(section.data || {}) + '\'></canvas>';
                    html += '</div>';
                    html += '<div class="ergo-chart-actions"><button class="ergo-btn ergo-btn--sm ergo-btn--ghost ergo-chart-download" data-chart="' + chartId + '">Скачать PNG</button></div>';
                    break;

                case 'table':
                    var tableId = 'ergo-table-ajax-' + idx + '-' + Math.floor(Math.random() * 10000);
                    html += '<div class="ergo-table-responsive"><table id="' + tableId + '" class="ergo-table ergo-datatable">';
                    if (section.headers) {
                        html += '<thead><tr>';
                        section.headers.forEach(function(h) { html += '<th>' + this.escHtml(h) + '</th>'; }.bind(this));
                        html += '</tr></thead>';
                    }
                    html += '<tbody>';
                    if (section.rows) {
                        section.rows.forEach(function(row) {
                            html += '<tr>';
                            (Array.isArray(row) ? row : Object.values(row)).forEach(function(cell) {
                                html += '<td>' + this.escHtml(String(cell)) + '</td>';
                            }.bind(this));
                            html += '</tr>';
                        }.bind(this));
                    }
                    html += '</tbody></table></div>';
                    html += '<div class="ergo-table-actions"><button class="ergo-btn ergo-btn--sm ergo-btn--ghost ergo-table-export" data-table="' + tableId + '" data-format="csv">Экспорт CSV</button></div>';
                    break;

                case 'map':
                    var mapId = 'ergo-leaflet-ajax-' + idx + '-' + Math.floor(Math.random() * 10000);
                    html += '<div class="ergo-leaflet-wrapper"><div id="' + mapId + '" class="ergo-leaflet-map" data-center=\'' + JSON.stringify(section.center || [20, 0]) + '\' data-zoom="' + (section.zoom || 3) + '" data-markers=\'' + JSON.stringify(section.markers || []) + '\'></div></div>';
                    break;

                case 'timeline':
                    if (section.events) {
                        html += '<div class="ergo-timeline">';
                        section.events.forEach(function(event) {
                            html += '<div class="ergo-timeline__item"><div class="ergo-timeline__marker"></div><div class="ergo-timeline__content">';
                            if (event.date) html += '<span class="ergo-timeline__date">' + this.escHtml(event.date) + '</span>';
                            if (event.title) html += '<h4 class="ergo-timeline__title">' + this.escHtml(event.title) + '</h4>';
                            if (event.description) html += '<p class="ergo-timeline__desc">' + this.escHtml(event.description) + '</p>';
                            if (event.value) html += '<span class="ergo-timeline__value">' + this.escHtml(event.value) + '</span>';
                            html += '</div></div>';
                        }.bind(this));
                        html += '</div>';
                    }
                    break;

                default:
                    if (section.content) {
                        html += '<div class="ergo-section__content">' + section.content + '</div>';
                    }
            }

            div.innerHTML = html;
            return div;
        },

        /**
         * Escape HTML
         */
        escHtml: function(str) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }
    };

    window.ErgoComponents = ErgoComponents;

    document.addEventListener('DOMContentLoaded', function() {
        ErgoComponents.init();
    });
})();
