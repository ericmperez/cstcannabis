<?php
/**
 * 404 page — CST-branded.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">
    <?php
    cst_hero( [
        'title'    => __( 'Página no encontrada', 'cst-cannabis' ),
        'subtitle' => __( 'La página que busca no existe o ha sido movida.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page cst-hero--404',
    ] );
    ?>

    <section class="cst-section">
        <div class="cst-container cst-text-center">
            <p class="cst-404__code" aria-hidden="true">404</p>
            <h2><?php esc_html_e( '¿A dónde le gustaría ir?', 'cst-cannabis' ); ?></h2>
            <p>
                <?php esc_html_e( 'Pruebe alguna de las secciones del portal:', 'cst-cannabis' ); ?>
            </p>
            <ul class="cst-404__links">
                <li><a class="cst-btn cst-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php esc_html_e( 'Inicio', 'cst-cannabis' ); ?>
                </a></li>
                <li><a class="cst-btn cst-btn--outline" href="<?php echo esc_url( cst_course_url() ); ?>">
                    <?php esc_html_e( 'Ver Curso', 'cst-cannabis' ); ?>
                </a></li>
                <li><a class="cst-btn cst-btn--outline" href="<?php echo esc_url( home_url( '/recursos/' ) ); ?>">
                    <?php esc_html_e( 'Recursos', 'cst-cannabis' ); ?>
                </a></li>
                <li><a class="cst-btn cst-btn--outline" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
                    <?php esc_html_e( 'Contacto', 'cst-cannabis' ); ?>
                </a></li>
            </ul>

            <div class="cst-404__search">
                <h3><?php esc_html_e( 'O busque lo que necesita:', 'cst-cannabis' ); ?></h3>
                <?php get_search_form(); ?>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
