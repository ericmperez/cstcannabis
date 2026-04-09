<?php
/**
 * Custom search form with live search (WCAG 2.1 / Ley 229 compliant).
 *
 * Features:
 * - Toggle expand/collapse on mobile & desktop
 * - AJAX live results via WP REST API
 * - ARIA combobox pattern for screen readers
 * - Keyboard navigation (Arrow keys, Escape, Enter)
 * - Debounced input (300ms)
 * - prefers-reduced-motion respected
 *
 * @package CST_Cannabis
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$unique_id    = wp_unique_id( 'cst-search-' );
$listbox_id   = $unique_id . '-listbox';
$instructions = $unique_id . '-instructions';
?>
<div class="cst-search" data-search-component>
    <button type="button" class="cst-search__toggle"
            aria-label="<?php esc_attr_e( 'Abrir búsqueda', 'cst-cannabis' ); ?>"
            aria-expanded="false"
            aria-controls="<?php echo esc_attr( $unique_id ); ?>-form">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/>
            <path d="M21 21l-4.35-4.35"/>
        </svg>
    </button>

    <form role="search" method="get" class="cst-search__form"
          id="<?php echo esc_attr( $unique_id ); ?>-form"
          action="<?php echo esc_url( home_url( '/' ) ); ?>">

        <label for="<?php echo esc_attr( $unique_id ); ?>" class="sr-only">
            <?php esc_html_e( 'Buscar en el portal', 'cst-cannabis' ); ?>
        </label>

        <div class="cst-search__input-wrap" role="combobox"
             aria-expanded="false" aria-haspopup="listbox"
             aria-owns="<?php echo esc_attr( $listbox_id ); ?>">

            <input type="search"
                   id="<?php echo esc_attr( $unique_id ); ?>"
                   class="cst-search__input"
                   placeholder="<?php esc_attr_e( 'Buscar...', 'cst-cannabis' ); ?>"
                   value="<?php echo get_search_query(); ?>"
                   name="s"
                   autocomplete="off"
                   aria-autocomplete="list"
                   aria-controls="<?php echo esc_attr( $listbox_id ); ?>"
                   aria-describedby="<?php echo esc_attr( $instructions ); ?>" />

            <button type="submit" class="cst-search__submit"
                    aria-label="<?php esc_attr_e( 'Buscar', 'cst-cannabis' ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
            </button>
        </div>

        <span id="<?php echo esc_attr( $instructions ); ?>" class="sr-only">
            <?php esc_html_e( 'Escribe para buscar. Usa las flechas para navegar los resultados.', 'cst-cannabis' ); ?>
        </span>

        <ul id="<?php echo esc_attr( $listbox_id ); ?>"
            class="cst-search__results" role="listbox"
            aria-label="<?php esc_attr_e( 'Resultados de búsqueda', 'cst-cannabis' ); ?>"
            hidden></ul>
    </form>
</div>
