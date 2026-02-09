<?php
/**
 * Template Part: Hero Section.
 *
 * Reusable hero with image overlay, title, subtitle, CTA.
 *
 * @param array $args {
 *   @type string $title      Hero heading.
 *   @type string $subtitle   Hero sub-heading.
 *   @type string $cta_text   Button label.
 *   @type string $cta_url    Button link.
 *   @type string $cta2_text  Secondary button label.
 *   @type string $cta2_url   Secondary button link.
 *   @type string $image_url  Background image URL.
 *   @type string $class      Extra CSS class.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title     = $args['title'] ?? get_bloginfo( 'name' );
$subtitle  = $args['subtitle'] ?? get_bloginfo( 'description' );
$cta_text  = $args['cta_text'] ?? '';
$cta_url   = $args['cta_url'] ?? '';
$cta2_text = $args['cta2_text'] ?? '';
$cta2_url  = $args['cta2_url'] ?? '';
$image_url = $args['image_url'] ?? '';
$class     = $args['class'] ?? '';

$style = $image_url ? ' style="background-image:url(' . esc_url( $image_url ) . ')"' : '';
?>
<section class="cst-hero <?php echo esc_attr( $class ); ?>"<?php echo $style; ?>
         role="region" aria-label="<?php esc_attr_e( 'Sección principal', 'cst-cannabis' ); ?>">
    <div class="cst-hero__overlay" aria-hidden="true"></div>

    <!-- Floating decorative shapes -->
    <svg class="cst-hero__float cst-hero__float--1" width="120" height="120" viewBox="0 0 120 120" aria-hidden="true"><circle cx="60" cy="60" r="60" fill="rgba(17,94,103,0.12)"/></svg>
    <svg class="cst-hero__float cst-hero__float--2" width="80" height="80" viewBox="0 0 80 80" aria-hidden="true"><circle cx="40" cy="40" r="40" fill="rgba(229,106,84,0.10)"/></svg>
    <svg class="cst-hero__float cst-hero__float--3" width="60" height="60" viewBox="0 0 60 60" aria-hidden="true"><circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.08)"/></svg>

    <!-- Hero illustration (decorative) -->
    <img class="cst-hero__illustration"
         src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/hero-illustration.svg' ); ?>"
         alt="" aria-hidden="true" loading="lazy" />

    <!-- Wave bottom divider -->
    <div class="cst-hero__wave" aria-hidden="true"></div>

    <div class="cst-container">
        <div class="cst-hero__content">
            <h1 class="cst-hero__title"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="cst-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( $cta_text && $cta_url ) : ?>
                <div class="cst-hero__actions">
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="cst-btn cst-btn--hero">
                        <?php echo esc_html( $cta_text ); ?>
                    </a>
                    <?php if ( $cta2_text && $cta2_url ) : ?>
                        <a href="<?php echo esc_url( $cta2_url ); ?>" class="cst-btn cst-btn--outline-hero">
                            <?php echo esc_html( $cta2_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
