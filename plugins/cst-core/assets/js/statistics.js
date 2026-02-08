/**
 * CST Statistics — Counter animation + Chart.js dashboard.
 *
 * Two modes:
 * 1. Counter animation (shortcode): Animates numeric counters using Intersection Observer.
 * 2. Dashboard charts: Initializes Chart.js charts from cstDashboardData global.
 */
(function () {
    'use strict';

    // Color-blind safe palette (6 colors).
    var COLORS = {
        teal:      '#115E67',
        coral:     '#E56A54',
        blue:      '#0050F0',
        tealLight: '#1a8a96',
        gold:      '#C49A1A',
        purple:    '#6B4C9A'
    };

    var COLOR_ARRAY = [
        COLORS.teal,
        COLORS.coral,
        COLORS.blue,
        COLORS.tealLight,
        COLORS.gold,
        COLORS.purple
    ];

    /**
     * Initialize counter animations for shortcode cards.
     */
    function initCounters() {
        var counters = document.querySelectorAll('.cst-statistics .cst-stat-counter, .cst-dashboard .cst-stat-counter');
        if (!counters.length) return;

        // Respect reduced motion.
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            counters.forEach(function (el) {
                el.textContent = formatNumber(parseFloat(el.getAttribute('data-value')) || 0);
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                var target = parseFloat(el.getAttribute('data-value')) || 0;
                animateCounter(el, target);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(function (el) {
            observer.observe(el);
        });
    }

    /**
     * Animate a counter from 0 to target value.
     */
    function animateCounter(el, target) {
        var duration = 1500;
        var startTime = null;
        var isFloat = target % 1 !== 0;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = eased * target;

            el.textContent = isFloat ? current.toFixed(1) : formatNumber(Math.floor(current));

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = isFloat ? target.toFixed(1) : formatNumber(Math.floor(target));
            }
        }

        requestAnimationFrame(step);
    }

    /**
     * Format number with locale separators.
     */
    function formatNumber(num) {
        return Math.floor(num).toLocaleString('es-PR');
    }

    /**
     * Initialize Chart.js charts from cstDashboardData global.
     */
    function initCharts() {
        if (typeof Chart === 'undefined' || typeof cstDashboardData === 'undefined') {
            return;
        }

        var charts = cstDashboardData.charts || [];
        if (!charts.length) return;

        // Set Chart.js defaults.
        Chart.defaults.font.family = "'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";
        Chart.defaults.font.size = 13;
        Chart.defaults.color = '#495057';
        Chart.defaults.plugins.legend.position = 'bottom';
        Chart.defaults.plugins.legend.labels.usePointStyle = true;
        Chart.defaults.plugins.legend.labels.padding = 16;
        Chart.defaults.responsive = true;
        Chart.defaults.maintainAspectRatio = false;

        charts.forEach(function (chartData, index) {
            var canvas = document.getElementById('cst-chart-' + chartData.id);
            if (!canvas) return;

            var ctx = canvas.getContext('2d');
            var config = buildChartConfig(chartData, index);

            new Chart(ctx, config);

            // Remove no-js fallback class.
            var card = canvas.closest('.cst-chart-card');
            if (card) {
                card.classList.remove('cst-chart-card--no-js');
            }
        });
    }

    /**
     * Build Chart.js configuration for a chart.
     */
    function buildChartConfig(chartData, index) {
        var type = chartData.type;
        var labels = chartData.labels || [];
        var data = chartData.data || [];
        var chartLabel = chartData.chartLabel || chartData.title;

        var config = {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: chartLabel,
                    data: data,
                    borderWidth: type === 'line' ? 2 : 0
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                                return chartLabel + ': ' + formatNumber(value);
                            }
                        }
                    }
                }
            }
        };

        // Apply colors based on chart type.
        if (type === 'doughnut') {
            config.data.datasets[0].backgroundColor = COLOR_ARRAY.slice(0, data.length);
            config.data.datasets[0].borderColor = '#fff';
            config.data.datasets[0].borderWidth = 2;
            config.options.cutout = '60%';
        } else if (type === 'bar') {
            config.data.datasets[0].backgroundColor = COLOR_ARRAY[index % COLOR_ARRAY.length];
            config.data.datasets[0].borderRadius = 4;
            config.options.scales = {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return formatNumber(value);
                        }
                    }
                }
            };
        } else if (type === 'line') {
            var color = COLOR_ARRAY[index % COLOR_ARRAY.length];
            config.data.datasets[0].borderColor = color;
            config.data.datasets[0].backgroundColor = hexToRgba(color, 0.1);
            config.data.datasets[0].fill = true;
            config.data.datasets[0].tension = 0.3;
            config.data.datasets[0].pointBackgroundColor = color;
            config.data.datasets[0].pointRadius = 4;
            config.data.datasets[0].pointHoverRadius = 6;
            config.options.scales = {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return formatNumber(value);
                        }
                    }
                }
            };
        }

        return config;
    }

    /**
     * Convert hex color to rgba.
     */
    function hexToRgba(hex, alpha) {
        var r = parseInt(hex.slice(1, 3), 16);
        var g = parseInt(hex.slice(3, 5), 16);
        var b = parseInt(hex.slice(5, 7), 16);
        return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + alpha + ')';
    }

    /**
     * Initialize on DOM ready.
     */
    function init() {
        initCounters();
        initCharts();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
