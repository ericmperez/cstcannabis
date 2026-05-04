<?php
/**
 * CST_Login_Form — [cst_login_form] shortcode.
 *
 * Renders a free-tier replacement for Tutor LMS Pro's [tutor_login] shortcode
 * in a professional, government-appropriate layout: official-system banner,
 * CST seal, accessible form, lost-password and registration links.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Login_Form {

    public function __construct() {
        add_shortcode( 'cst_login_form', [ $this, 'render' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'maybe_enqueue_on_tutor_pages' ] );
    }

    public function register_assets(): void {
        wp_register_style(
            'cst-login-form',
            CST_CORE_URL . 'assets/css/login-form.css',
            [],
            CST_CORE_VERSION
        );
    }

    /**
     * Auto-enqueue the auth-form CSS on Tutor LMS registration / dashboard
     * pages so the [tutor_student_registration_form] shortcode picks up the
     * cst-login-card visual treatment without extra setup.
     */
    public function maybe_enqueue_on_tutor_pages(): void {
        if ( ! is_singular( 'page' ) ) {
            return;
        }
        $tutor_opts = get_option( 'tutor_option', [] );
        $register_id = (int) ( $tutor_opts['student_register_page'] ?? 0 );
        if ( $register_id && get_queried_object_id() === $register_id ) {
            wp_enqueue_style( 'cst-login-form' );
        }
    }

    public function render( $atts = [] ): string {
        wp_enqueue_style( 'cst-login-form' );

        if ( is_user_logged_in() ) {
            return $this->render_logged_in();
        }

        $tutor_opts   = get_option( 'tutor_option', [] );
        $register_id  = (int) ( $tutor_opts['student_register_page'] ?? 0 );
        $register_url = $register_id ? get_permalink( $register_id ) : '';
        $redirect_url = isset( $_GET['redirect_to'] )
            ? esc_url_raw( wp_unslash( $_GET['redirect_to'] ) )
            : home_url( '/' );

        $logo_url = $this->cannabis_logo_url();

        $form = wp_login_form( [
            'echo'           => false,
            'redirect'       => $redirect_url,
            'label_username' => __( 'Correo electrónico o usuario', 'cst-core' ),
            'label_password' => __( 'Contraseña', 'cst-core' ),
            'label_remember' => __( 'Recordarme', 'cst-core' ),
            'label_log_in'   => __( 'Iniciar sesión', 'cst-core' ),
        ] );

        ob_start();
        ?>
        <section class="cst-login-page" aria-labelledby="cst-login-title">
            <div class="cst-login-card cst-login-form">

                <p class="cst-login-card__official">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                        <path d="M12 2L4 5v6.5c0 4.7 3.4 9.1 8 10.5 4.6-1.4 8-5.8 8-10.5V5l-8-3z"
                              fill="currentColor"/>
                        <path d="M9 12l2 2 4-4" stroke="#ffffff" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php esc_html_e( 'Sistema oficial del Gobierno de Puerto Rico', 'cst-core' ); ?></span>
                </p>

                <?php if ( $logo_url ) : ?>
                    <div class="cst-login-card__seal">
                        <img src="<?php echo esc_url( $logo_url ); ?>"
                             alt="<?php esc_attr_e( 'Curso de Cannabis Medicinal y Seguridad Vial', 'cst-core' ); ?>" />
                    </div>
                <?php else : ?>
                    <div class="cst-login-card__wordmark" aria-hidden="true">
                        <span class="cst-login-card__wordmark-line">CST</span>
                        <span class="cst-login-card__wordmark-line cst-login-card__wordmark-line--accent">CANNABIS</span>
                    </div>
                <?php endif; ?>

                <h1 id="cst-login-title" class="cst-login-card__title">
                    <?php esc_html_e( 'Acceso al Curso', 'cst-core' ); ?>
                </h1>
                <p class="cst-login-card__subtitle">
                    <?php esc_html_e( 'Ingrese sus credenciales para continuar con su capacitación en cannabis medicinal y seguridad vial.', 'cst-core' ); ?>
                </p>

                <?php
                // wp_login_form() output is already escaped by core.
                echo $form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>

                <p class="cst-login-form__links">
                    <a href="<?php echo esc_url( wp_lostpassword_url( $redirect_url ) ); ?>">
                        <?php esc_html_e( '¿Olvidaste tu contraseña?', 'cst-core' ); ?>
                    </a>
                    <?php if ( $register_url ) : ?>
                        <span class="cst-login-form__separator" aria-hidden="true">·</span>
                        <a href="<?php echo esc_url( $register_url ); ?>">
                            <?php esc_html_e( 'Crear cuenta nueva', 'cst-core' ); ?>
                        </a>
                    <?php endif; ?>
                </p>

                <p class="cst-login-card__footer">
                    <?php
                    printf(
                        /* translators: %s: privacy policy URL */
                        wp_kses(
                            __( 'Al iniciar sesión usted acepta nuestra <a href="%s">Política de Privacidad</a> conforme a la Ley 39-2012 del Gobierno de Puerto Rico.', 'cst-core' ),
                            [ 'a' => [ 'href' => [] ] ]
                        ),
                        esc_url( get_privacy_policy_url() )
                    );
                    ?>
                </p>

            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }

    private function render_logged_in(): string {
        $dashboard_id  = (int) ( get_option( 'tutor_option' )['tutor_dashboard_page_id'] ?? 0 );
        $dashboard_url = $dashboard_id ? get_permalink( $dashboard_id ) : admin_url();

        ob_start();
        ?>
        <section class="cst-login-page">
            <div class="cst-login-card cst-login-card--logged-in">
                <p class="cst-login-card__official">
                    <span><?php esc_html_e( 'Sesión activa', 'cst-core' ); ?></span>
                </p>
                <h1 class="cst-login-card__title">
                    <?php esc_html_e( 'Ya has iniciado sesión', 'cst-core' ); ?>
                </h1>
                <p>
                    <?php
                    /* translators: %s: user display name */
                    printf( esc_html__( 'Bienvenido, %s.', 'cst-core' ), esc_html( wp_get_current_user()->display_name ) );
                    ?>
                </p>
                <a class="cst-login-card__button" href="<?php echo esc_url( $dashboard_url ); ?>">
                    <?php esc_html_e( 'Ir a mi escritorio', 'cst-core' ); ?>
                </a>
            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }

    /**
     * Locate the green CST Cannabis course logo if present.
     *
     * Looks for cst-cannabis-logo.svg, then .png, in the active theme's
     * assets/images directory. Falls back to an empty string so the
     * shortcode renders a typographic wordmark instead of the wrong logo.
     */
    private function cannabis_logo_url(): string {
        $candidates = [ 'cst-cannabis-logo.svg', 'cst-cannabis-logo.png' ];
        foreach ( $candidates as $file ) {
            $path = get_stylesheet_directory() . '/assets/images/' . $file;
            if ( file_exists( $path ) ) {
                return get_stylesheet_directory_uri() . '/assets/images/' . $file;
            }
        }
        return '';
    }
}
