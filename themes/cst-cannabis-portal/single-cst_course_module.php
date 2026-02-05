<?php
/**
 * Single template for cst_course_module CPT.
 *
 * Displays lesson content, learning objectives, and quiz assessment.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php while ( have_posts() ) : the_post();
        $module_id  = get_the_ID();
        $order      = get_post_meta( $module_id, '_cst_module_order', true );
        $duration   = get_post_meta( $module_id, '_cst_module_duration', true );
        $objectives = class_exists( 'CST_Course' ) ? CST_Course::get_objectives( $module_id ) : [];
        $quiz_data  = class_exists( 'CST_Course' ) ? CST_Course::get_quiz_data( $module_id ) : [];
        $modules    = class_exists( 'CST_Course' ) ? CST_Course::get_ordered_modules() : [];

        // Find prev/next modules.
        $prev_module = null;
        $next_module = null;
        foreach ( $modules as $i => $mod ) {
            if ( $mod->ID === $module_id ) {
                if ( $i > 0 ) {
                    $prev_module = $modules[ $i - 1 ];
                }
                if ( $i < count( $modules ) - 1 ) {
                    $next_module = $modules[ $i + 1 ];
                }
                break;
            }
        }
    ?>

    <?php
    cst_hero( [
        'title'    => sprintf( __( 'Módulo %s: %s', 'cst-cannabis' ), $order, get_the_title() ),
        'subtitle' => get_the_excerpt(),
        'class'    => 'cst-hero--page cst-hero--lesson',
    ] );
    ?>

    <!-- Module Meta Bar -->
    <div class="cst-module-meta-bar">
        <div class="cst-container">
            <div class="cst-module-meta-bar__inner">
                <?php if ( $duration ) : ?>
                    <span class="cst-module-meta-bar__item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                        <?php printf( esc_html__( 'Duración: %d minutos', 'cst-cannabis' ), (int) $duration ); ?>
                    </span>
                <?php endif; ?>
                <span class="cst-module-meta-bar__item">
                    <?php printf(
                        esc_html__( 'Módulo %1$s de %2$s', 'cst-cannabis' ),
                        esc_html( $order ),
                        esc_html( count( $modules ) )
                    ); ?>
                </span>
                <?php if ( ! empty( $quiz_data ) ) : ?>
                    <span class="cst-module-meta-bar__item cst-module-meta-bar__item--quiz">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14h-2v-2h2v2zm2.07-7.75l-.9.92C12.45 10.9 12 11.5 12 13h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
                        <?php esc_html_e( 'Incluye evaluación', 'cst-cannabis' ); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <section class="cst-section cst-section--lesson-content">
        <div class="cst-container">
            <div class="cst-lesson-layout">

                <!-- Sidebar Navigation -->
                <aside class="cst-lesson-sidebar" aria-label="<?php esc_attr_e( 'Navegación del curso', 'cst-cannabis' ); ?>">
                    <nav class="cst-lesson-nav">
                        <h2 class="cst-lesson-nav__title"><?php esc_html_e( 'Módulos del curso', 'cst-cannabis' ); ?></h2>
                        <?php if ( ! empty( $modules ) ) : ?>
                            <ol class="cst-lesson-nav__list">
                                <?php foreach ( $modules as $mod ) :
                                    $mod_order = get_post_meta( $mod->ID, '_cst_module_order', true );
                                    $is_current = ( $module_id === $mod->ID );
                                ?>
                                    <li class="cst-lesson-nav__item <?php echo $is_current ? 'is-current' : ''; ?>">
                                        <a href="<?php echo esc_url( get_permalink( $mod->ID ) ); ?>"
                                           <?php echo $is_current ? 'aria-current="page"' : ''; ?>
                                           data-module-id="<?php echo esc_attr( $mod->ID ); ?>">
                                            <span class="cst-lesson-nav__number"><?php echo esc_html( $mod_order ); ?></span>
                                            <span class="cst-lesson-nav__text"><?php echo esc_html( $mod->post_title ); ?></span>
                                            <span class="cst-lesson-nav__check" id="nav-check-<?php echo esc_attr( $mod->ID ); ?>" aria-hidden="true"></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( home_url( '/curso/' ) ); ?>" class="cst-btn cst-btn--outline cst-btn--sm cst-lesson-nav__back">
                            <?php esc_html_e( 'Volver al currículo', 'cst-cannabis' ); ?>
                        </a>
                    </nav>
                </aside>

                <!-- Main Content -->
                <div class="cst-lesson-main">

                    <?php if ( ! empty( $objectives ) ) : ?>
                        <div class="cst-learning-objectives" role="region" aria-label="<?php esc_attr_e( 'Objetivos de aprendizaje', 'cst-cannabis' ); ?>">
                            <h2 class="cst-learning-objectives__title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L18 9l-8 8z"/></svg>
                                <?php esc_html_e( 'Al completar este módulo usted podrá:', 'cst-cannabis' ); ?>
                            </h2>
                            <ul class="cst-learning-objectives__list">
                                <?php foreach ( $objectives as $obj ) : ?>
                                    <li><?php echo esc_html( $obj ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <article class="cst-lesson-content cst-content-area">
                        <?php the_content(); ?>
                    </article>

                    <!-- Mark as Read Button -->
                    <div class="cst-lesson-complete" id="cst-lesson-complete">
                        <button type="button" class="cst-btn cst-btn--primary cst-btn--lg" id="cst-mark-read" data-module-id="<?php echo esc_attr( $module_id ); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            <?php esc_html_e( 'Marcar como leído', 'cst-cannabis' ); ?>
                        </button>
                    </div>

                    <?php if ( ! empty( $quiz_data ) ) : ?>
                        <!-- Quiz Section -->
                        <section class="cst-quiz" id="cst-quiz" aria-label="<?php esc_attr_e( 'Evaluación del módulo', 'cst-cannabis' ); ?>" data-module-id="<?php echo esc_attr( $module_id ); ?>">
                            <div class="cst-quiz__header">
                                <h2 class="cst-quiz__title"><?php esc_html_e( 'Evaluación del módulo', 'cst-cannabis' ); ?></h2>
                                <p class="cst-quiz__description">
                                    <?php printf(
                                        esc_html__( 'Responda las siguientes %d preguntas. Necesita un 70%% o más para aprobar.', 'cst-cannabis' ),
                                        count( $quiz_data )
                                    ); ?>
                                </p>
                            </div>

                            <div class="cst-quiz__questions" id="cst-quiz-questions">
                                <?php foreach ( $quiz_data as $q_index => $question ) : ?>
                                    <fieldset class="cst-quiz__question" data-question="<?php echo esc_attr( $q_index ); ?>" data-correct="<?php echo esc_attr( $question['correct'] ); ?>">
                                        <legend class="cst-quiz__question-text">
                                            <span class="cst-quiz__question-number"><?php echo esc_html( $q_index + 1 ); ?>.</span>
                                            <?php echo esc_html( $question['question'] ); ?>
                                        </legend>
                                        <div class="cst-quiz__options">
                                            <?php foreach ( $question['options'] as $o_index => $option ) : ?>
                                                <label class="cst-quiz__option">
                                                    <input type="radio"
                                                           name="question_<?php echo esc_attr( $q_index ); ?>"
                                                           value="<?php echo esc_attr( $o_index ); ?>"
                                                           class="cst-quiz__radio">
                                                    <span class="cst-quiz__option-text"><?php echo esc_html( $option ); ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if ( ! empty( $question['explanation'] ) ) : ?>
                                            <div class="cst-quiz__explanation" hidden>
                                                <p><?php echo esc_html( $question['explanation'] ); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </fieldset>
                                <?php endforeach; ?>
                            </div>

                            <div class="cst-quiz__actions">
                                <button type="button" class="cst-btn cst-btn--primary" id="cst-quiz-submit">
                                    <?php esc_html_e( 'Enviar respuestas', 'cst-cannabis' ); ?>
                                </button>
                            </div>

                            <div class="cst-quiz__results" id="cst-quiz-results" hidden>
                                <div class="cst-quiz__score">
                                    <span class="cst-quiz__score-value" id="cst-quiz-score">0</span>
                                    <span class="cst-quiz__score-label"><?php esc_html_e( 'Puntuación', 'cst-cannabis' ); ?></span>
                                </div>
                                <p class="cst-quiz__result-text" id="cst-quiz-result-text"></p>
                                <div class="cst-quiz__result-actions">
                                    <button type="button" class="cst-btn cst-btn--outline" id="cst-quiz-retry" hidden>
                                        <?php esc_html_e( 'Intentar de nuevo', 'cst-cannabis' ); ?>
                                    </button>
                                    <a href="#" class="cst-btn cst-btn--primary" id="cst-quiz-next" hidden>
                                        <?php esc_html_e( 'Siguiente módulo', 'cst-cannabis' ); ?>
                                    </a>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <!-- Prev/Next Navigation -->
                    <nav class="cst-lesson-pagination" aria-label="<?php esc_attr_e( 'Navegación entre módulos', 'cst-cannabis' ); ?>">
                        <?php if ( $prev_module ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $prev_module->ID ) ); ?>" class="cst-lesson-pagination__link cst-lesson-pagination__link--prev">
                                <span class="cst-lesson-pagination__direction"><?php esc_html_e( 'Anterior', 'cst-cannabis' ); ?></span>
                                <span class="cst-lesson-pagination__title"><?php echo esc_html( $prev_module->post_title ); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ( $next_module ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $next_module->ID ) ); ?>" class="cst-lesson-pagination__link cst-lesson-pagination__link--next" id="cst-next-module-link">
                                <span class="cst-lesson-pagination__direction"><?php esc_html_e( 'Siguiente', 'cst-cannabis' ); ?></span>
                                <span class="cst-lesson-pagination__title"><?php echo esc_html( $next_module->post_title ); ?></span>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url( home_url( '/certificado/' ) ); ?>" class="cst-lesson-pagination__link cst-lesson-pagination__link--next cst-lesson-pagination__link--certificate" id="cst-certificate-link">
                                <span class="cst-lesson-pagination__direction"><?php esc_html_e( 'Finalizar', 'cst-cannabis' ); ?></span>
                                <span class="cst-lesson-pagination__title"><?php esc_html_e( 'Obtener certificado', 'cst-cannabis' ); ?></span>
                            </a>
                        <?php endif; ?>
                    </nav>

                </div>
            </div>
        </div>
    </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
