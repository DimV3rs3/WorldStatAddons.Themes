/**
 * Compare Page JavaScript
 * 
 * Handles country comparison logic and rendering.
 * 
 * @package Ergonosphera
 */

(function($) {
    'use strict';

    const ComparePage = {

        init: function() {
            this.initExport();
        },

        /**
         * Export comparison data
         */
        initExport: function() {
            $('#export-comparison-csv').on('click', function() {
                const table = document.getElementById('detailed-compare-table');
                if (!table) return;

                const rows = table.querySelectorAll('tr');
                let csv = [];
                rows.forEach(function(row) {
                    const cells = row.querySelectorAll('th, td');
                    const rowData = [];
                    cells.forEach(function(cell) {
                        rowData.push('"' + cell.textContent.trim().replace(/"/g, '""') + '"');
                    });
                    csv.push(rowData.join(','));
                });

                const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'comparison.csv';
                a.click();
            });

            $('#export-comparison-png').on('click', function() {
                const chart = window.ErgoComponents.chartInstances['compare-chart-0'];
                if (chart) {
                    const a = document.createElement('a');
                    a.href = chart.toBase64Image();
                    a.download = 'comparison-chart.png';
                    a.click();
                }
            });
        }
    };

    $(document).ready(function() {
        ComparePage.init();
    });

})(jQuery);
