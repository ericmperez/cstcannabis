<?php
/**
 * Template Part: Latest blog posts (home page).
 *
 * Shows 3 most recent blog posts as cards.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$latest = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
] );

if ( ! $latest->have_posts() ) {
    return;
}
?>

<?php
$cst_posts_page_id = (int) get_option( 'page_for_posts' );
$cst_posts_url     = $cst_posts_page_id ? get_permalink( $cst_posts_page_id ) : home_url( '/blog/' );
?>
<section class="cst-section cst-section--latest-posts"
         aria-label="<?php esc_attr_e( 'Últimas publicaciones', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <div class="cst-latest-posts__head">
            <div class="cst-latest-posts__head-text">
                <span class="cst-eyebrow">
                    <span class="cst-eyebrow__dot" aria-hidden="true"></span>
                    <?php esc_html_e( 'Blog', 'cst-cannabis' ); ?>
                </span>
                <h2 class="cst-latest-posts__title"><?php esc_html_e( 'Últimas publicaciones', 'cst-cannabis' ); ?></h2>
            </div>
            <a class="cst-latest-posts__see-all" href="<?php echo esc_url( $cst_posts_url ); ?>">
                <?php esc_html_e( 'Ver todas', 'cst-cannabis' ); ?>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="cst-card-grid cst-card-grid--3">
            <?php
            while ( $latest->have_posts() ) :
                $latest->the_post();
                get_template_part( 'template-parts/card', 'blog' );
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
