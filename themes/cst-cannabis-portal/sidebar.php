<?php
/**
 * Sidebar — newspaper-style for single posts.
 *
 * Displays categories, related posts, upcoming events, and CTA banner.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! is_single() ) {
    return;
}
?>
<aside id="right-sidebar" class="cst-sidebar widget-area" role="complementary"
       aria-label="<?php esc_attr_e( 'Barra lateral', 'cst-cannabis' ); ?>">

    <!-- Sabías que -->
    <?php
    $facts = [
        [
            'icon'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>',
            'dot_icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>',
            'text'     => __( 'El cannabis medicinal puede afectar los reflejos y el tiempo de reacción hasta 4 horas después del consumo.', 'cst-cannabis' ),
        ],
        [
            'icon'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
            'dot_icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
            'text'     => __( 'Conducir bajo los efectos del cannabis aumenta el riesgo de accidentes en un 30%, según estudios recientes.', 'cst-cannabis' ),
        ],
        [
            'icon'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>',
            'dot_icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>',
            'text'     => __( 'En Puerto Rico, conducir bajo la influencia de cannabis medicinal puede resultar en multas y suspensión de licencia.', 'cst-cannabis' ),
        ],
        [
            'icon'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>',
            'dot_icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>',
            'text'     => __( 'El THC, principal componente psicoactivo del cannabis, afecta la percepción de distancia y velocidad al conducir.', 'cst-cannabis' ),
        ],
        [
            'icon'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.48 12.35c-1.57-4.08-7.16-4.3-5.81-10.23.1-.44-.37-.78-.75-.55C9.29 3.71 6.68 8 8.87 13.62c.18.46-.36.89-.75.59-1.81-1.37-2.2-3.76-1.77-5.08C3.55 11.27 2 14.23 2 17.5 2 21.08 5.58 24 10 24c4.41 0 8-2.92 8-6.5 0-2.23-1.29-4.14-2.52-5.15z"/></svg>',
            'dot_icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.48 12.35c-1.57-4.08-7.16-4.3-5.81-10.23.1-.44-.37-.78-.75-.55C9.29 3.71 6.68 8 8.87 13.62c.18.46-.36.89-.75.59-1.81-1.37-2.2-3.76-1.77-5.08C3.55 11.27 2 14.23 2 17.5 2 21.08 5.58 24 10 24c4.41 0 8-2.92 8-6.5 0-2.23-1.29-4.14-2.52-5.15z"/></svg>',
            'text'     => __( 'Mezclar cannabis con alcohol multiplica el riesgo de accidentes de tránsito significativamente.', 'cst-cannabis' ),
        ],
        [
            'icon'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>',
            'dot_icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>',
            'text'     => __( 'Los pacientes de cannabis medicinal tienen la responsabilidad legal de no conducir si sus capacidades están comprometidas.', 'cst-cannabis' ),
        ],
    ];
    shuffle( $facts );
    ?>
    <div class="cst-sidebar__widget cst-sidebar__sabias-que" aria-label="<?php esc_attr_e( 'Datos sobre cannabis y conducción', 'cst-cannabis' ); ?>">
        <h3 class="cst-sidebar__title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="cst-sabias-que__bulb">
                <path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7z"/>
            </svg>
            <?php esc_html_e( '¿Sabías que...?', 'cst-cannabis' ); ?>
        </h3>

        <div class="cst-sabias-que__carousel" role="region" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Datos sobre cannabis y conducción', 'cst-cannabis' ); ?>">
            <div class="cst-sabias-que__track">
                <?php foreach ( $facts as $i => $fact ) : ?>
                    <div class="cst-sabias-que__slide <?php echo 0 === $i ? 'cst-sabias-que__slide--active' : ''; ?>"
                         role="group" aria-roledescription="slide"
                         aria-label="<?php printf( esc_attr__( 'Dato %d de %d', 'cst-cannabis' ), $i + 1, count( $facts ) ); ?>"
                         <?php echo 0 !== $i ? 'aria-hidden="true"' : ''; ?>>
                        <div class="cst-sabias-que__icon">
                            <?php echo wp_kses_post( $fact['icon'] ); ?>
                        </div>
                        <p class="cst-sabias-que__text"><?php echo esc_html( $fact['text'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cst-sabias-que__controls">
                <div class="cst-sabias-que__dots" role="tablist" aria-label="<?php esc_attr_e( 'Seleccionar dato', 'cst-cannabis' ); ?>">
                    <?php foreach ( $facts as $i => $fact ) : ?>
                        <button class="cst-sabias-que__dot <?php echo 0 === $i ? 'cst-sabias-que__dot--active' : ''; ?>"
                                role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
                                aria-label="<?php printf( esc_attr__( 'Dato %d', 'cst-cannabis' ), $i + 1 ); ?>"
                                data-index="<?php echo esc_attr( $i ); ?>"
                                type="button">
                            <?php echo wp_kses_post( $fact['dot_icon'] ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <button class="cst-sabias-que__next" type="button"
                        aria-label="<?php esc_attr_e( 'Siguiente dato', 'cst-cannabis' ); ?>">
                    <?php esc_html_e( 'Otro dato', 'cst-cannabis' ); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- CTA Banner -->
    <div class="cst-sidebar__widget cst-sidebar__banner">
        <div class="cst-sidebar__banner-inner">
            <h3 class="cst-sidebar__banner-title"><?php esc_html_e( 'Inscríbete al curso', 'cst-cannabis' ); ?></h3>
            <p class="cst-sidebar__banner-text"><?php esc_html_e( 'Curso gratuito sobre cannabis medicinal y seguridad vial. Obtén tu certificado digital.', 'cst-cannabis' ); ?></p>
            <a href="<?php echo esc_url( cst_course_url() ); ?>" class="cst-btn cst-btn--primary cst-btn--sm">
                <?php esc_html_e( 'Ver Curso', 'cst-cannabis' ); ?>
            </a>
        </div>
    </div>

    <!-- Related Posts -->
    <?php
    $related = new WP_Query( [
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'post__not_in'   => [ get_the_ID() ],
        'orderby'        => 'date',
        'order'          => 'DESC',
        'category__in'   => wp_get_post_categories( get_the_ID() ),
    ] );

    if ( $related->have_posts() ) :
    ?>
    <div class="cst-sidebar__widget cst-sidebar__related">
        <h3 class="cst-sidebar__title"><?php esc_html_e( 'Artículos relacionados', 'cst-cannabis' ); ?></h3>
        <ul class="cst-sidebar__post-list">
            <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                <li class="cst-sidebar__post-item">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="cst-sidebar__post-thumb">
                            <?php the_post_thumbnail( 'thumbnail', [ 'loading' => 'lazy' ] ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="cst-sidebar__post-info">
                        <a href="<?php the_permalink(); ?>" class="cst-sidebar__post-link">
                            <?php the_title(); ?>
                        </a>
                        <time class="cst-sidebar__post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                            <?php echo esc_html( get_the_date() ); ?>
                        </time>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php
    wp_reset_postdata();
    endif;
    ?>

    <!-- Upcoming Events -->
    <div class="cst-sidebar__widget cst-sidebar__events">
        <h3 class="cst-sidebar__title"><?php esc_html_e( 'Próximos eventos', 'cst-cannabis' ); ?></h3>
        <ul class="cst-sidebar__event-list">
            <li class="cst-sidebar__event-item">
                <div class="cst-sidebar__event-date-badge">
                    <span class="cst-sidebar__event-month"><?php esc_html_e( 'MAY', 'cst-cannabis' ); ?></span>
                    <span class="cst-sidebar__event-day">15</span>
                </div>
                <div class="cst-sidebar__event-info">
                    <strong><?php esc_html_e( 'Taller de Seguridad Vial', 'cst-cannabis' ); ?></strong>
                    <span><?php esc_html_e( 'Centro de Convenciones, San Juan', 'cst-cannabis' ); ?></span>
                </div>
            </li>
            <li class="cst-sidebar__event-item">
                <div class="cst-sidebar__event-date-badge">
                    <span class="cst-sidebar__event-month"><?php esc_html_e( 'JUN', 'cst-cannabis' ); ?></span>
                    <span class="cst-sidebar__event-day">02</span>
                </div>
                <div class="cst-sidebar__event-info">
                    <strong><?php esc_html_e( 'Foro Cannabis y Conducción', 'cst-cannabis' ); ?></strong>
                    <span><?php esc_html_e( 'UPR Río Piedras', 'cst-cannabis' ); ?></span>
                </div>
            </li>
            <li class="cst-sidebar__event-item">
                <div class="cst-sidebar__event-date-badge">
                    <span class="cst-sidebar__event-month"><?php esc_html_e( 'JUN', 'cst-cannabis' ); ?></span>
                    <span class="cst-sidebar__event-day">20</span>
                </div>
                <div class="cst-sidebar__event-info">
                    <strong><?php esc_html_e( 'Charla Educativa Comunitaria', 'cst-cannabis' ); ?></strong>
                    <span><?php esc_html_e( 'Ponce, PR', 'cst-cannabis' ); ?></span>
                </div>
            </li>
        </ul>
    </div>

    <!-- Contact -->
    <div class="cst-sidebar__widget cst-sidebar__contact">
        <h3 class="cst-sidebar__title"><?php esc_html_e( 'Contacto', 'cst-cannabis' ); ?></h3>
        <p>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            <a href="mailto:<?php echo esc_attr( get_theme_mod( 'cst_email', 'comunicaciones@cst.pr.gov' ) ); ?>">
                <?php echo esc_html( get_theme_mod( 'cst_email', 'comunicaciones@cst.pr.gov' ) ); ?>
            </a>
        </p>
        <p>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            <a href="tel:7877214142"><?php echo esc_html( get_theme_mod( 'cst_phone', '787-721-4142' ) ); ?></a>
        </p>
    </div>

</aside>
