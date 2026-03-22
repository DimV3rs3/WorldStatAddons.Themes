/**
 * Country Page JavaScript
 * 
 * Handles tab switching, AJAX content loading,
 * quick stats panel, and download buttons.
 * 
 * @package Ergonosphera
 */

(function($) {
    'use strict';

    const CountryPage = {

        init: function() {
            this.initDownloadButtons();
            this.initQuickStats();
            this.initStickyPanel();
        },

        /**
         * Download buttons
         */
        initDownloadButtons: function() {
            $(document).on('click', '[data-download]', function(e) {
                e.preventDefault();
                const format = $(this).data('download');
                const theme = $(this).data('theme');
                const country = $(this).data('country');

                const url = ergoData.ajaxUrl + '?' + $.param({
                    action: 'ergo_download',
                    theme: theme,
                    file: 'country_' + country,
                    format: format
                });

                window.open(url, '_blank');
            });
        },

        /**
         * Update quick stats in side panel when tab changes
         */
        initQuickStats: function() {
            const panel = document.getElementById('panel-quick-stats');
            if (!panel) return;

            // Watch for tab changes
            $(document).on('click', '.ergo-tab', function() {
                const tabId = $(this).data('tab');
                const tabPanel = document.getElementById('tab-panel-' + tabId);

                if (tabPanel) {
                    // Extract stats from the panel
                    const stats = tabPanel.querySelectorAll('.ergo-stat-card');
                    if (stats.length > 0) {
                        let html = '';
                        stats.forEach(function(stat) {
                            const val = stat.querySelector('.ergo-stat-card__value');
                            const label = stat.querySelector('.ergo-stat-card__label');
                            if (val && label) {
                                html += '<div class="ergo-panel-stat">';
                                html += '<strong>' + val.textContent + '</strong>';
                                html += '<span>' + label.textContent + '</span>';
                                html += '</div>';
                            }
                        });
                        panel.innerHTML = html;
                    }
                }
            });

            // Trigger for first tab
            const firstTab = document.querySelector('.ergo-tab.is-active');
            if (firstTab) {
                setTimeout(function() {
                    $(firstTab).trigger('click');
                }, 500);
            }
        },

        /**
         * Sticky side panel
         */
        initStickyPanel: function() {
            const panel = document.getElementById('country-panel');
            if (!panel) return;

            const offset = panel.offsetTop;
            window.addEventListener('scroll', function() {
                if (window.innerWidth >= 1200) {
                    if (window.pageYOffset > offset - 80) {
                        panel.classList.add('is-sticky');
                    } else {
                        panel.classList.remove('is-sticky');
                    }
                }
            });
        }
    };

    $(document).ready(function() {
        CountryPage.init();
    });

})(jQuery);
