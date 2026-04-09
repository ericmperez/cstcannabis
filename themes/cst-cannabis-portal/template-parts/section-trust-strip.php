<?php
/**
 * Template Part: Trust Strip.
 *
 * Compact social-proof strip between hero and course modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$items = [
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>',
        'label' => __( 'Certificado Digital', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>',
        'label' => __( '100% En Línea', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>',
        'label' => __( 'A Tu Ritmo', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>',
        'label' => __( 'Aprobado CST', 'cst-cannabis' ),
    ],
];
?>
<section class="cst-trust-strip" role="region" aria-label="<?php esc_attr_e( 'Beneficios del curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <ul class="cst-trust-strip__list">
            <?php foreach ( $items as $item ) : ?>
                <li class="cst-trust-strip__item">
                    <span class="cst-trust-strip__icon"><?php echo wp_kses_post( $item['icon'] ); ?></span>
                    <span class="cst-trust-strip__label"><?php echo esc_html( $item['label'] ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
