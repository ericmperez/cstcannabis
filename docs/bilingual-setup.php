<?php
/**
 * bilingual-setup.php — Idempotent Polylang + EN-content bootstrap for the
 * CST Cannabis portal. Reproduces the local bilingual setup on any
 * environment (e.g. production) so the site is fully bilingual after a deploy.
 *
 * WHAT IT DOES (safe to run more than once):
 *   1. Registers ES (default) + EN languages in Polylang.
 *   2. Assigns ES to every existing post/page with no language yet.
 *   3. Creates template-driven EN duplicates of the main + legal pages,
 *      linked to their ES originals (bodies stay empty — the templates render
 *      the translated __() strings via the .mo).
 *   4. Builds an EN primary nav menu and wires it per-language.
 *   5. Duplicates the CF7 contact form in English and wires the shortcode
 *      onto the ES + EN contact pages.
 *   6. Flushes rewrite rules.
 *
 * RUN:  wp eval-file docs/bilingual-setup.php
 * ALSO run once (needs internet), for Spanish month names in dates:
 *       wp language core install es_ES
 *
 * NOTE: pages are matched by SLUG so prod IDs don't matter. Adjust the
 * $pages / $legal maps if slugs differ in production.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Run via: wp eval-file docs/bilingual-setup.php\n" );
	return;
}
if ( ! class_exists( 'PLL_Admin_Model' ) || ! function_exists( 'pll_set_post_language' ) ) {
	fwrite( STDERR, "Polylang not active/loaded. Activate Polylang first.\n" );
	return;
}

$out = function ( $m ) { fwrite( STDOUT, $m . "\n" ); };

/* ---- 1. Languages -------------------------------------------------------- */
$existing = get_terms( [ 'taxonomy' => 'language', 'hide_empty' => false, 'fields' => 'slugs' ] );
$existing = is_wp_error( $existing ) ? [] : (array) $existing;
$model    = new PLL_Admin_Model( get_option( 'polylang' ) );
$langs    = [
	[ 'name' => 'Español', 'slug' => 'es', 'locale' => 'es_ES', 'rtl' => 0, 'term_group' => 0, 'flag' => 'es' ],
	[ 'name' => 'English', 'slug' => 'en', 'locale' => 'en_US', 'rtl' => 0, 'term_group' => 1, 'flag' => 'us' ],
];
foreach ( $langs as $l ) {
	if ( in_array( $l['slug'], $existing, true ) ) { $out( "lang {$l['slug']}: exists" ); continue; }
	$r = $model->add_language( $l );
	$out( "lang {$l['slug']}: " . ( is_wp_error( $r ) ? 'ERR ' . $r->get_error_message() : 'added' ) );
}

