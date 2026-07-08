<?php
/**
 * single-cst_resource.php — Single educational resource layout.
 *
 * Mirrors the article layout (navy hero + prose + share) but labels the
 * item as a resource type (Guía / Video / Infografía / Documento), never
 * as "Blog", and never prints an empty "Por …" byline.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

<?php
while ( have_posts() ) :
    the_post();

    $cst_words = str_word_count( wp_strip_all_tags( get_the_content() ) );
    $cst_min   = max( 1, (int) round( $cst_words / 200 ) );

    $cst_types = get_the_terms( get_the_ID(), 'cst_resource_type' );
    $cst_type  = ( $cst_types && ! is_wp_error( $cst_types ) ) ? $cst_types[0] : null;
    $cst_label = $cst_type ? $cst_type->name : __( 'Recurso', 'cst-cannabis' );

    // Date + reading time only (resources often have no author).
    $cst_meta = sprintf(
        /* translators: 1: publish date, 2: reading-time minutes. */
        esc_html__( '%1$s · %2$s min de lectura', 'cst-cannabis' ),
        esc_html( get_the_date() ),
        esc_html( (string) $cst_min )
    );

    cst_hero( [
        'eyebrow'  => $cst_label,
        'title'    => get_the_title(),
        'subtitle' => $cst_meta,
        'class'    => 'cst-hero--page cst-hero--article cst-hero--resource',
    ] );

    $cst_permalink = get_permalink();
    $cst_share     = rawurlencode( $cst_permalink );
    $cst_share_ttl = rawurlencode( get_the_title() );
    $cst_resources_url = get_post_type_archive_link( 'cst_resource' );
    if ( ! $cst_resources_url ) {
        $cst_resources_url = home_url( '/recursos/' );
    }
    ?>

    <article <?php post_class( 'cst-section cst-section--article cst-section--resource' ); ?>>
        <div class="cst-container">
            <div class="cst-article">

                <p class="cst-article__back">
                    <a href="<?php echo esc_url( $cst_resources_url ); ?>">
                        <span aria-hidden="true">&larr;</span>
                        <?php esc_html_e( 'Todos los recursos', 'cst-cannabis' ); ?>
                    </a>
                </p>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="cst-article__image">
                        <?php the_post_thumbnail( 'cst-hero', [ 'loading' => 'eager' ] ); ?>
                    </figure>
                <?php endif; ?>

                <div class="cst-article__body cst-content-area">
                    <?php the_content(); ?>
                </div>

                <div class="cst-article__share">
                    <hr class="cst-article__share-divider">
                    <div class="cst-article__share-row">
                        <span class="cst-article__share-label"><?php esc_html_e( 'Compartir:', 'cst-cannabis' ); ?></span>
                        <a class="cst-article__share-btn" target="_blank" rel="noopener noreferrer"
                           href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $cst_share ); ?>"
                           aria-label="<?php esc_attr_e( 'Compartir en Facebook', 'cst-cannabis' ); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a class="cst-article__share-btn" target="_blank" rel="noopener noreferrer"
                           href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( $cst_share ); ?>&text=<?php echo esc_attr( $cst_share_ttl ); ?>"
                           aria-label="<?php esc_attr_e( 'Compartir en X', 'cst-cannabis' ); ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a class="cst-article__share-btn" target="_blank" rel="noopener noreferrer"
                           href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $cst_share ); ?>"
                           aria-label="<?php esc_attr_e( 'Compartir en LinkedIn', 'cst-cannabis' ); ?>">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a class="cst-article__share-btn" href="<?php echo esc_url( $cst_permalink ); ?>"
                           data-cst-copy-link aria-label="<?php esc_attr_e( 'Copiar enlace', 'cst-cannabis' ); ?>">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </article>

    <?php
    // Related resources — same type when possible.
    $cst_related_args = [
        'post_type'           => 'cst_resource',
        'posts_per_page'      => 3,
        'post__not_in'        => [ get_the_ID() ],
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ];
    if ( $cst_type ) {
        $cst_related_args['tax_query'] = [
            [
                'taxonomy' => 'cst_resource_type',
                'field'    => 'term_id',
                'terms'    => $cst_type->term_id,
            ],
        ];
    }
    $cst_related = new WP_Query( $cst_related_args );

    if ( ! $cst_related->have_posts() ) {
        unset( $cst_related_args['tax_query'] );
        $cst_related = new WP_Query( $cst_related_args );
    }

    if ( $cst_related->have_posts() ) :
        ?>
        <section class="cst-section cst-section--related" aria-labelledby="cst-related-resources-title">
            <div class="cst-container">
                <div class="cst-related__head">
                    <span class="cst-eyebrow">
                        <span class="cst-eyebrow__dot" aria-hidden="true"></span>
                        <?php esc_html_e( 'Más recursos', 'cst-cannabis' ); ?>
                    </span>
                    <h2 id="cst-related-resources-title" class="cst-related__title">
                        <?php esc_html_e( 'También te puede interesar', 'cst-cannabis' ); ?>
                    </h2>
                </div>
                <div class="cst-card-grid cst-card-grid--3">
                    <?php
                    while ( $cst_related->have_posts() ) :
                        $cst_related->the_post();
                        get_template_part( 'template-parts/card', 'resource' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php
    endif;

endwhile;
?>

</main>

<?php
get_footer();
