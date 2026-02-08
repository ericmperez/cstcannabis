<?php
/**
 * CST_Statistics — [cst_statistics] shortcode + REST endpoints + dashboard data.
 *
 * GET /wp-json/cst/v1/statistics — returns all published statistics.
 * GET /wp-json/cst/v1/statistics/dashboard — returns grouped statistics + chart data.
 * Shortcode renders a card grid with animated counters and optional trend badges.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Statistics {

    public function __construct() {
        add_shortcode( 'cst_statistics', [ $this, 'render_shortcode' ] );
        add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'maybe_enqueue_assets' ] );
    }

    /* ------------------------------------------------------------------ */
    /*  Shortcode                                                         */
    /* ------------------------------------------------------------------ */

    public function render_shortcode( $atts ): string {
        $atts = shortcode_atts( [
            'limit' => -1,
        ], $atts, 'cst_statistics' );

        $stats = $this->get_statistics( intval( $atts['limit'] ) );

        if ( empty( $stats ) ) {
            return '<p class="cst-empty-state">' . esc_html__( 'No hay estadísticas disponibles en este momento.', 'cst-core' ) . '</p>';
        }

        // Enqueue assets when shortcode is actually used.
        wp_enqueue_style( 'cst-statistics' );
        wp_enqueue_script( 'cst-statistics' );

        ob_start();
        ?>
        <div class="cst-statistics" aria-label="<?php esc_attr_e( 'Estadísticas públicas', 'cst-core' ); ?>">
            <div class="cst-statistics__grid">
                <?php foreach ( $stats as $stat ) : ?>
                    <div class="cst-statistics__card" data-target="<?php echo esc_attr( $stat['value'] ); ?>">
                        <?php if ( $stat['icon'] ) : ?>
                            <span class="cst-statistics__icon dashicons <?php echo esc_attr( $stat['icon'] ); ?>" aria-hidden="true"></span>
                        <?php endif; ?>
                        <span class="cst-statistics__value" aria-live="polite">
                            <span class="cst-stat-counter" data-value="<?php echo esc_attr( $stat['value'] ); ?>">0</span><?php if ( $stat['unit'] ) : ?><span class="cst-statistics__unit"><?php echo esc_html( $stat['unit'] ); ?></span><?php endif; ?>
                        </span>
                        <span class="cst-statistics__label"><?php echo esc_html( $stat['title'] ); ?></span>
                        <?php if ( ! empty( $stat['trend'] ) ) : ?>
                            <?php
                            $trend_value = floatval( $stat['trend'] );
                            $trend_class = $trend_value >= 0 ? 'cst-statistics__trend--up' : 'cst-statistics__trend--down';
                            $trend_label = $trend_value >= 0 ? '+' . abs( $trend_value ) : '-' . abs( $trend_value );
                            ?>
                            <span class="cst-statistics__trend <?php echo esc_attr( $trend_class ); ?>">
                                <?php echo esc_html( $trend_label ); ?>%
                            </span>
                        <?php endif; ?>
                        <?php if ( $stat['source'] ) : ?>
                            <span class="cst-statistics__source"><?php echo esc_html( $stat['source'] ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /* ------------------------------------------------------------------ */
    /*  REST API                                                          */
    /* ------------------------------------------------------------------ */

    public function register_rest_routes(): void {
        register_rest_route( 'cst/v1', '/statistics', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'rest_get_statistics' ],
            'permission_callback' => '__return_true',
        ] );

        register_rest_route( 'cst/v1', '/statistics/dashboard', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'rest_get_dashboard' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function rest_get_statistics( WP_REST_Request $request ): WP_REST_Response {
        $limit = $request->get_param( 'limit' );
        $stats = $this->get_statistics( $limit ? intval( $limit ) : -1 );

        return new WP_REST_Response( $stats, 200 );
    }

    public function rest_get_dashboard( WP_REST_Request $request ): WP_REST_Response {
        return new WP_REST_Response( [
            'categories' => $this->get_statistics_by_category(),
            'charts'     => $this->get_dashboard_chart_data(),
        ], 200 );
    }

    /* ------------------------------------------------------------------ */
    /*  Data                                                              */
    /* ------------------------------------------------------------------ */

    public function get_statistics( int $limit = -1 ): array {
        $query = new WP_Query( [
            'post_type'      => 'cst_statistic',
            'posts_per_page' => $limit,
            'post_status'    => 'publish',
            'meta_key'       => '_cst_stat_order',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        ] );

        $stats = [];
        while ( $query->have_posts() ) {
            $query->the_post();
            $id = get_the_ID();
            $stats[] = [
                'id'          => $id,
                'title'       => get_the_title(),
                'value'       => get_post_meta( $id, '_cst_stat_value', true ),
                'unit'        => get_post_meta( $id, '_cst_stat_unit', true ),
                'icon'        => get_post_meta( $id, '_cst_stat_icon', true ),
                'source'      => get_post_meta( $id, '_cst_stat_source', true ),
                'order'       => get_post_meta( $id, '_cst_stat_order', true ),
                'trend'       => get_post_meta( $id, '_cst_stat_trend', true ),
                'category'    => get_post_meta( $id, '_cst_stat_category', true ),
                'chart_type'  => get_post_meta( $id, '_cst_stat_chart_type', true ),
                'chart_label' => get_post_meta( $id, '_cst_stat_chart_label', true ),
                'chart_data'  => get_post_meta( $id, '_cst_stat_chart_data', true ),
            ];
        }
        wp_reset_postdata();

        return $stats;
    }

    /**
     * Group statistics by category for dashboard display.
     *
     * @return array Grouped statistics: { kpi: [...], patients: [...], safety: [...], education: [...] }
     */
    public function get_statistics_by_category(): array {
        $all   = $this->get_statistics();
        $groups = [
            'kpi'       => [],
            'patients'  => [],
            'safety'    => [],
            'education' => [],
        ];

        foreach ( $all as $stat ) {
            $cat = $stat['category'];
            if ( empty( $cat ) || ! isset( $groups[ $cat ] ) ) {
                $groups['kpi'][] = $stat;
            } else {
                $groups[ $cat ][] = $stat;
            }
        }

        return $groups;
    }

    /**
     * Get chart configurations for dashboard.
     * Returns only statistics that have chart_type != 'none' and valid chart_data.
     *
     * @return array Array of chart configs ready for Chart.js.
     */
    public function get_dashboard_chart_data(): array {
        $all    = $this->get_statistics();
        $charts = [];

        foreach ( $all as $stat ) {
            $chart_type = $stat['chart_type'] ?? 'none';
            $chart_data = $stat['chart_data'] ?? '';

            if ( 'none' === $chart_type || empty( $chart_data ) ) {
                continue;
            }

            $parsed = json_decode( $chart_data, true );
            if ( ! is_array( $parsed ) ) {
                continue;
            }

            $labels = [];
            $values = [];
            foreach ( $parsed as $item ) {
                $labels[] = $item['label'] ?? '';
                $values[] = $item['value'] ?? 0;
            }

            $charts[] = [
                'id'         => $stat['id'],
                'title'      => $stat['title'],
                'type'       => $chart_type,
                'category'   => $stat['category'],
                'chartLabel' => $stat['chart_label'] ?: $stat['title'],
                'labels'     => $labels,
                'data'       => $values,
            ];
        }

        return $charts;
    }

    /* ------------------------------------------------------------------ */
    /*  Assets                                                            */
    /* ------------------------------------------------------------------ */

    public function maybe_enqueue_assets(): void {
        // Register Chart.js CDN.
        wp_register_script(
            'chartjs',
            'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js',
            [],
            '4.4.1',
            true
        );

        // Register but don't enqueue — shortcode/template enqueues when needed.
        wp_register_style(
            'cst-statistics',
            CST_CORE_URL . 'assets/css/statistics.css',
            [],
            CST_CORE_VERSION
        );

        wp_register_script(
            'cst-statistics',
            CST_CORE_URL . 'assets/js/statistics.js',
            [],
            CST_CORE_VERSION,
            true
        );

        // Dashboard script depends on Chart.js.
        wp_register_script(
            'cst-statistics-dashboard',
            CST_CORE_URL . 'assets/js/statistics.js',
            [ 'chartjs' ],
            CST_CORE_VERSION,
            true
        );
    }
}