/* ---- 2. Assign ES to existing content ------------------------------------ */
$o      = get_option( 'polylang' );
$ptypes = array_unique( array_merge( [ 'post', 'page' ], (array) ( $o['post_types'] ?? [] ) ) );
$posts  = get_posts( [ 'post_type' => $ptypes, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids', 'suppress_filters' => true ] );
$n = 0;
foreach ( $posts as $pid ) {
	if ( ! pll_get_post_language( $pid ) ) { pll_set_post_language( $pid, 'es' ); $n++; }
}
$out( "assigned es to $n posts" );

/* ---- 3. EN page duplicates (by slug) ------------------------------------- */
// es-slug => [en-title, en-slug]
$pages = [
	'inicio'                => [ 'Home', 'home' ],
	'curso'                 => [ 'Course', 'course' ],
	'recursos'              => [ 'Resources', 'resources' ],
	'estadisticas'          => [ 'Statistics', 'statistics' ],
	'contacto'              => [ 'Contact', 'contact' ],
	'sobre-nosotros'        => [ 'About Us', 'about-us' ],
	'blog'                  => [ 'Blog', 'blog-en' ],
	'politica-privacidad'   => [ 'Privacy Policy', 'privacy' ],
	'terminos-uso'          => [ 'Terms of Use', 'terms' ],
	'accesibilidad'         => [ 'Accessibility', 'accessibility' ],
	'certificado'           => [ 'Certificate', 'certificate' ],
];
$en_ids = [];
foreach ( $pages as $es_slug => $info ) {
	$es = get_page_by_path( $es_slug );
	if ( ! $es ) { $out( "page $es_slug: not found, skip" ); continue; }
	$en = pll_get_post( $es->ID, 'en' );
	if ( $en ) { $en_ids[ $es_slug ] = $en; $out( "page $es_slug: EN exists (#$en)" ); continue; }
	$tmpl = get_post_meta( $es->ID, '_wp_page_template', true );
	$nid  = wp_insert_post( [ 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $info[0], 'post_name' => $info[1], 'post_content' => '' ], true );
	if ( is_wp_error( $nid ) ) { $out( "page $es_slug: ERR " . $nid->get_error_message() ); continue; }
	if ( $tmpl ) { update_post_meta( $nid, '_wp_page_template', $tmpl ); }
	pll_set_post_language( $nid, 'en' );
	pll_save_post_translations( [ 'es' => $es->ID, 'en' => $nid ] );
	$en_ids[ $es_slug ] = $nid;
	$out( "page $es_slug: EN #$nid created" );
}

/* ---- 4. EN primary nav menu + per-language wiring ------------------------ */
$menu_name = 'Primary Menu EN';
$menu      = wp_get_nav_menu_object( $menu_name );
$menu_id   = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
if ( ! is_wp_error( $menu_id ) ) {
	foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $it ) { wp_delete_post( $it->ID, true ); }
	$nav = [ 'home', 'course', 'resources', 'statistics', 'about-us', 'contact' ];
	$i   = 0;
	foreach ( $nav as $slug ) {
		$es_slug = array_search( $slug, array_map( fn( $x ) => $x[1], $pages ), true );
		$target  = $en_ids[ $es_slug ] ?? 0;
		if ( ! $target ) { continue; }
		wp_update_nav_menu_item( $menu_id, 0, [
			'menu-item-title'     => get_the_title( $target ),
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $target,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-position'  => ++$i,
		] );
	}
	if ( function_exists( 'pll_set_term_language' ) ) { pll_set_term_language( $menu_id, 'en' ); }
	$locs   = get_nav_menu_locations();
	$es_pm  = $locs['primary'] ?? 0;
	$opt    = get_option( 'polylang_nav_menus', [] );
	$theme  = get_stylesheet();
	$opt[ $theme ]['primary']['es'] = (int) $es_pm;
	$opt[ $theme ]['primary']['en'] = (int) $menu_id;
	update_option( 'polylang_nav_menus', $opt );
	$out( "EN menu #$menu_id wired ($i items)" );
}

/* ---- 5. English CF7 form + wire shortcodes ------------------------------- */
if ( post_type_exists( 'wpcf7_contact_form' ) ) {
	$es_form = get_posts( [ 'post_type' => 'wpcf7_contact_form', 'numberposts' => 1, 'orderby' => 'ID', 'order' => 'ASC' ] );
	$es_fid  = $es_form ? $es_form[0]->ID : 0;
	if ( $es_fid ) {
		// Spanish labels on the source form.
		update_post_meta( $es_fid, '_form',
			"<label>Nombre completo\n[text* your-name autocomplete:name]</label>\n\n<label>Correo electrónico\n[email* your-email autocomplete:email]</label>\n\n<label>Asunto\n[text* your-subject]</label>\n\n<label>Mensaje\n[textarea your-message]</label>\n\n[submit \"Enviar mensaje\"]" );
		// English form (create or reuse).
		$en_form = get_posts( [ 'post_type' => 'wpcf7_contact_form', 'name' => 'contact-form-en', 'numberposts' => 1 ] );
		$en_fid  = $en_form ? $en_form[0]->ID : wp_insert_post( [ 'post_type' => 'wpcf7_contact_form', 'post_status' => 'publish', 'post_title' => 'Contact form EN', 'post_name' => 'contact-form-en' ] );
		foreach ( get_post_meta( $es_fid ) as $k => $v ) { if ( '_form' !== $k ) { update_post_meta( $en_fid, $k, maybe_unserialize( $v[0] ) ); } }
		update_post_meta( $en_fid, '_form',
			"<label>Full name\n[text* your-name autocomplete:name]</label>\n\n<label>Email\n[email* your-email autocomplete:email]</label>\n\n<label>Subject\n[text* your-subject]</label>\n\n<label>Message\n[textarea your-message]</label>\n\n[submit \"Send message\"]" );
		if ( function_exists( 'pll_set_post_language' ) ) { pll_set_post_language( $en_fid, 'en' ); }
		// Wire shortcodes onto the contact pages.
		$c_es = get_page_by_path( 'contacto' );
		$c_en = ! empty( $en_ids['contacto'] ) ? get_post( $en_ids['contacto'] ) : null;
		if ( $c_es ) { wp_update_post( [ 'ID' => $c_es->ID, 'post_content' => "[contact-form-7 id=\"$es_fid\"]" ] ); }
		if ( $c_en ) { wp_update_post( [ 'ID' => $c_en->ID, 'post_content' => "[contact-form-7 id=\"$en_fid\"]" ] ); }
		$out( "CF7 forms: ES #$es_fid, EN #$en_fid wired" );
	}
}

/* ---- 6. Flush ------------------------------------------------------------ */
flush_rewrite_rules( true );
$out( 'done — rewrite flushed.' );
