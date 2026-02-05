<?php
/**
 * Template Part: Hero Section.
 *
 * Reusable hero with image overlay, title, subtitle, CTA buttons.
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
    <div class="cst-container">
        <div class="cst-hero__content">
            <h1 class="cst-hero__title"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="cst-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( ( $cta_text && $cta_url ) || ( $cta2_text && $cta2_url ) ) : ?>
                <div class="cst-hero__actions">
                    <?php if ( $cta_text && $cta_url ) : ?>
                        <a href="<?php echo esc_url( $cta_url ); ?>" class="cst-btn cst-btn--hero">
                            <?php echo esc_html( $cta_text ); ?>
                            <span class="cst-btn__icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </a>
                    <?php endif; ?>
                    <?php if ( $cta2_text && $cta2_url ) : ?>
                        <a href="<?php echo esc_url( $cta2_url ); ?>" class="cst-btn cst-btn--hero-outline">
                            <?php echo esc_html( $cta2_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
