/**
 * CST WhatsApp Button — Show after scroll, pulse animation.
 */
(function () {
    'use strict';

    var btn = document.getElementById('cst-whatsapp');
    if (!btn) return;

    // Show button after scrolling 300px.
    var shown = false;
    btn.style.opacity = '0';
    btn.style.transition = 'opacity 0.3s ease';

    function checkScroll() {
        if (window.scrollY > 300 && !shown) {
            btn.style.opacity = '1';
            shown = true;
        } else if (window.scrollY <= 300 && shown) {
            btn.style.opacity = '0';
            shown = false;
        }
    }

    // Respect reduced motion.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        btn.style.opacity = '1';
        btn.style.transition = 'none';
        return;
    }

    window.addEventListener('scroll', checkScroll, { passive: true });
    checkScroll();
})();
