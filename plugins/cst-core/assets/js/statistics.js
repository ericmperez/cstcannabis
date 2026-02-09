/**
 * CST Statistics — Counter animation, tab navigation, Chart.js dashboard.
 *
 * Three modules:
 * 1. Counter animation: Animates numeric counters using Intersection Observer.
 * 2. Tab navigation: Switches between category panels with ARIA support.
 * 3. Dashboard charts: Initializes Chart.js charts from cstDashboardData global.
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

    /* ====================================================================
       Counter Animations
       ==================================================================== */

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

    function formatNumber(num) {
        return Math.floor(num).toLocaleString('es-PR');
    }

    /* ====================================================================
       Tab Navigation
       ==================================================================== */

    function initTabs() {
        var tablist = document.querySelector('.cst-dashboard__tabs[role="tablist"]');
        if (!tablist) return;

        var tabs = tablist.querySelectorAll('[role="tab"]');
        var panels = document.querySelectorAll('.cst-dashboard__panel[role="tabpanel"]');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                activateTab(tab, tabs, panels);
            });

            // Keyboard navigation: arrow keys move between tabs.
            tab.addEventListener('keydown', function (e) {
                var index = Array.prototype.indexOf.call(tabs, tab);
                var newIndex = index;

                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    newIndex = (index + 1) % tabs.length;
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    newIndex = (index - 1 + tabs.length) % tabs.length;
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    newIndex = 0;
                } else if (e.key === 'End') {
                    e.preventDefault();
                    newIndex = tabs.length - 1;
                }

                if (newIndex !== index) {
                    activateTab(tabs[newIndex], tabs, panels);
                    tabs[newIndex].focus();
                }
            });
        });
    }

    function activateTab(selectedTab, allTabs, allPanels) {
        // Deactivate all tabs.
        allTabs.forEach(function (tab) {
            tab.setAttribute('aria-selected', 'false');
            tab.setAttribute('tabindex', '-1');
        });

        // Activate selected tab.
        selectedTab.setAttribute('aria-selected', 'true');
        selectedTab.removeAttribute('tabindex');

        // Hide all panels.
        allPanels.forEach(function (panel) {
            panel.setAttribute('aria-hidden', 'true');
            panel.classList.remove('is-active');
        });

        // Show the matching panel.
        var panelId = selectedTab.getAttribute('aria-controls');
        var panel = document.getElementById(panelId);
        if (panel) {
            panel.setAttribute('aria-hidden', 'false');
            panel.classList.add('is-active');

            // Initialize any uninitialized charts in the newly visible panel.
            initPanelCharts(panel);
        }
    }

    /* ====================================================================
       Chart.js Dashboard
       ==================================================================== */

    var chartInstances = {};
    var chartDataMap = {};

    function initCharts() {
        if (typeof Chart === 'undefined' || typeof cstDashboardData === 'undefined') {
            return;
        }

        var charts = cstDashboardData.charts || [];
        if (!charts.length) return;

        // Build lookup map.
        charts.forEach(function (chartData) {
            chartDataMap[chartData.id] = chartData;
        });

        // Set Chart.js defaults.
        Chart.defaults.font.family = "'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";
        Chart.defaults.font.size = 13;
        Chart.defaults.color = '#495057';
        Chart.defaults.plugins.legend.position = 'bottom';
        Chart.defaults.plugins.legend.labels.usePointStyle = true;
        Chart.defaults.plugins.legend.labels.padding = 16;
        Chart.defaults.responsive = true;
        Chart.defaults.maintainAspectRatio = false;

        // Initialize charts in the active "All" panel.
        charts.forEach(function (chartData, index) {
            var canvas = document.getElementById('cst-chart-' + chartData.id);
            if (!canvas) return;

            createChart(canvas, chartData, index);
        });
    }

    /**
     * Initialize charts for canvases with data-chart-id within a panel.
     */
    function initPanelCharts(panel) {
        if (typeof Chart === 'undefined') return;

        var canvases = panel.querySelectorAll('.cst-chart-canvas');
        canvases.forEach(function (canvas) {
            if (canvas.getAttribute('data-initialized')) return;

            var chartId = canvas.getAttribute('data-chart-id');
            var chartData = chartDataMap[chartId];
            if (!chartData) return;

            var index = Object.keys(chartDataMap).indexOf(chartId);
            createChart(canvas, chartData, index);
        });
    }

    function createChart(canvas, chartData, index) {
        var canvasId = canvas.id;
        if (chartInstances[canvasId]) return;

        var ctx = canvas.getContext('2d');
        var config = buildChartConfig(chartData, index, ctx);

        chartInstances[canvasId] = new Chart(ctx, config);
        canvas.setAttribute('data-initialized', 'true');

        // Remove no-js fallback class.
        var card = canvas.closest('.cst-chart-card');
        if (card) {
            card.classList.remove('cst-chart-card--no-js');
        }
    }

    function buildChartConfig(chartData, index, ctx) {
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
                    borderWidth: type === 'line' ? 2.5 : 0
                }]
            },
            options: {
                animation: {
                    duration: 800,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(33, 37, 41, 0.9)',
                        titleFont: { weight: '600' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function (context) {
                                var value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                                return chartLabel + ': ' + formatNumber(value);
                            }
                        }
                    },
                    legend: {
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            borderRadius: 3
                        }
                    }
                }
            }
        };

        // Apply colors and styling based on chart type.
        if (type === 'doughnut') {
            config.data.datasets[0].backgroundColor = COLOR_ARRAY.slice(0, data.length);
            config.data.datasets[0].borderColor = '#fff';
            config.data.datasets[0].borderWidth = 3;
            config.data.datasets[0].hoverBorderWidth = 4;
            config.data.datasets[0].hoverOffset = 6;
            config.options.cutout = '65%';
            config.options.plugins.legend.position = 'right';
        } else if (type === 'bar') {
            var barColor = COLOR_ARRAY[index % COLOR_ARRAY.length];
            config.data.datasets[0].backgroundColor = hexToRgba(barColor, 0.85);
            config.data.datasets[0].hoverBackgroundColor = barColor;
            config.data.datasets[0].borderRadius = 6;
            config.data.datasets[0].borderSkipped = false;
            config.data.datasets[0].maxBarThickness = 48;
            config.options.scales = {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 12 },
                        callback: function (value) {
                            return formatNumber(value);
                        }
                    }
                }
            };
        } else if (type === 'line') {
            var lineColor = COLOR_ARRAY[index % COLOR_ARRAY.length];
            // Create gradient fill if canvas context is available.
            var bgColor = hexToRgba(lineColor, 0.08);
            if (ctx && ctx.canvas) {
                try {
                    var gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height || 300);
                    gradient.addColorStop(0, hexToRgba(lineColor, 0.2));
                    gradient.addColorStop(1, hexToRgba(lineColor, 0.02));
                    bgColor = gradient;
                } catch (e) {
                    // Fallback to flat color.
                }
            }
            config.data.datasets[0].borderColor = lineColor;
            config.data.datasets[0].backgroundColor = bgColor;
            config.data.datasets[0].fill = true;
            config.data.datasets[0].tension = 0.4;
            config.data.datasets[0].pointBackgroundColor = '#fff';
            config.data.datasets[0].pointBorderColor = lineColor;
            config.data.datasets[0].pointBorderWidth = 2;
            config.data.datasets[0].pointRadius = 4;
            config.data.datasets[0].pointHoverRadius = 7;
            config.data.datasets[0].pointHoverBorderWidth = 3;
            config.options.scales = {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 12 },
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

    /* ====================================================================
       Initialize
       ==================================================================== */

    function init() {
        initCounters();
        initTabs();
        initCharts();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
