/**
 * CST Statistics — Counter animation via Intersection Observer.
 */
(function () {
    'use strict';

    var counters = document.querySelectorAll('.cst-statistics .cst-stat-counter');
    if (!counters.length) return;

    // Respect reduced motion.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        counters.forEach(function (el) {
            el.textContent = el.getAttribute('data-value') || '0';
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

    function animateCounter(el, target) {
        var duration = 1500;
        var startTime = null;
        var isFloat = target % 1 !== 0;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = eased * target;

            el.textContent = isFloat ? current.toFixed(1) : Math.floor(current).toLocaleString('es-PR');

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = isFloat ? target.toFixed(1) : Math.floor(target).toLocaleString('es-PR');
            }
        }

        requestAnimationFrame(step);
    }
})();
