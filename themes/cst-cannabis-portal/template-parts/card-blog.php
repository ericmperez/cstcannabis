<?php
/**
 * Template Part: Blog post card component.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<article class="cst-card cst-card--blog" aria-label="<?php the_title_attribute(); ?>">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="cst-card__image">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                <?php the_post_thumbnail( 'cst-card', [ 'loading' => 'lazy' ] ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="cst-card__body">
        <div class="cst-card__meta">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
            </time>
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) :
            ?>
                <span class="cst-card__category">
                    <?php echo esc_html( $categories[0]->name ); ?>
                </span>
            <?php endif; ?>
        </div>

        <h3 class="cst-card__title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php if ( has_excerpt() || get_the_content() ) : ?>
            <p class="cst-card__excerpt">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?>
            </p>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="cst-card__link">
            <?php esc_html_e( 'Leer más', 'cst-cannabis' ); ?>
            <span class="sr-only">: <?php the_title(); ?></span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                <path d="M8.354 1.646a.5.5 0 010 .708L3.207 7.5H14.5a.5.5 0 010 1H3.207l5.147 5.146a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z" transform="scale(-1,1) translate(-16,0)"/>
            </svg>
        </a>
    </div>
</article>
