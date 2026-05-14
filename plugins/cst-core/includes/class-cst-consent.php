<?php
/**
 * CST_Consent — Cookie / analytics consent banner (Ley 39-2012 friendly).
 *
 * Shows a non-blocking footer banner on first visit, persists the
 * choice in localStorage (key `cst_consent_v1`), and exposes a small
 * helper API for downstream code:
 *
 *   - `window.cstConsent.granted()` → bool
 *   - `window.cstConsent.onGranted(cb)` fires immediately if already
 *     granted, or once the user clicks Accept.
 *
 * Scripts that depend on consent (GA4, Matomo, marketing pixels)
 * should subscribe via that API rather than enqueueing unconditionally.
 *
 * No cookies are written by the banner itself — localStorage only —
 * which is intentional: it keeps the page outside the legal definition
 * of "cookie storage" until the user actively opts in.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Consent {

    public function __construct() {
        add_action( 'wp_footer', [ $this, 'render' ], 5 );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    }

    public function enqueue_styles(): void {
        wp_register_style( 'cst-consent', false, [], CST_CORE_VERSION );
        wp_enqueue_style( 'cst-consent' );
        wp_add_inline_style( 'cst-consent', $this->styles() );
    }

    public function render(): void {
        $policy_url = get_privacy_policy_url();
        ?>
        <div id="cst-consent" class="cst-consent" role="dialog" aria-live="polite"
             aria-label="<?php esc_attr_e( 'Preferencias de cookies', 'cst-core' ); ?>"
             hidden>
            <div class="cst-consent__inner">
                <p class="cst-consent__message">
                    <?php
                    if ( $policy_url ) {
                        printf(
                            /* translators: %s: privacy policy URL */
                            wp_kses(
                                __( 'Usamos cookies para analizar el tráfico del portal de manera anónima. Consulte nuestra <a href="%s">Política de Privacidad</a> para más información.', 'cst-core' ),
                                [ 'a' => [ 'href' => [] ] ]
                            ),
                            esc_url( $policy_url )
                        );
                    } else {
                        esc_html_e( 'Usamos cookies para analizar el tráfico del portal de manera anónima.', 'cst-core' );
                    }
                    ?>
                </p>
                <div class="cst-consent__actions">
                    <button type="button" class="cst-consent__btn cst-consent__btn--decline" data-cst-consent="decline">
                        <?php esc_html_e( 'Rechazar', 'cst-core' ); ?>
                    </button>
                    <button type="button" class="cst-consent__btn cst-consent__btn--accept" data-cst-consent="accept">
                        <?php esc_html_e( 'Aceptar', 'cst-core' ); ?>
                    </button>
                </div>
            </div>
        </div>
        <?php
        wp_print_inline_script_tag( $this->script() );
    }

    private function script(): string {
        return <<<'JS'
(function () {
    var KEY = 'cst_consent_v1';
    var listeners = [];
    var stored;
    try { stored = localStorage.getItem(KEY); } catch (e) { stored = null; }

    function granted() {
        return stored === 'accept';
    }

    function notify() {
        if (!granted()) return;
        listeners.splice(0).forEach(function (cb) {
            try { cb(); } catch (e) { /* swallow */ }
        });
    }

    window.cstConsent = {
        granted: granted,
        onGranted: function (cb) {
            if (typeof cb !== 'function') return;
            if (granted()) { cb(); return; }
            listeners.push(cb);
        }
    };

    function init() {
        var banner = document.getElementById('cst-consent');
        if (!banner) return;
        if (stored) { return; }
        banner.hidden = false;

        banner.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-cst-consent]');
            if (!btn) return;
            var choice = btn.getAttribute('data-cst-consent');
            try { localStorage.setItem(KEY, choice); } catch (err) { /* private mode */ }
            stored = choice;
            banner.hidden = true;
            notify();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
JS;
    }

    private function styles(): string {
        return <<<'CSS'
.cst-consent{position:fixed;left:0;right:0;bottom:0;z-index:10000;background:var(--cst-color-navy,#1F2E54);color:#fff;padding:16px 20px;box-shadow:0 -6px 24px rgba(0,0,0,.15);font-family:var(--cst-font-body,system-ui,sans-serif);font-size:.9375rem;line-height:1.4}
.cst-consent[hidden]{display:none}
.cst-consent__inner{max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.cst-consent__message{margin:0;flex:1 1 320px}
.cst-consent__message a{color:#fff;text-decoration:underline}
.cst-consent__actions{display:flex;gap:10px;flex-shrink:0}
.cst-consent__btn{font-family:inherit;font-size:.875rem;font-weight:600;padding:10px 18px;border-radius:8px;border:none;cursor:pointer;transition:opacity .2s,transform .2s}
.cst-consent__btn--accept{background:#7FA35B;color:#fff}
.cst-consent__btn--decline{background:transparent;color:#fff;border:1.5px solid rgba(255,255,255,.4)}
.cst-consent__btn:hover{opacity:.9}
.cst-consent__btn:focus-visible{outline:3px solid #3B82C4;outline-offset:2px}
@media (max-width:540px){.cst-consent__inner{flex-direction:column;align-items:stretch;text-align:center}.cst-consent__actions{justify-content:center}}
@media print{.cst-consent{display:none!important}}
CSS;
    }
}
