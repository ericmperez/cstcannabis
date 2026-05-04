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
        // Smoking / consumption icon.
        'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M2 16h12v3H2zm13.5 0H17v3h-1.5zm2.5 0h2v3h-2zM18 6.5C18 4.57 16.43 3 14.5 3v2c.83 0 1.5.67 1.5 1.5S15.33 8 14.5 8v2c1.93 0 3.5-1.57 3.5-3.5zM21 9h-1.5c-.83 0-1.5-.67-1.5-1.5S18.67 6 19.5 6V4c-1.93 0-3.5 1.57-3.5 3.5S17.57 11 19.5 11H21v4h2V9h-2z"/></svg>',
        'title' => __( 'Consumo responsable y toma de decisiones', 'cst-cannabis' ),
        'desc'  => __( 'Ofrece orientación clara sobre el uso responsable del cannabis medicinal, señales de afectación y prácticas que reducen riesgos en la vida diaria, promoviendo decisiones informadas y seguras.', 'cst-cannabis' ),
    ],
    [
        // Car / driving icon.
        'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>',
        'title' => __( 'Seguridad vial y cumplimiento en tránsito', 'cst-cannabis' ),
        'desc'  => __( 'Aborda el impacto del cannabis medicinal en la conducción, las responsabilidades legales vigentes en Puerto Rico y las alternativas seguras para evitar conducir bajo los efectos.', 'cst-cannabis' ),
    ],
    [
        // Shield with plus / family protection icon.
        'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm4 11h-3v3h-2v-3H8v-2h3V7h2v3h3v2z"/></svg>',
        'title' => __( 'Protección familiar y corresponsabilidad ciudadana', 'cst-cannabis' ),
        'desc'  => __( 'Promueve entornos seguros en el hogar, la protección de menores y la corresponsabilidad entre ciudadanos, instituciones y comunidades para prevenir incidentes y daños evitables.', 'cst-cannabis' ),
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
            <?php foreach ( $pillars as $i => $pillar ) : ?>
                <article class="cst-pillar-card">
                    <span class="cst-pillar-card__step" aria-hidden="true">
                        <?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?>
                    </span>
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <?php echo cst_kses_svg( $pillar['icon'] ); ?>
                    </div>
                    <h3 class="cst-pillar-card__title">
                        <?php echo esc_html( $pillar['title'] ); ?>
                    </h3>
                    <p class="cst-pillar-card__desc">
                        <?php echo esc_html( $pillar['desc'] ); ?>
                    </p>
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
