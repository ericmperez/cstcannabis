<?php
/**
 * CST_Accessibility — WCAG 2.1 AA enhancements for Ley 229 compliance.
 *
 * - Skip-to-content link
 * - ARIA landmarks on GP elements
 * - Correct lang attribute for Spanish
 * - Focus management helpers
 * - Contact Form 7 accessibility fixes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Accessibility {

    public function __construct() {
        add_filter( 'language_attributes', [ $this, 'set_lang_attribute' ] );
        add_action( 'wp_footer', [ $this, 'inject_skip_link_target' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_a11y_script' ] );
        add_filter( 'body_class', [ $this, 'add_a11y_body_class' ] );
        add_filter( 'nav_menu_link_attributes', [ $this, 'add_aria_current' ], 10, 3 );
        add_action( 'wp_head', [ $this, 'inline_focus_styles' ], 1 );
    }

    /**
     * Ensure lang attribute is "es" for Spanish portal.
     */
    public function set_lang_attribute( string $output ): string {
        // Respect Polylang if active; otherwise default to Spanish.
        if ( function_exists( 'pll_current_language' ) ) {
            return $output;
        }
        return str_replace( 'lang="en-US"', 'lang="es"', $output );
    }

    /**
     * Add a skip-link target anchor at the top of #content if GP doesn't provide one.
     */
    public function inject_skip_link_target(): void {
        ?>
        <script>
        (function(){
            // Ensure #main-content exists for skip link.
            if ( ! document.getElementById('main-content') ) {
                var main = document.querySelector('main') || document.querySelector('.site-main') || document.querySelector('#content');
                if ( main && ! main.id ) {
                    main.id = 'main-content';
                }
            }

            // Add ARIA landmarks to GP structural elements.
            var header = document.querySelector('.site-header');
            if ( header ) header.setAttribute('role', 'banner');

            var nav = document.querySelector('.main-navigation');
            if ( nav ) nav.setAttribute('role', 'navigation');

            var main = document.querySelector('main') || document.querySelector('.site-main');
            if ( main ) main.setAttribute('role', 'main');

            var footer = document.querySelector('.site-footer');
            if ( footer ) footer.setAttribute('role', 'contentinfo');
        })();
        </script>
        <?php
    }

    /**
     * Enqueue accessibility helpers.
     */
    public function enqueue_a11y_script(): void {
        // Inline: trap focus in modals, handle Escape key, etc.
        wp_add_inline_script( 'jquery', $this->get_a11y_js() );
    }

    private function get_a11y_js(): string {
        return <<<'JS'
document.addEventListener('DOMContentLoaded', function() {
    // Make CF7 forms more accessible.
    document.querySelectorAll('.wpcf7-form-control').forEach(function(el) {
        // Ensure all inputs have associated labels.
        if ( ! el.getAttribute('aria-label') && ! el.getAttribute('aria-labelledby') ) {
            var label = el.closest('label');
            if ( ! label ) {
                var id = el.getAttribute('id');
                if ( id ) {
                    label = document.querySelector('label[for="' + id + '"]');
                }
            }
            if ( ! label && el.placeholder ) {
                el.setAttribute('aria-label', el.placeholder);
            }
        }
        // Mark required fields.
        if ( el.classList.contains('wpcf7-validates-as-required') ) {
            el.setAttribute('aria-required', 'true');
        }
    });

    // Announce CF7 validation errors.
    document.addEventListener('wpcf7invalid', function(e) {
        var msg = e.detail.apiResponse && e.detail.apiResponse.message;
        if ( msg ) {
            var live = document.createElement('div');
            live.setAttribute('role', 'alert');
            live.setAttribute('aria-live', 'assertive');
            live.className = 'sr-only';
            live.textContent = msg;
            document.body.appendChild(live);
            setTimeout(function(){ live.remove(); }, 5000);
        }
    });
});
JS;
    }

    /**
     * Add class to body for CSS targeting.
     */
    public function add_a11y_body_class( array $classes ): array {
        $classes[] = 'cst-a11y';
        return $classes;
    }

    /**
     * Add aria-current="page" to active nav links.
     */
    public function add_aria_current( array $atts, $item, $args ): array {
        if ( isset( $item->current ) && $item->current ) {
            $atts['aria-current'] = 'page';
        }
        return $atts;
    }

    /**
     * Inline focus-visible styles so they load before paint.
     */
    public function inline_focus_styles(): void {
        echo '<style>:focus-visible{outline:3px solid var(--cst-color-focus,#0050F0);outline-offset:2px;}</style>' . "\n";
    }
}
