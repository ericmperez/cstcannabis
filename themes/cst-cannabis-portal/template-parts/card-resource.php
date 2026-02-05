<?php
/**
 * Template Part: Resource card with download button.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$types = get_the_terms( get_the_ID(), 'cst_resource_type' );
$type_slugs = [];
$type_names = [];
if ( $types && ! is_wp_error( $types ) ) {
    foreach ( $types as $type ) {
        $type_slugs[] = $type->slug;
        $type_names[] = $type->name;
    }
}
$filter_attr = implode( ' ', $type_slugs );
?>
<article class="cst-card cst-card--resource" data-type="<?php echo esc_attr( $filter_attr ); ?>"
         aria-label="<?php the_title_attribute(); ?>">

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="cst-card__image">
            <?php the_post_thumbnail( 'cst-card', [ 'loading' => 'lazy' ] ); ?>
        </div>
    <?php endif; ?>

    <div class="cst-card__body">
        <?php if ( ! empty( $type_names ) ) : ?>
            <div class="cst-card__tags">
                <?php foreach ( $type_names as $name ) : ?>
                    <span class="cst-tag"><?php echo esc_html( $name ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h3 class="cst-card__title"><?php the_title(); ?></h3>

        <?php if ( has_excerpt() ) : ?>
            <p class="cst-card__excerpt">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?>
            </p>
        <?php endif; ?>

        <div class="cst-card__actions">
            <a href="<?php the_permalink(); ?>" class="cst-btn cst-btn--sm cst-btn--primary">
                <?php esc_html_e( 'Ver recurso', 'cst-cannabis' ); ?>
            </a>
        </div>
    </div>
</article>
