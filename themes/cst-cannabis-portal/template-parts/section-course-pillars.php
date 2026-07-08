<?php
/**
 * Template Part: Course Pillars (homepage, below hero).
 *
 * Mirrors the willai course-site "¿En qué consiste este curso?" section:
 * an intro paragraph on the left + three benefit cards on the right
 * (Consumo responsable / Seguridad vial / Protección familiar).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$pillars = [
    [
        // Pill / medication icon (matches Pencil's "pill" icon for this card).
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>',
        'accent' => 'green',
        'title'  => __( 'Consumo responsable y toma de decisiones', 'cst-cannabis' ),
        'desc'   => __( 'Ofrece orientación clara sobre el uso responsable del cannabis medicinal, señales de afectación y prácticas que reducen riesgos en la vida diaria, promoviendo decisiones informadas y seguras.', 'cst-cannabis' ),
    ],
    [
        // Car-front icon (matches Pencil's "car-front" icon for this card).
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 8-2 2-1.5-3.7A2 2 0 0 0 15.6 5H8.4a2 2 0 0 0-1.9 1.3L5 10 3 8"/><rect width="18" height="8" x="3" y="10" rx="2"/><path d="M7 14h.01"/><path d="M17 14h.01"/><path d="M5 18v2"/><path d="M19 18v2"/></svg>',
        'accent' => 'blue',
        'title'  => __( 'Seguridad vial y cumplimiento en tránsito', 'cst-cannabis' ),
        'desc'   => __( 'Aborda el impacto del cannabis medicinal en la conducción, las responsabilidades legales vigentes en Puerto Rico y las alternativas seguras para evitar conducir bajo los efectos.', 'cst-cannabis' ),
    ],
    [
        // Users icon (matches Pencil's "users" icon for this card).
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/></svg>',
        'accent' => 'navy',
        'title'  => __( 'Protección familiar y corresponsabilidad ciudadana', 'cst-cannabis' ),
        'desc'   => __( 'Promueve entornos seguros en el hogar, la protección de menores y la corresponsabilidad entre ciudadanos, instituciones y comunidades para prevenir incidentes y daños evitables.', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--pillars" id="proposito"
         aria-labelledby="cst-pillars-title">
    <div class="cst-container">
        <header class="cst-pillars__intro">
            <span class="cst-pillars__eyebrow">
                <span class="cst-pillars__eyebrow-dot" aria-hidden="true"></span>
                <?php esc_html_e( 'Propósito', 'cst-cannabis' ); ?>
            </span>
            <h2 id="cst-pillars-title" class="cst-pillars__title">
                <?php esc_html_e( '¿En qué consiste este curso?', 'cst-cannabis' ); ?>
            </h2>
            <p class="cst-pillars__lead">
                <?php
                printf(
                    wp_kses(
                        __( 'Frente al auge del <strong>cannabis medicinal en Puerto Rico</strong>, esta plataforma de orientación ciudadana busca armonizar los beneficios terapéuticos con la seguridad legal y social. Ofrece información clave sobre <strong>consumo responsable, normativas de tránsito y protección familiar</strong> en tres áreas clave:', 'cst-cannabis' ),
                        [ 'strong' => [] ]
                    )
                );
                ?>
            </p>
        </header>

        <div class="cst-pillars__grid">
            <?php foreach ( $pillars as $pillar ) : ?>
                <article class="cst-pillar-card">
                    <div class="cst-pillar-card__icon cst-pillar-card__icon--<?php echo esc_attr( $pillar['accent'] ); ?>" aria-hidden="true">
                        <?php echo cst_kses_svg( $pillar['icon'] ); ?>
                    </div>
                    <h3 class="cst-pillar-card__title">
                        <?php echo esc_html( $pillar['title'] ); ?>
                    </h3>
                    <p class="cst-pillar-card__desc">
                        <?php echo esc_html( $pillar['desc'] ); ?>
                    </p>
                    <a class="cst-pillar-card__link" href="<?php echo esc_url( cst_course_url() ); ?>">
                        <?php esc_html_e( 'Saber más', 'cst-cannabis' ); ?>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="cst-pillars__footer">
            <a class="cst-pillars__cta" href="<?php echo esc_url( cst_course_url() ); ?>">
                <?php esc_html_e( 'Ver curso completo', 'cst-cannabis' ); ?>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>
</section>
