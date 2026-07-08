<?php
/**
 * Template Part: Course modules / learning objectives (home page).
 *
 * "Lo que aprenderás" — course-content modules. Mirrors the Pencil design
 * (frame GycwK): eyebrow + centered head, then a row of flat white bordered
 * cards, each led by a green-wash number chip (01, 02, …).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$objectives = [
    [
        'title' => __( 'Fundamentos del cannabis medicinal', 'cst-cannabis' ),
        'desc'  => __( 'Proveer información basada en evidencia sobre el uso responsable del cannabis medicinal y su impacto en la seguridad vial.', 'cst-cannabis' ),
    ],
    [
        'title' => __( 'Impacto en la conducción', 'cst-cannabis' ),
        'desc'  => __( 'Crear conciencia sobre los efectos del cannabis en la conducción y promover alternativas seguras de transporte.', 'cst-cannabis' ),
    ],
    [
        'title' => __( 'Datos y estadísticas', 'cst-cannabis' ),
        'desc'  => __( 'Recopilar y publicar datos estadísticos actualizados que apoyen políticas públicas informadas.', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--objectives" id="objetivos"
         aria-labelledby="cst-objectives-title">
    <div class="cst-container">
        <header class="cst-objectives__intro">
            <span class="cst-objectives__eyebrow">
                <span class="cst-objectives__eyebrow-dot" aria-hidden="true"></span>
                <?php esc_html_e( 'Contenido del curso', 'cst-cannabis' ); ?>
            </span>
            <h2 id="cst-objectives-title" class="cst-objectives__title">
                <?php esc_html_e( 'Lo que aprenderás', 'cst-cannabis' ); ?>
            </h2>
            <p class="cst-objectives__lead">
                <?php esc_html_e( 'Tres módulos diseñados para que domines los fundamentos de la seguridad vial y el cannabis medicinal.', 'cst-cannabis' ); ?>
            </p>
        </header>

        <div class="cst-objectives-grid">
            <?php foreach ( $objectives as $index => $obj ) : ?>
                <article class="cst-objective-card">
                    <span class="cst-objective-card__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
                    <h3 class="cst-objective-card__title"><?php echo esc_html( $obj['title'] ); ?></h3>
                    <p class="cst-objective-card__desc"><?php echo esc_html( $obj['desc'] ); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
