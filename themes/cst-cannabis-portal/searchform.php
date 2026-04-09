<?php
/**
 * Custom search form (WCAG 2.1 / Ley 229 compliant).
 *
 * @package CST_Cannabis
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$unique_id = wp_unique_id( 'cst-search-' );
?>
<form role="search" method="get" class="cst-search-form"
      action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo esc_attr( $unique_id ); ?>" class="cst-search-form__label sr-only">
        <?php esc_html_e( 'Buscar en el portal', 'cst-cannabis' ); ?>
    </label>
    <input type="search"
           id="<?php echo esc_attr( $unique_id ); ?>"
           class="cst-search-form__input"
           placeholder="<?php esc_attr_e( 'Buscar...', 'cst-cannabis' ); ?>"
           value="<?php echo get_search_query(); ?>"
           name="s"
           autocomplete="off" />
    <button type="submit" class="cst-search-form__submit"
            aria-label="<?php esc_attr_e( 'Buscar', 'cst-cannabis' ); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/>
            <path d="M21 21l-4.35-4.35"/>
        </svg>
    </button>
</form>
