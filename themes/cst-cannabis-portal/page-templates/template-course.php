<?php
/**
 * Template Name: Curso - Currículo
 * Template Post Type: page
 *
 * Course curriculum overview: shows all modules, progress tracker, and enrollment CTA.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$modules = class_exists( 'CST_Course' ) ? CST_Course::get_ordered_modules() : [];
$total_modules = count( $modules );
$total_duration = 0;
foreach ( $modules as $mod ) {
    $total_duration += (int) get_post_meta( $mod->ID, '_cst_module_duration', true );
}
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => __( 'Curso de Educación Vial y Cannabis', 'cst-cannabis' ),
        'subtitle' => __( 'Aprenda sobre los efectos del cannabis en la conducción, las leyes vigentes y cómo tomar decisiones responsables para proteger su vida y la de los demás.', 'cst-cannabis' ),
        'cta_text' => __( 'Comenzar el curso', 'cst-cannabis' ),
        'cta_url'  => '#modulos',
        'class'    => 'cst-hero--course',
    ] );
    ?>

    <!-- Course Overview Stats -->
    <section class="cst-section cst-section--course-overview" aria-label="<?php esc_attr_e( 'Resumen del curso', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <div class="cst-course-stats">
                <div class="cst-course-stat">
                    <span class="cst-course-stat__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </span>
                    <span class="cst-course-stat__value"><?php echo esc_html( $total_modules ); ?></span>
                    <span class="cst-course-stat__label"><?php esc_html_e( 'Módulos', 'cst-cannabis' ); ?></span>
                </div>
                <div class="cst-course-stat">
                    <span class="cst-course-stat__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                    </span>
                    <span class="cst-course-stat__value"><?php echo esc_html( $total_duration ); ?></span>
                    <span class="cst-course-stat__label"><?php esc_html_e( 'Minutos estimados', 'cst-cannabis' ); ?></span>
                </div>
                <div class="cst-course-stat">
                    <span class="cst-course-stat__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg>
                    </span>
                    <span class="cst-course-stat__value"><?php esc_html_e( 'Gratis', 'cst-cannabis' ); ?></span>
                    <span class="cst-course-stat__label"><?php esc_html_e( 'Certificado incluido', 'cst-cannabis' ); ?></span>
                </div>
                <div class="cst-course-stat">
                    <span class="cst-course-stat__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    </span>
                    <span class="cst-course-stat__value"><?php esc_html_e( 'Oficial', 'cst-cannabis' ); ?></span>
                    <span class="cst-course-stat__label"><?php esc_html_e( 'Avalado por la CST', 'cst-cannabis' ); ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Progress Bar (JS-powered) -->
    <section class="cst-section cst-section--progress" id="progreso" aria-label="<?php esc_attr_e( 'Progreso del curso', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <div class="cst-course-progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" aria-label="<?php esc_attr_e( 'Progreso general del curso', 'cst-cannabis' ); ?>">
                <div class="cst-course-progress__header">
                    <h2 class="cst-course-progress__title"><?php esc_html_e( 'Su progreso', 'cst-cannabis' ); ?></h2>
                    <span class="cst-course-progress__percentage" id="cst-progress-text">0%</span>
                </div>
                <div class="cst-course-progress__bar">
                    <div class="cst-course-progress__fill" id="cst-progress-fill" style="width:0%"></div>
                </div>
                <p class="cst-course-progress__status" id="cst-progress-status">
                    <?php esc_html_e( 'Complete todos los módulos y apruebe los quizzes para obtener su certificado.', 'cst-cannabis' ); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Course Modules -->
    <section class="cst-section cst-section--modules" id="modulos" aria-label="<?php esc_attr_e( 'Módulos del curso', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <?php cst_section_heading(
                __( 'Módulos del curso', 'cst-cannabis' ),
                __( 'Complete cada módulo en orden para avanzar en el curso. Cada módulo incluye contenido educativo y un quiz de evaluación.', 'cst-cannabis' )
            ); ?>

            <?php if ( ! empty( $modules ) ) : ?>
                <div class="cst-module-list" role="list">
                    <?php foreach ( $modules as $index => $module ) :
                        $order      = get_post_meta( $module->ID, '_cst_module_order', true ) ?: ( $index + 1 );
                        $duration   = get_post_meta( $module->ID, '_cst_module_duration', true );
                        $icon       = get_post_meta( $module->ID, '_cst_module_icon', true );
                        $objectives = CST_Course::get_objectives( $module->ID );
                        $quiz_data  = CST_Course::get_quiz_data( $module->ID );
                        $has_quiz   = ! empty( $quiz_data );
                    ?>
                        <article class="cst-module-card" role="listitem" data-module-id="<?php echo esc_attr( $module->ID ); ?>" data-module-order="<?php echo esc_attr( $order ); ?>">
                            <div class="cst-module-card__number">
                                <span class="cst-module-card__step"><?php echo esc_html( $order ); ?></span>
                            </div>
                            <div class="cst-module-card__content">
                                <div class="cst-module-card__header">
                                    <h3 class="cst-module-card__title">
                                        <a href="<?php echo esc_url( get_permalink( $module->ID ) ); ?>">
                                            <?php echo esc_html( $module->post_title ); ?>
                                        </a>
                                    </h3>
                                    <div class="cst-module-card__meta">
                                        <?php if ( $duration ) : ?>
                                            <span class="cst-module-card__duration">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                                                <?php printf( esc_html__( '%d min', 'cst-cannabis' ), (int) $duration ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ( $has_quiz ) : ?>
                                            <span class="cst-module-card__quiz-badge">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14h-2v-2h2v2zm2.07-7.75l-.9.92C12.45 10.9 12 11.5 12 13h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
                                                <?php esc_html_e( 'Quiz', 'cst-cannabis' ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="cst-module-card__status" id="module-status-<?php echo esc_attr( $module->ID ); ?>"></span>
                                    </div>
                                </div>
                                <?php if ( $module->post_excerpt ) : ?>
                                    <p class="cst-module-card__excerpt"><?php echo esc_html( $module->post_excerpt ); ?></p>
                                <?php endif; ?>
                                <?php if ( ! empty( $objectives ) ) : ?>
                                    <details class="cst-module-card__objectives">
                                        <summary><?php esc_html_e( 'Objetivos de aprendizaje', 'cst-cannabis' ); ?></summary>
                                        <ul>
                                            <?php foreach ( $objectives as $obj ) : ?>
                                                <li><?php echo esc_html( $obj ); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </details>
                                <?php endif; ?>
                                <div class="cst-module-card__actions">
                                    <a href="<?php echo esc_url( get_permalink( $module->ID ) ); ?>" class="cst-btn cst-btn--primary cst-btn--sm">
                                        <?php esc_html_e( 'Ir al módulo', 'cst-cannabis' ); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="cst-empty-state">
                    <p><?php esc_html_e( 'Los módulos del curso se publicarán próximamente.', 'cst-cannabis' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Course Important Notice -->
    <section class="cst-section cst-section--notice" aria-label="<?php esc_attr_e( 'Aviso importante', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <div class="cst-notice cst-notice--warning">
                <div class="cst-notice__icon" aria-hidden="true">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
                <div class="cst-notice__content">
                    <h3 class="cst-notice__title"><?php esc_html_e( 'Aviso Legal Importante', 'cst-cannabis' ); ?></h3>
                    <p><?php esc_html_e( 'Conducir bajo los efectos de cualquier sustancia que altere sus capacidades es ilegal en Puerto Rico y pone en riesgo su vida y la de los demás. Este curso es educativo y no sustituye el consejo legal o médico profesional. El uso recreativo del cannabis es ilegal en Puerto Rico.', 'cst-cannabis' ); ?></p>
                </div>
            </div>
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
