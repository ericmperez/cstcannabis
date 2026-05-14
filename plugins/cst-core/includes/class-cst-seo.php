<?php
/**
 * CST_Seo — Open Graph, Twitter Card, hreflang, JSON-LD, preconnect.
 *
 * Emits the head metadata expected of a Puerto Rico government portal:
 *  - Open Graph + Twitter Card for /pr.gov-style link previews.
 *  - rel="alternate" hreflang for the EN/ES Polylang pair.
 *  - JSON-LD GovernmentOrganization for the CST, plus Course schema
 *    on the Tutor LMS course landing page.
 *  - Per-page <meta name="description"> derived from the page excerpt
 *    or post content.
 *  - dns-prefetch + preconnect for the font and CDN origins so the
 *    first paint isn't gated on TLS handshakes.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Seo {

    public function __construct() {
        add_action( 'wp_head', [ $this, 'render_preconnect' ], 1 );
        add_action( 'wp_head', [ $this, 'render_meta_description' ], 5 );
        add_action( 'wp_head', [ $this, 'render_open_graph' ], 6 );
        add_action( 'wp_head', [ $this, 'render_hreflang' ], 7 );
        add_action( 'wp_head', [ $this, 'render_json_ld' ], 20 );
        add_filter( 'robots_txt', [ $this, 'extend_robots_txt' ], 10, 2 );
    }

    /**
     * Append a Sitemap: directive (WP core has served /wp-sitemap.xml
     * since 5.5) and explicitly disallow non-public WP paths beyond
     * core's defaults.
     */
    public function extend_robots_txt( string $output, $public ): string {
        if ( ! $public ) {
            return $output;
        }
        $extra = [
            '',
            'Disallow: /wp-content/plugins/',
            'Disallow: /wp-content/uploads/wpcf7_uploads/',
            'Disallow: /?s=',
            '',
            'Sitemap: ' . home_url( '/wp-sitemap.xml' ),
            '',
        ];
        return $output . implode( "\n", $extra );
    }

    /**
     * dns-prefetch + preconnect for external origins we always hit.
     */
    public function render_preconnect(): void {
        $origins = [
            'https://fonts.googleapis.com',
            'https://fonts.gstatic.com',
            'https://cdn.jsdelivr.net',
        ];
        foreach ( $origins as $origin ) {
            printf( '<link rel="preconnect" href="%s" crossorigin>' . "\n", esc_url( $origin ) );
            printf( '<link rel="dns-prefetch" href="%s">' . "\n", esc_url( $origin ) );
        }
    }

    /**
     * Per-page <meta name="description">.
     *
     * Singular: excerpt, falling back to the first 160 chars of content.
     * Archive/home: site tagline.
     */
    public function render_meta_description(): void {
        $description = '';

        if ( is_singular() ) {
            $post = get_queried_object();
            if ( $post instanceof WP_Post ) {
                $description = $post->post_excerpt
                    ? $post->post_excerpt
                    : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
            }
        } elseif ( is_home() || is_front_page() ) {
            $description = get_bloginfo( 'description' );
        }

        $description = trim( preg_replace( '/\s+/', ' ', (string) $description ) );
        if ( '' === $description ) {
            return;
        }
        if ( mb_strlen( $description ) > 160 ) {
            $description = mb_substr( $description, 0, 157 ) . '…';
        }
        printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
    }

    /**
     * Open Graph + Twitter Card tags.
     */
    public function render_open_graph(): void {
        $title       = wp_get_document_title();
        $url         = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
        $site_name   = get_bloginfo( 'name' );
        $locale      = self::current_locale( true );
        $image       = self::primary_image_url();
        $alt_locales = self::alternate_locales();

        printf( '<meta property="og:type" content="%s">' . "\n", is_singular() ? 'article' : 'website' );
        printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
        printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
        printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( $site_name ) );
        printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( $locale ) );
        foreach ( $alt_locales as $alt ) {
            printf( '<meta property="og:locale:alternate" content="%s">' . "\n", esc_attr( $alt ) );
        }
        if ( $image ) {
            printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
            echo '<meta property="og:image:alt" content="' . esc_attr( $site_name ) . '">' . "\n";
        }

        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
        if ( $image ) {
            printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
        }
    }

    /**
     * rel="alternate" hreflang for the Polylang EN/ES pair, plus
     * x-default pointing at the Spanish version.
     */
    public function render_hreflang(): void {
        if ( ! function_exists( 'pll_the_languages' ) || ! function_exists( 'pll_get_post' ) ) {
            return;
        }

        $translations = function_exists( 'pll_get_post_translations' ) && is_singular()
            ? pll_get_post_translations( get_the_ID() )
            : [];

        if ( empty( $translations ) ) {
            // Fall back to language home URLs from Polylang.
            $languages = pll_the_languages( [ 'raw' => 1, 'hide_if_empty' => 0 ] );
            if ( ! is_array( $languages ) || empty( $languages ) ) {
                return;
            }
            foreach ( $languages as $slug => $lang ) {
                $href = ! empty( $lang['url'] ) ? $lang['url'] : home_url( '/' );
                printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( $slug ), esc_url( $href ) );
            }
            printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( home_url( '/' ) ) );
            return;
        }

        foreach ( $translations as $slug => $post_id ) {
            $url = get_permalink( $post_id );
            if ( $url ) {
                printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( $slug ), esc_url( $url ) );
            }
        }
        $default = $translations['es'] ?? reset( $translations );
        if ( $default && get_permalink( $default ) ) {
            printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( get_permalink( $default ) ) );
        }
    }

    /**
     * JSON-LD: GovernmentOrganization always; Course on the course landing.
     */
    public function render_json_ld(): void {
        $graph = [];

        $graph[] = [
            '@context'  => 'https://schema.org',
            '@type'     => 'GovernmentOrganization',
            'name'      => get_bloginfo( 'name' ),
            'url'       => home_url( '/' ),
            'logo'      => self::primary_image_url(),
            'sameAs'    => array_values( array_filter( [
                get_theme_mod( 'cst_facebook' ),
                get_theme_mod( 'cst_twitter' ),
                get_theme_mod( 'cst_instagram' ),
                get_theme_mod( 'cst_youtube' ),
            ] ) ),
            'parentOrganization' => [
                '@type' => 'GovernmentOrganization',
                'name'  => 'Gobierno de Puerto Rico',
                'url'   => 'https://www.pr.gov/',
            ],
        ];

        if ( is_singular( 'courses' ) || ( is_page() && 'curso-cannabis' === get_post_field( 'post_name', get_the_ID() ) ) ) {
            $graph[] = [
                '@context'    => 'https://schema.org',
                '@type'       => 'Course',
                'name'        => get_the_title(),
                'description' => wp_strip_all_tags( strip_shortcodes( get_the_excerpt() ?: get_the_content() ) ),
                'provider'    => [
                    '@type' => 'GovernmentOrganization',
                    'name'  => get_bloginfo( 'name' ),
                    'url'   => home_url( '/' ),
                ],
                'inLanguage'  => self::current_locale( false ),
                'isAccessibleForFree' => true,
            ];
        }

        echo '<script type="application/ld+json">' . wp_json_encode( count( $graph ) === 1 ? $graph[0] : $graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
    }

    /**
     * Return current locale as `es_PR` (raw) or `es_PR` style for OG.
     */
    private static function current_locale( bool $for_og ): string {
        $locale = get_locale();
        if ( function_exists( 'pll_current_language' ) ) {
            $pll = pll_current_language( 'locale' );
            if ( $pll ) {
                $locale = $pll;
            }
        }
        return $for_og ? str_replace( '-', '_', $locale ) : str_replace( '_', '-', $locale );
    }

    /**
     * Return alternate locales (OG format).
     */
    private static function alternate_locales(): array {
        if ( ! function_exists( 'pll_languages_list' ) ) {
            return [];
        }
        $current = self::current_locale( true );
        $all     = (array) pll_languages_list( [ 'fields' => 'locale' ] );
        $alts    = [];
        foreach ( $all as $loc ) {
            $loc = str_replace( '-', '_', (string) $loc );
            if ( $loc && $loc !== $current ) {
                $alts[] = $loc;
            }
        }
        return $alts;
    }

    /**
     * Featured image, falling back to the site icon / logo.
     */
    private static function primary_image_url(): string {
        if ( is_singular() && has_post_thumbnail() ) {
            $url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
            if ( $url ) {
                return $url;
            }
        }
        $icon = get_site_icon_url( 512 );
        if ( $icon ) {
            return $icon;
        }
        $custom_logo = get_theme_mod( 'custom_logo' );
        if ( $custom_logo ) {
            $src = wp_get_attachment_image_src( $custom_logo, 'full' );
            if ( $src && ! empty( $src[0] ) ) {
                return $src[0];
            }
        }
        return '';
    }
}
