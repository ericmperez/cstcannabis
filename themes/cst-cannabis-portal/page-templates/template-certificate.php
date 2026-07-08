<?php
/**
 * Template Name: Certificado de aprobación
 * Template Post Type: page
 *
 * Printable HTML certificate. Students reach this page after completing
 * the Tutor LMS course (see CST_Auto_Enrollment for the redirect). The
 * page is laid out at landscape A4 so "Print → Save as PDF" produces a
 * gov-quality certificate without needing a server-side PDF library.
 *
 * Reads the director name/title/signature/logo from CST Settings; falls
 * back to safe defaults so the template never renders a half-baked
 * certificate.
 *
 * Query args:
 *  - name=<string>  Optional override for the student's display name.
 *                   Defaults to wp_get_current_user()->display_name.
 *  - date=<Y-m-d>   Optional override for the completion date.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$student_name = isset( $_GET['name'] ) ? sanitize_text_field( wp_unslash( $_GET['name'] ) ) : '';
if ( '' === $student_name && is_user_logged_in() ) {
    $student_name = wp_get_current_user()->display_name;
}
if ( '' === $student_name ) {
    $student_name = __( 'Participante', 'cst-cannabis' );
}

$date_raw = isset( $_GET['date'] ) ? sanitize_text_field( wp_unslash( $_GET['date'] ) ) : '';
$ts       = $date_raw ? strtotime( $date_raw ) : current_time( 'timestamp' );
if ( ! $ts ) {
    $ts = current_time( 'timestamp' );
}
$date_display = date_i18n( get_option( 'date_format', 'j \d\e F \d\e Y' ), $ts );

$director_name  = get_option( 'cst_certificate_director_name', __( 'Director', 'cst-cannabis' ) );
$director_title = get_option( 'cst_certificate_director_title', __( 'Director, Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ) );
$signature_id   = (int) get_option( 'cst_certificate_signature_id', 0 );
$logo_id        = (int) get_option( 'cst_certificate_logo_id', 0 );

// Verification code derived from the student name + date, deterministic
// so the same student/date pair always reproduces the same code (useful
// for QR / lookup later without a separate DB write).
$verification_code = strtoupper( substr( md5( $student_name . '|' . date( 'Y-m-d', $ts ) ), 0, 8 ) );

get_header();
?>

<main id="main-content" class="cst-main cst-certificate-main">
    <div class="cst-certificate-toolbar cst-no-print">
        <p>
            <?php esc_html_e( 'Esta es la versión imprimible de su certificado. Use el botón "Imprimir" o el atajo Ctrl/Cmd + P para guardarlo como PDF.', 'cst-cannabis' ); ?>
        </p>
        <button type="button" class="cst-btn cst-btn--primary" onclick="window.print()">
            <?php esc_html_e( 'Imprimir o guardar como PDF', 'cst-cannabis' ); ?>
        </button>
    </div>

    <article class="cst-certificate" role="document" aria-label="<?php esc_attr_e( 'Certificado de aprobación', 'cst-cannabis' ); ?>">
        <div class="cst-certificate__border">
            <header class="cst-certificate__header">
                <?php if ( $logo_id ) : ?>
                    <?php echo wp_get_attachment_image( $logo_id, 'medium', false, [ 'class' => 'cst-certificate__logo', 'alt' => esc_attr__( 'Sello CST', 'cst-cannabis' ) ] ); ?>
                <?php endif; ?>
                <p class="cst-certificate__agency"><?php esc_html_e( 'Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ); ?></p>
                <p class="cst-certificate__sub-agency"><?php esc_html_e( 'Estado Libre Asociado de Puerto Rico', 'cst-cannabis' ); ?></p>
            </header>

            <h1 class="cst-certificate__title"><?php esc_html_e( 'Certificado de Aprobación', 'cst-cannabis' ); ?></h1>

            <p class="cst-certificate__intro"><?php esc_html_e( 'Se otorga el presente certificado a', 'cst-cannabis' ); ?></p>
            <p class="cst-certificate__name"><?php echo esc_html( $student_name ); ?></p>

            <p class="cst-certificate__body">
                <?php esc_html_e( 'por haber completado satisfactoriamente el curso', 'cst-cannabis' ); ?>
                <strong><?php esc_html_e( 'Cannabis Medicinal y Seguridad Vial', 'cst-cannabis' ); ?></strong>
                <?php esc_html_e( 'el día', 'cst-cannabis' ); ?>
                <strong><?php echo esc_html( $date_display ); ?></strong>.
            </p>

            <footer class="cst-certificate__footer">
                <div class="cst-certificate__signature">
                    <?php if ( $signature_id ) : ?>
                        <?php echo wp_get_attachment_image( $signature_id, 'medium', false, [ 'class' => 'cst-certificate__signature-img', 'alt' => '' ] ); ?>
                    <?php endif; ?>
                    <p class="cst-certificate__signature-line"></p>
                    <p class="cst-certificate__signature-name"><?php echo esc_html( $director_name ); ?></p>
                    <p class="cst-certificate__signature-title"><?php echo esc_html( $director_title ); ?></p>
                </div>

                <div class="cst-certificate__verification">
                    <p class="cst-certificate__verification-label"><?php esc_html_e( 'Código de verificación', 'cst-cannabis' ); ?></p>
                    <p class="cst-certificate__verification-code"><?php echo esc_html( $verification_code ); ?></p>
                </div>
            </footer>
        </div>
    </article>
</main>

<style>
.cst-certificate-toolbar{max-width:900px;margin:24px auto;padding:16px 20px;background:var(--cst-callout-bg-info,#eef5fb);border-left:4px solid var(--cst-color-accent,#3B82C4);display:flex;align-items:center;gap:20px;justify-content:space-between;flex-wrap:wrap;border-radius:var(--cst-border-radius,6px)}
.cst-certificate-toolbar p{margin:0;flex:1 1 320px}
.cst-certificate{max-width:1100px;margin:0 auto 64px;padding:24px;background:#fff;box-shadow:0 12px 40px rgba(0,0,0,.08)}
.cst-certificate__border{padding:48px 56px;border:6px double var(--cst-color-primary,#5E7C3A);position:relative;text-align:center;font-family:var(--cst-font-body,'Open Sans',sans-serif)}
.cst-certificate__header{display:flex;flex-direction:column;align-items:center;margin-bottom:28px}
.cst-certificate__logo{max-width:120px;height:auto;margin-bottom:12px}
.cst-certificate__agency{font-family:var(--cst-font-heading,'Montserrat',sans-serif);font-weight:700;font-size:1.1rem;margin:0;color:var(--cst-color-navy,#1C2854);letter-spacing:.04em;text-transform:uppercase}
.cst-certificate__sub-agency{margin:4px 0 0;font-size:.9rem;color:#555}
.cst-certificate__title{font-family:var(--cst-font-heading,'Montserrat',sans-serif);font-size:2.5rem;font-weight:800;letter-spacing:.05em;color:var(--cst-color-primary,#5E7C3A);margin:24px 0;text-transform:uppercase}
.cst-certificate__intro{font-size:1.05rem;margin:8px 0;color:#444}
.cst-certificate__name{font-family:var(--cst-font-heading,'Montserrat',sans-serif);font-size:2rem;font-weight:700;color:var(--cst-color-navy,#1C2854);margin:8px 0 24px;border-bottom:1px solid #ccc;padding-bottom:14px;display:inline-block;min-width:60%}
.cst-certificate__body{font-size:1.05rem;line-height:1.7;max-width:720px;margin:0 auto 48px;color:#333}
.cst-certificate__footer{display:flex;align-items:flex-end;justify-content:space-between;margin-top:48px;gap:32px;flex-wrap:wrap}
.cst-certificate__signature{flex:1 1 280px;text-align:center;min-width:240px}
.cst-certificate__signature-img{max-height:80px;width:auto;display:block;margin:0 auto -10px}
.cst-certificate__signature-line{border-top:1px solid #444;margin:0 auto 8px;width:280px;height:1px}
.cst-certificate__signature-name{font-weight:700;margin:0;color:var(--cst-color-navy,#1C2854)}
.cst-certificate__signature-title{font-size:.85rem;margin:2px 0 0;color:#555}
.cst-certificate__verification{flex:0 0 auto;text-align:right;font-family:monospace}
.cst-certificate__verification-label{font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:#666;margin:0 0 4px}
.cst-certificate__verification-code{font-size:1rem;font-weight:700;color:var(--cst-color-navy,#1C2854);margin:0;letter-spacing:.06em}
@media print{
  .cst-no-print,.site-header,.site-footer,.cst-institutional-header,.cst-institutional-footer,.cst-chatbot,.cst-whatsapp,.cst-gov-banner,.cst-consent{display:none!important}
  body{background:#fff!important;margin:0!important;padding:0!important}
  .cst-main{padding:0!important;margin:0!important}
  .cst-certificate{box-shadow:none;margin:0;padding:0;max-width:none}
  .cst-certificate__border{padding:36px 48px}
  @page{size:A4 landscape;margin:12mm}
}
</style>

<?php
get_footer();
