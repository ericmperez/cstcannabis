/**
 * CST Cannabis Portal — Main JavaScript
 *
 * Government banner toggle, smooth scroll, resource filter,
 * mobile menu a11y, legal page TOC.
 */

(function () {
    'use strict';

    /* ------------------------------------------------------------------ */
    /*  Government Banner Toggle                                          */
    /* ------------------------------------------------------------------ */

    function initBannerToggle() {
        var toggle = document.querySelector('.cst-gov-banner__toggle');
        var details = document.getElementById('cst-gov-banner-details');

        if (!toggle || !details) return;

        toggle.addEventListener('click', function () {
            var expanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!expanded));
            details.hidden = expanded;
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Smooth Scroll for Anchor Links                                    */
    /* ------------------------------------------------------------------ */

    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href').slice(1);
                if (!targetId) return;

                var target = document.getElementById(targetId);
                if (!target) return;

                // Respect reduced motion.
                var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                e.preventDefault();
                target.scrollIntoView({
                    behavior: prefersReducedMotion ? 'auto' : 'smooth',
                    block: 'start'
                });

                // Move focus for accessibility.
                target.setAttribute('tabindex', '-1');
                target.focus({ preventScroll: true });
            });
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Resource Filter (Resources page)                                  */
    /* ------------------------------------------------------------------ */

    function initResourceFilter() {
        var buttons = document.querySelectorAll('.cst-filter-tabs__btn');
        var cards = document.querySelectorAll('.cst-card--resource');

        if (!buttons.length || !cards.length) return;

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var filter = this.getAttribute('data-filter');

                // Update active state & ARIA.
                buttons.forEach(function (b) {
                    b.classList.remove('is-active');
                    b.setAttribute('aria-selected', 'false');
                });
                this.classList.add('is-active');
                this.setAttribute('aria-selected', 'true');

                // Filter cards.
                var visibleCount = 0;
                cards.forEach(function (card) {
                    var types = card.getAttribute('data-type') || '';
                    var show = filter === 'all' || types.indexOf(filter) !== -1;
                    card.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });

                // Announce to screen readers.
                announceFilter(visibleCount);
            });
        });
    }

    function announceFilter(count) {
        var msg = count + ' recurso' + (count !== 1 ? 's' : '') + ' encontrado' + (count !== 1 ? 's' : '');
        var live = document.createElement('div');
        live.setAttribute('role', 'status');
        live.setAttribute('aria-live', 'polite');
        live.className = 'sr-only';
        live.textContent = msg;
        document.body.appendChild(live);
        setTimeout(function () { live.remove(); }, 3000);
    }

    /* ------------------------------------------------------------------ */
    /*  Mobile Menu Accessibility                                         */
    /* ------------------------------------------------------------------ */

    function initMobileMenuA11y() {
        // GP uses .menu-toggle button.
        var toggle = document.querySelector('.menu-toggle');
        if (!toggle) return;

        // Ensure ARIA attributes.
        if (!toggle.hasAttribute('aria-label')) {
            toggle.setAttribute('aria-label',
                (window.cstPortal && window.cstPortal.i18n && window.cstPortal.i18n.menuOpen) || 'Open menu'
            );
        }

        toggle.addEventListener('click', function () {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-label',
                expanded
                    ? ((window.cstPortal && window.cstPortal.i18n && window.cstPortal.i18n.menuOpen) || 'Open menu')
                    : ((window.cstPortal && window.cstPortal.i18n && window.cstPortal.i18n.menuClose) || 'Close menu')
            );
        });

        // Close menu on Escape key.
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                var nav = document.querySelector('.main-navigation');
                if (nav && nav.classList.contains('toggled')) {
                    toggle.click();
                    toggle.focus();
                }
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Legal Page — Auto-generate TOC                                    */
    /* ------------------------------------------------------------------ */

    function initLegalTOC() {
        var article = document.getElementById('cst-legal-article');
        var tocList = document.getElementById('cst-toc-list');

        if (!article || !tocList) return;

        var headings = article.querySelectorAll('h2, h3');
        if (!headings.length) {
            var tocContainer = document.querySelector('.cst-legal-toc');
            if (tocContainer) tocContainer.style.display = 'none';
            return;
        }

        headings.forEach(function (heading, index) {
            // Add ID if missing.
            if (!heading.id) {
                heading.id = 'section-' + (index + 1);
            }

            var li = document.createElement('li');
            var a = document.createElement('a');
            a.href = '#' + heading.id;
            a.textContent = heading.textContent;

            // Indent h3.
            if (heading.tagName === 'H3') {
                li.style.paddingLeft = '1em';
            }

            li.appendChild(a);
            tocList.appendChild(li);
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Stat Counter Animation                                            */
    /* ------------------------------------------------------------------ */

    function initStatCounters() {
        var counters = document.querySelectorAll('.cst-stat-counter');
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
    }

    function animateCounter(el, target) {
        var duration = 1500;
        var startTime = null;
        var isFloat = target % 1 !== 0;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
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

    /* ------------------------------------------------------------------ */
    /*  Scroll-triggered Animations                                       */
    /* ------------------------------------------------------------------ */

    function initScrollAnimations() {
        // Bail if user prefers reduced motion.
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        // Add animation classes to eligible elements.
        var sectionHeadings = document.querySelectorAll('.cst-section-heading');
        sectionHeadings.forEach(function (el) {
            el.classList.add('cst-animate');
        });

        var cardGrids = document.querySelectorAll('.cst-card-grid, .cst-objectives-grid, .cst-stats-grid, .cst-statistics__grid');
        cardGrids.forEach(function (el) {
            el.classList.add('cst-animate-stagger');
            el.classList.add('cst-animate');
        });

        // Observe and trigger.
        var animateEls = document.querySelectorAll('.cst-animate');
        if (!animateEls.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        animateEls.forEach(function (el) {
            observer.observe(el);
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Desktop Nav Keyboard Navigation                                   */
    /* ------------------------------------------------------------------ */

    function initDesktopNavKeyboard() {
        var nav = document.querySelector('.main-navigation .main-nav');
        if (!nav) return;

        nav.addEventListener('keydown', function (e) {
            var key = e.key;
            var target = e.target;
            if (!target.matches('a')) return;

            var li = target.closest('li');
            var parentUl = li.parentElement;
            var isTopLevel = parentUl.classList.contains('sf-menu') ||
                             parentUl.parentElement.classList.contains('main-nav');
            var isSubmenu = !isTopLevel;

            if (isTopLevel) {
                var topItems = Array.from(parentUl.children);
                var idx = topItems.indexOf(li);

                if (key === 'ArrowRight') {
                    e.preventDefault();
                    var next = topItems[(idx + 1) % topItems.length];
                    next.querySelector('a').focus();
                } else if (key === 'ArrowLeft') {
                    e.preventDefault();
                    var prev = topItems[(idx - 1 + topItems.length) % topItems.length];
                    prev.querySelector('a').focus();
                } else if (key === 'ArrowDown') {
                    var sub = li.querySelector('ul');
                    if (sub) {
                        e.preventDefault();
                        li.classList.add('sfHover');
                        var firstLink = sub.querySelector('a');
                        if (firstLink) firstLink.focus();
                    }
                } else if (key === 'Escape') {
                    li.classList.remove('sfHover');
                    target.blur();
                }
            }

            if (isSubmenu) {
                var subItems = Array.from(parentUl.children);
                var subIdx = subItems.indexOf(li);
                var parentLi = parentUl.closest('li');

                if (key === 'ArrowDown') {
                    e.preventDefault();
                    if (subIdx < subItems.length - 1) {
                        subItems[subIdx + 1].querySelector('a').focus();
                    }
                } else if (key === 'ArrowUp') {
                    e.preventDefault();
                    if (subIdx > 0) {
                        subItems[subIdx - 1].querySelector('a').focus();
                    } else if (parentLi) {
                        parentLi.classList.remove('sfHover');
                        parentLi.querySelector('a').focus();
                    }
                } else if (key === 'Escape') {
                    e.preventDefault();
                    if (parentLi) {
                        parentLi.classList.remove('sfHover');
                        parentLi.querySelector('a').focus();
                    }
                }
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Init                                                              */
    /* ------------------------------------------------------------------ */

    document.addEventListener('DOMContentLoaded', function () {
        initBannerToggle();
        initSmoothScroll();
        initResourceFilter();
        initMobileMenuA11y();
        initLegalTOC();
        initStatCounters();
        initScrollAnimations();
        initDesktopNavKeyboard();
    });

})();
