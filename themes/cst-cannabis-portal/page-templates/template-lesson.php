<?php
/**
 * Template Name: Curso - Lección
 * Template Post Type: page
 *
 * Individual lesson/module page with content, learning objectives, quiz, and navigation.
 * Note: This template is for standalone lesson pages. Course module CPTs use single-cst_course_module.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php while ( have_posts() ) : the_post(); ?>

    <?php
    cst_hero( [
        'title'    => get_the_title(),
        'subtitle' => get_the_excerpt(),
        'class'    => 'cst-hero--page cst-hero--lesson',
    ] );
    ?>

    <section class="cst-section cst-section--lesson-content">
        <div class="cst-container">
            <div class="cst-lesson-layout">
                <!-- Sidebar Navigation -->
                <aside class="cst-lesson-sidebar" aria-label="<?php esc_attr_e( 'Navegación del curso', 'cst-cannabis' ); ?>">
                    <nav class="cst-lesson-nav">
                        <h2 class="cst-lesson-nav__title"><?php esc_html_e( 'Módulos del curso', 'cst-cannabis' ); ?></h2>
                        <?php
                        $modules = class_exists( 'CST_Course' ) ? CST_Course::get_ordered_modules() : [];
                        if ( ! empty( $modules ) ) :
                        ?>
                            <ol class="cst-lesson-nav__list">
                                <?php foreach ( $modules as $mod ) :
                                    $order = get_post_meta( $mod->ID, '_cst_module_order', true );
                                    $is_current = ( get_the_ID() === $mod->ID );
                                ?>
                                    <li class="cst-lesson-nav__item <?php echo $is_current ? 'is-current' : ''; ?>">
                                        <a href="<?php echo esc_url( get_permalink( $mod->ID ) ); ?>"
                                           <?php echo $is_current ? 'aria-current="page"' : ''; ?>
                                           data-module-id="<?php echo esc_attr( $mod->ID ); ?>">
                                            <span class="cst-lesson-nav__number"><?php echo esc_html( $order ); ?></span>
                                            <span class="cst-lesson-nav__text"><?php echo esc_html( $mod->post_title ); ?></span>
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
                <article class="cst-lesson-content cst-content-area">
                    <?php the_content(); ?>
                </article>
            </div>
        </div>
    </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
