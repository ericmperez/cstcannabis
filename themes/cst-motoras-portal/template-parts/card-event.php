<?php
/**
 * Template Part: Event card (The Events Calendar integration).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// TEC functions.
$start_date = function_exists( 'tribe_get_start_date' ) ? tribe_get_start_date( null, false, 'j M Y' ) : '';
$start_time = function_exists( 'tribe_get_start_date' ) ? tribe_get_start_date( null, false, 'g:i A' ) : '';
$venue      = function_exists( 'tribe_get_venue' ) ? tribe_get_venue() : '';
?>
<article class="cst-card cst-card--event" aria-label="<?php the_title_attribute(); ?>">
    <div class="cst-card__date-badge" aria-hidden="true">
        <?php if ( $start_date ) : ?>
            <span class="cst-card__date-day">
                <?php echo esc_html( function_exists( 'tribe_get_start_date' ) ? tribe_get_start_date( null, false, 'j' ) : '' ); ?>
            </span>
            <span class="cst-card__date-month">
                <?php echo esc_html( function_exists( 'tribe_get_start_date' ) ? tribe_get_start_date( null, false, 'M' ) : '' ); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="cst-card__body">
        <h3 class="cst-card__title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="cst-card__meta">
            <?php if ( $start_date ) : ?>
                <span class="cst-card__event-date">
                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                        <?php echo esc_html( $start_date ); ?>
                        <?php if ( $start_time ) : ?>
                            — <?php echo esc_html( $start_time ); ?>
                        <?php endif; ?>
                    </time>
                </span>
            <?php endif; ?>
            <?php if ( $venue ) : ?>
                <span class="cst-card__event-venue"><?php echo esc_html( $venue ); ?></span>
            <?php endif; ?>
        </div>

        <?php if ( has_excerpt() ) : ?>
            <p class="cst-card__excerpt">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '…' ) ); ?>
            </p>
        <?php endif; ?>
    </div>
</article>
