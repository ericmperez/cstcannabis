<?php
/**
 * Template helper functions — hero, section headings, cards, CTA buttons.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render a hero section.
 *
 * @param array $args {
 *   @type string $title      Hero title.
 *   @type string $subtitle   Hero subtitle.
 *   @type string $cta_text   CTA button text.
 *   @type string $cta_url    CTA button URL.
 *   @type string $image_url  Background image URL (falls back to customizer).
 *   @type string $class      Extra CSS classes.
 * }
 */
function cst_hero( array $args = [] ): void {
    $defaults = [
        'title'     => get_bloginfo( 'name' ),
        'subtitle'  => get_bloginfo( 'description' ),
        'cta_text'  => '',
        'cta_url'   => '',
        'cta2_text' => '',
        'cta2_url'  => '',
        'image_url' => get_theme_mod( 'cst_hero_image', '' ),
        'class'     => '',
    ];
    $args = wp_parse_args( $args, $defaults );

    get_template_part( 'template-parts/hero', 'section', $args );
}

/**
 * Render a section heading with optional subtitle.
 */
function cst_section_heading( string $title, string $subtitle = '', string $tag = 'h2' ): void {
    $allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
    $tag = in_array( $tag, $allowed_tags, true ) ? $tag : 'h2';
    ?>
    <div class="cst-section-heading">
        <<?php echo $tag; ?> class="cst-section-heading__title"><?php echo esc_html( $title ); ?></<?php echo $tag; ?>>
        <?php if ( $subtitle ) : ?>
            <p class="cst-section-heading__subtitle"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Render a card wrapper.
 *
 * @param string $type Card type: 'blog', 'resource', 'event', 'stat'.
 * @param array  $args Data passed to template part.
 */
function cst_card( string $type, array $args = [] ): void {
    get_template_part( 'template-parts/card', $type, $args );
}

/**
 * Render a CTA button.
 */
function cst_cta_button( string $text, string $url, string $style = 'primary', array $attrs = [] ): void {
    $classes = 'cst-btn cst-btn--' . sanitize_html_class( $style );
    $extra   = '';

    foreach ( $attrs as $key => $value ) {
        $extra .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
    }
    ?>
    <a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $classes ); ?>"<?php echo $extra; ?>>
        <?php echo esc_html( $text ); ?>
    </a>
    <?php
}

/**
 * Get the portal type (cannabis or four-tracks) based on active theme.
 */
function cst_get_portal_type(): string {
    $theme = get_stylesheet();
    if ( str_contains( $theme, 'four-tracks' ) ) {
        return 'four-tracks';
    }
    return 'cannabis';
}

/**
 * Render a grid section wrapper.
 */
function cst_section_open( string $class = '', string $id = '' ): void {
    $id_attr = $id ? ' id="' . esc_attr( $id ) . '"' : '';
    echo '<section class="cst-section ' . esc_attr( $class ) . '"' . $id_attr . '>';
    echo '<div class="cst-container">';
}

function cst_section_close(): void {
    echo '</div></section>';
}
