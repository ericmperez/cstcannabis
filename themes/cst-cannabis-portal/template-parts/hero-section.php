<?php
/**
 * Template Part: Hero Section.
 *
 * Reusable hero with image overlay, title, subtitle, CTA.
 *
 * @param array $args {
 *   @type string $title     Hero heading.
 *   @type string $subtitle  Hero sub-heading.
 *   @type string $cta_text  Button label.
 *   @type string $cta_url   Button link.
 *   @type string $image_url Background image URL.
 *   @type string $class     Extra CSS class.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title     = $args['title'] ?? get_bloginfo( 'name' );
$subtitle  = $args['subtitle'] ?? get_bloginfo( 'description' );
$cta_text  = $args['cta_text'] ?? '';
$cta_url   = $args['cta_url'] ?? '';
$image_url = $args['image_url'] ?? '';
$class     = $args['class'] ?? '';

$style = $image_url ? ' style="background-image:url(' . esc_url( $image_url ) . ')"' : '';
?>
<section class="cst-hero <?php echo esc_attr( $class ); ?>"<?php echo $style; ?>
         role="region" aria-label="<?php esc_attr_e( 'Sección principal', 'cst-cannabis' ); ?>">
    <div class="cst-hero__overlay" aria-hidden="true"></div>
    <div class="cst-container">
        <div class="cst-hero__content">
            <h1 class="cst-hero__title"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="cst-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( $cta_text && $cta_url ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="cst-btn cst-btn--hero">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
