<?php
/**
 * Template Part: Blog post card component.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Primary category → green-wash pill (Pencil "Cat Pill"). Prefer a real
// category over WordPress's default Uncategorized.
$cst_cats     = get_the_category();
$cst_category = null;
foreach ( $cst_cats as $cst_maybe ) {
    if ( ! in_array( $cst_maybe->slug, [ 'uncategorized', 'uncategorized-en' ], true ) ) {
        $cst_category = $cst_maybe;
        break;
    }
}
if ( ! $cst_category && ! empty( $cst_cats ) ) {
    $cst_category = $cst_cats[0];
}

// Reading time (Pencil meta "· X min"): ~200 words/min, min 1.
$cst_words    = str_word_count( wp_strip_all_tags( get_the_content() ) );
$cst_read_min = max( 1, (int) round( $cst_words / 200 ) );

// Featured image, or a branded placeholder so the card grid stays even.
$cst_has_thumb = has_post_thumbnail();
$cst_thumb_url = $cst_has_thumb
    ? get_the_post_thumbnail_url( get_the_ID(), 'cst-card' )
    : get_stylesheet_directory_uri() . '/assets/images/hero-home.jpg';
?>
<article class="cst-card cst-card--blog<?php echo $cst_has_thumb ? '' : ' cst-card--blog-placeholder'; ?>" aria-label="<?php the_title_attribute(); ?>">
    <div class="cst-card__image">
        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
            <?php if ( $cst_has_thumb ) : ?>
                <?php the_post_thumbnail( 'cst-card', [ 'loading' => 'lazy' ] ); ?>
            <?php else : ?>
                <img src="<?php echo esc_url( $cst_thumb_url ); ?>"
                     alt=""
                     width="600"
                     height="400"
                     loading="lazy"
                     class="cst-card__image-placeholder" />
            <?php endif; ?>
        </a>
    </div>

    <div class="cst-card__body">
        <?php if ( $cst_category && ! in_array( $cst_category->slug, [ 'uncategorized', 'uncategorized-en' ], true ) ) : ?>
            <span class="cst-card__category"><?php echo esc_html( $cst_category->name ); ?></span>
        <?php else : ?>
            <span class="cst-card__category"><?php esc_html_e( 'Blog', 'cst-cannabis' ); ?></span>
        <?php endif; ?>

        <h3 class="cst-card__title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="cst-card__meta">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php
                printf(
                    /* translators: date parts — 1: day, 2: month name, 3: year. Reorder for the target language (e.g. "%2$s %1$s, %3$s" for English). */
                    esc_html__( '%1$s de %2$s de %3$s', 'cst-cannabis' ),
                    esc_html( get_the_date( 'j' ) ),
                    esc_html( get_the_date( 'F' ) ),
                    esc_html( get_the_date( 'Y' ) )
                );
                ?>
            </time>
            <span class="cst-card__meta-sep" aria-hidden="true">·</span>
            <span class="cst-card__read-time">
                <?php
                /* translators: %s = number of minutes to read the article. */
                printf( esc_html__( '%s min', 'cst-cannabis' ), esc_html( (string) $cst_read_min ) );
                ?>
            </span>
        </div>
    </div>
</article>
