<?php
/**
 * Template Name: Estadísticas
 * Template Post Type: page
 *
 * Public metrics dashboard with KPI cards, Chart.js visualizations,
 * and sources footer.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get statistics data.
$statistics = new CST_Statistics();
$categories = $statistics->get_statistics_by_category();
$charts     = $statistics->get_dashboard_chart_data();

// Group charts by category for rendering.
$charts_by_category = [
    'patients'  => [],
    'safety'    => [],
    'education' => [],
];
foreach ( $charts as $chart ) {
    $cat = $chart['category'] ?? '';
    if ( isset( $charts_by_category[ $cat ] ) ) {
        $charts_by_category[ $cat ][] = $chart;
    }
}

// Collect unique sources for the footer.
$sources = [];
foreach ( $statistics->get_statistics() as $stat ) {
    if ( ! empty( $stat['source'] ) && ! in_array( $stat['source'], $sources, true ) ) {
        $sources[] = $stat['source'];
    }
}

// Enqueue dashboard assets.
wp_enqueue_style( 'cst-statistics' );
wp_enqueue_script( 'cst-statistics-dashboard' );
wp_localize_script( 'cst-statistics-dashboard', 'cstDashboardData', [
    'charts' => $charts,
] );

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => get_the_title(),
        'subtitle' => __( 'Datos y métricas sobre la seguridad vial y el uso del cannabis medicinal en Puerto Rico.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page cst-hero--slim',
    ] );
    ?>

    <div class="cst-dashboard">

        <!-- KPI Row -->
        <?php if ( ! empty( $categories['kpi'] ) ) : ?>
        <section class="cst-section cst-section--kpi" aria-labelledby="kpi-heading">
            <div class="cst-container">
                <h2 id="kpi-heading" class="screen-reader-text"><?php esc_html_e( 'Indicadores clave', 'cst-cannabis' ); ?></h2>
                <div class="cst-dashboard__kpi-grid">
                    <?php foreach ( $categories['kpi'] as $stat ) : ?>
                        <article class="cst-kpi-card" tabindex="0">
                            <?php if ( ! empty( $stat['icon'] ) ) : ?>
                                <span class="cst-kpi-card__icon dashicons <?php echo esc_attr( $stat['icon'] ); ?>" aria-hidden="true"></span>
                            <?php endif; ?>
                            <span class="cst-kpi-card__value" aria-live="polite">
                                <span class="cst-stat-counter" data-value="<?php echo esc_attr( $stat['value'] ); ?>">0</span><?php if ( ! empty( $stat['unit'] ) ) : ?><span class="cst-kpi-card__unit"><?php echo esc_html( $stat['unit'] ); ?></span><?php endif; ?>
                            </span>
                            <span class="cst-kpi-card__label"><?php echo esc_html( $stat['title'] ); ?></span>
                            <?php if ( ! empty( $stat['trend'] ) ) : ?>
                                <?php
                                $trend_value = floatval( $stat['trend'] );
                                $trend_class = $trend_value >= 0 ? 'cst-kpi-card__trend--up' : 'cst-kpi-card__trend--down';
                                $trend_label = $trend_value >= 0 ? '+' . abs( $trend_value ) : '-' . abs( $trend_value );
                                ?>
                                <span class="cst-kpi-card__trend <?php echo esc_attr( $trend_class ); ?>">
                                    <?php echo esc_html( $trend_label ); ?>%
                                </span>
                            <?php endif; ?>
                            <?php if ( ! empty( $stat['source'] ) ) : ?>
                                <span class="cst-kpi-card__source"><?php echo esc_html( $stat['source'] ); ?></span>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Patients Category -->
        <?php if ( ! empty( $charts_by_category['patients'] ) ) : ?>
        <section class="cst-section cst-section--charts cst-dashboard__category" aria-labelledby="patients-heading">
            <div class="cst-container">
                <?php cst_section_heading( __( 'Pacientes y datos médicos', 'cst-cannabis' ), '', 'h2' ); ?>
                <div class="cst-dashboard__category-grid">
                    <?php foreach ( $charts_by_category['patients'] as $chart ) : ?>
                        <div class="cst-chart-card cst-chart-card--no-js">
                            <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                            <div class="cst-chart-card__canvas-wrap">
                                <canvas
                                    id="cst-chart-<?php echo esc_attr( $chart['id'] ); ?>"
                                    role="img"
                                    aria-label="<?php echo esc_attr( $chart['title'] ); ?>"
                                ></canvas>
                            </div>
                            <p class="cst-chart-card__fallback"><?php esc_html_e( 'Gráfica no disponible. Habilite JavaScript para ver este contenido.', 'cst-cannabis' ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Safety Category -->
        <?php if ( ! empty( $charts_by_category['safety'] ) ) : ?>
        <section class="cst-section cst-section--charts cst-dashboard__category" aria-labelledby="safety-heading">
            <div class="cst-container">
                <?php cst_section_heading( __( 'Seguridad vial', 'cst-cannabis' ), '', 'h2' ); ?>
                <div class="cst-dashboard__category-grid">
                    <?php foreach ( $charts_by_category['safety'] as $chart ) : ?>
                        <div class="cst-chart-card cst-chart-card--no-js">
                            <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                            <div class="cst-chart-card__canvas-wrap">
                                <canvas
                                    id="cst-chart-<?php echo esc_attr( $chart['id'] ); ?>"
                                    role="img"
                                    aria-label="<?php echo esc_attr( $chart['title'] ); ?>"
                                ></canvas>
                            </div>
                            <p class="cst-chart-card__fallback"><?php esc_html_e( 'Gráfica no disponible. Habilite JavaScript para ver este contenido.', 'cst-cannabis' ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Education Category -->
        <?php if ( ! empty( $charts_by_category['education'] ) ) : ?>
        <section class="cst-section cst-section--charts cst-dashboard__category" aria-labelledby="education-heading">
            <div class="cst-container">
                <?php cst_section_heading( __( 'Educación y alcance', 'cst-cannabis' ), '', 'h2' ); ?>
                <div class="cst-dashboard__category-grid">
                    <?php foreach ( $charts_by_category['education'] as $chart ) : ?>
                        <div class="cst-chart-card cst-chart-card--no-js">
                            <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                            <div class="cst-chart-card__canvas-wrap">
                                <canvas
                                    id="cst-chart-<?php echo esc_attr( $chart['id'] ); ?>"
                                    role="img"
                                    aria-label="<?php echo esc_attr( $chart['title'] ); ?>"
                                ></canvas>
                            </div>
                            <p class="cst-chart-card__fallback"><?php esc_html_e( 'Gráfica no disponible. Habilite JavaScript para ver este contenido.', 'cst-cannabis' ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Sources Footer -->
        <?php if ( ! empty( $sources ) ) : ?>
        <section class="cst-section cst-section--sources cst-dashboard__sources" aria-labelledby="sources-heading">
            <div class="cst-container">
                <?php cst_section_heading( __( 'Fuentes y metodología', 'cst-cannabis' ), __( 'Los datos presentados provienen de las siguientes fuentes oficiales.', 'cst-cannabis' ), 'h2' ); ?>
                <div class="cst-sources-grid">
                    <?php foreach ( array_slice( $sources, 0, 3 ) as $source ) : ?>
                        <div class="cst-source-card">
                            <h3 class="cst-source-card__title"><?php echo esc_html( $source ); ?></h3>
                            <p class="cst-source-card__description"><?php esc_html_e( 'Datos oficiales del gobierno de Puerto Rico.', 'cst-cannabis' ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Additional Page Content -->
        <?php
        while ( have_posts() ) :
            the_post();
            $content = get_the_content();
            if ( trim( $content ) ) :
        ?>
        <section class="cst-section cst-section--content">
            <div class="cst-container">
                <div class="cst-content-area">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
        <?php
            endif;
        endwhile;
        ?>

    </div>

</main>

<?php
get_footer();
