<?php
/**
 * Template Name: Página de inicio
 * Template Post Type: page
 *
 * Front page: hero, course CTA, objectives, course modules preview, stats, resources CTA.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$modules = class_exists( 'CST_Course' ) ? CST_Course::get_ordered_modules() : [];
?>

<main id="main-content" class="cst-main">

    <?php
    // Hero section — driver education focused.
    $hero_title    = get_theme_mod( 'cst_hero_title', '' ) ?: __( 'Cannabis y Conducción Segura', 'cst-cannabis' );
    $hero_subtitle = get_theme_mod( 'cst_hero_subtitle', '' ) ?: __( 'Curso oficial de educación vial sobre los efectos del cannabis en la conducción. Aprenda a tomar decisiones responsables y proteja su vida y la de los demás.', 'cst-cannabis' );
    cst_hero( [
        'title'    => $hero_title,
        'subtitle' => $hero_subtitle,
        'cta_text' => __( 'Comenzar el curso gratuito', 'cst-cannabis' ),
        'cta_url'  => home_url( '/curso/' ),
        'class'    => 'cst-hero--home',
    ] );
    ?>

    <?php // Objectives grid — driver education focused. ?>
    <?php get_template_part( 'template-parts/section', 'objectives-driver' ); ?>

    <?php // Course Modules Preview. ?>
    <?php if ( ! empty( $modules ) ) : ?>
    <section class="cst-section cst-section--course-preview" id="curso-modulos" aria-label="<?php esc_attr_e( 'Módulos del curso', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <?php cst_section_heading(
                __( 'Contenido del curso', 'cst-cannabis' ),
                __( 'Un programa completo diseñado por expertos en seguridad vial y salud pública.', 'cst-cannabis' )
            ); ?>

            <div class="cst-course-preview-grid">
                <?php foreach ( array_slice( $modules, 0, 6 ) as $index => $module ) :
                    $order    = get_post_meta( $module->ID, '_cst_module_order', true ) ?: ( $index + 1 );
                    $duration = get_post_meta( $module->ID, '_cst_module_duration', true );
                ?>
                    <a href="<?php echo esc_url( get_permalink( $module->ID ) ); ?>" class="cst-course-preview-card">
                        <span class="cst-course-preview-card__number"><?php echo esc_html( $order ); ?></span>
                        <h3 class="cst-course-preview-card__title"><?php echo esc_html( $module->post_title ); ?></h3>
                        <?php if ( $module->post_excerpt ) : ?>
                            <p class="cst-course-preview-card__excerpt"><?php echo esc_html( wp_trim_words( $module->post_excerpt, 15 ) ); ?></p>
                        <?php endif; ?>
                        <?php if ( $duration ) : ?>
                            <span class="cst-course-preview-card__duration"><?php printf( esc_html__( '%d min', 'cst-cannabis' ), (int) $duration ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="cst-section__footer cst-text-center">
                <?php cst_cta_button(
                    __( 'Ver currículo completo', 'cst-cannabis' ),
                    home_url( '/curso/' ),
                    'primary'
                ); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php // Why this course matters. ?>
    <section class="cst-section cst-section--why" aria-label="<?php esc_attr_e( 'Por qué es importante', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <?php cst_section_heading(
                __( '¿Por qué tomar este curso?', 'cst-cannabis' ),
                __( 'El cannabis puede afectar significativamente su capacidad de conducir de forma segura.', 'cst-cannabis' )
            ); ?>

            <div class="cst-why-grid">
                <div class="cst-why-card">
                    <div class="cst-why-card__icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    </div>
                    <h3 class="cst-why-card__title"><?php esc_html_e( 'Tiempo de reacción reducido', 'cst-cannabis' ); ?></h3>
                    <p class="cst-why-card__text"><?php esc_html_e( 'El THC puede aumentar su tiempo de reacción entre un 35% y un 60%, haciendo más difícil responder a situaciones de emergencia en la carretera.', 'cst-cannabis' ); ?></p>
                </div>
                <div class="cst-why-card">
                    <div class="cst-why-card__icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    </div>
                    <h3 class="cst-why-card__title"><?php esc_html_e( 'Percepción alterada', 'cst-cannabis' ); ?></h3>
                    <p class="cst-why-card__text"><?php esc_html_e( 'El cannabis afecta la percepción de distancia, velocidad y tiempo, tres elementos críticos para conducir de manera segura.', 'cst-cannabis' ); ?></p>
                </div>
                <div class="cst-why-card">
                    <div class="cst-why-card__icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M18 4l-4 4h3v7c0 1.1-.9 2-2 2s-2-.9-2-2V9c0-2.21-1.79-4-4-4S5 6.79 5 9v7H2l4 4 4-4H7V9c0-1.1.9-2 2-2s2 .9 2 2v6c0 2.21 1.79 4 4 4s4-1.79 4-4V8h3l-4-4z"/></svg>
                    </div>
                    <h3 class="cst-why-card__title"><?php esc_html_e( 'Control del vehículo', 'cst-cannabis' ); ?></h3>
                    <p class="cst-why-card__text"><?php esc_html_e( 'El cannabis dificulta mantener el carril, seguir trayectorias y manejar curvas, aumentando el riesgo de accidentes.', 'cst-cannabis' ); ?></p>
                </div>
                <div class="cst-why-card">
                    <div class="cst-why-card__icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    </div>
                    <h3 class="cst-why-card__title"><?php esc_html_e( 'Consecuencias legales', 'cst-cannabis' ); ?></h3>
                    <p class="cst-why-card__text"><?php esc_html_e( 'Conducir bajo los efectos del cannabis es ilegal y puede resultar en multas, pérdida de licencia, e incluso prisión.', 'cst-cannabis' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php // Latest blog posts. ?>
    <?php get_template_part( 'template-parts/section', 'latest-posts' ); ?>

    <?php // Statistics highlights. ?>
    <?php get_template_part( 'template-parts/section', 'stats-highlight' ); ?>

    <?php // Resources CTA. ?>
    <section class="cst-section cst-section--cta" aria-label="<?php esc_attr_e( 'Recursos educativos', 'cst-cannabis' ); ?>">
        <div class="cst-container cst-text-center">
            <?php cst_section_heading(
                __( 'Recursos educativos', 'cst-cannabis' ),
                __( 'Descargue guías, infografías y materiales sobre la conducción segura y los efectos del cannabis.', 'cst-cannabis' )
            ); ?>
            <?php cst_cta_button(
                __( 'Ver todos los recursos', 'cst-cannabis' ),
                home_url( '/recursos/' ),
                'primary'
            ); ?>
        </div>
    </section>

    <?php
    // Page content (if any).
    while ( have_posts() ) :
        the_post();
        $content = get_the_content();
        if ( trim( $content ) ) :
    ?>
        <section class="cst-section">
            <div class="cst-container cst-content-area">
                <?php the_content(); ?>
            </div>
        </section>
    <?php
        endif;
    endwhile;
    ?>

</main>

<?php
get_footer();
