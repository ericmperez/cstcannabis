<?php
/**
 * Template Name: Estadísticas
 * Template Post Type: page
 *
 * Modern metrics dashboard with KPI cards, tabbed Chart.js visualizations,
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

// Check which category tabs have data.
$has_patients  = ! empty( $charts_by_category['patients'] );
$has_safety    = ! empty( $charts_by_category['safety'] );
$has_education = ! empty( $charts_by_category['education'] );
$has_any_chart = $has_patients || $has_safety || $has_education;

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

        <!-- Toolbar: timestamp + category tabs -->
        <section class="cst-section" aria-label="<?php esc_attr_e( 'Controles del panel', 'cst-cannabis' ); ?>">
            <div class="cst-container">
                <div class="cst-dashboard__toolbar">
                    <div class="cst-dashboard__meta">
                        <span class="cst-dashboard__meta-dot" aria-hidden="true"></span>
                        <?php
                        printf(
                            /* translators: %s: formatted date */
                            esc_html__( 'Datos actualizados: %s', 'cst-cannabis' ),
                            esc_html( date_i18n( get_option( 'date_format' ) ) )
                        );
                        ?>
                    </div>
                    <?php if ( $has_any_chart ) : ?>
                    <div class="cst-dashboard__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Categorías de datos', 'cst-cannabis' ); ?>">
                        <button class="cst-dashboard__tab" role="tab" aria-selected="true" aria-controls="panel-all" id="tab-all" type="button">
                            <?php esc_html_e( 'Todos', 'cst-cannabis' ); ?>
                        </button>
                        <?php if ( $has_patients ) : ?>
                        <button class="cst-dashboard__tab" role="tab" aria-selected="false" aria-controls="panel-patients" id="tab-patients" type="button">
                            <?php esc_html_e( 'Pacientes', 'cst-cannabis' ); ?>
                        </button>
                        <?php endif; ?>
                        <?php if ( $has_safety ) : ?>
                        <button class="cst-dashboard__tab" role="tab" aria-selected="false" aria-controls="panel-safety" id="tab-safety" type="button">
                            <?php esc_html_e( 'Seguridad', 'cst-cannabis' ); ?>
                        </button>
                        <?php endif; ?>
                        <?php if ( $has_education ) : ?>
                        <button class="cst-dashboard__tab" role="tab" aria-selected="false" aria-controls="panel-education" id="tab-education" type="button">
                            <?php esc_html_e( 'Educación', 'cst-cannabis' ); ?>
                        </button>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

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
                            <span class="cst-kpi-card__label"><?php echo esc_html( $stat['title'] ); ?></span>
                            <span class="cst-kpi-card__value" aria-live="polite">
                                <span class="cst-stat-counter" data-value="<?php echo esc_attr( $stat['value'] ); ?>">0</span><?php if ( ! empty( $stat['unit'] ) ) : ?><span class="cst-kpi-card__unit"><?php echo esc_html( $stat['unit'] ); ?></span><?php endif; ?>
                            </span>
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

        <!-- Charts: "All" panel -->
        <?php if ( $has_any_chart ) : ?>
        <div id="panel-all" class="cst-dashboard__panel is-active" role="tabpanel" aria-labelledby="tab-all" aria-hidden="false">

            <?php if ( $has_patients ) : ?>
            <section class="cst-section cst-dashboard__category cst-dashboard__category--patients" aria-labelledby="patients-heading">
                <div class="cst-container">
                    <div class="cst-dashboard__category-header">
                        <span class="cst-dashboard__category-icon dashicons dashicons-heart" aria-hidden="true"></span>
                        <h2 id="patients-heading" class="cst-dashboard__category-title"><?php esc_html_e( 'Pacientes y datos médicos', 'cst-cannabis' ); ?></h2>
                    </div>
                    <div class="cst-dashboard__chart-grid">
                        <?php foreach ( $charts_by_category['patients'] as $chart ) : ?>
                            <div class="cst-chart-card cst-chart-card--no-js">
                                <div class="cst-chart-card__header">
                                    <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                                    <span class="cst-chart-card__badge cst-chart-card__badge--<?php echo esc_attr( $chart['type'] ); ?>"><?php echo esc_html( $chart['type'] ); ?></span>
                                </div>
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

            <?php if ( $has_safety ) : ?>
            <section class="cst-section cst-dashboard__category cst-dashboard__category--safety" aria-labelledby="safety-heading">
                <div class="cst-container">
                    <div class="cst-dashboard__category-header">
                        <span class="cst-dashboard__category-icon dashicons dashicons-shield" aria-hidden="true"></span>
                        <h2 id="safety-heading" class="cst-dashboard__category-title"><?php esc_html_e( 'Seguridad vial', 'cst-cannabis' ); ?></h2>
                    </div>
                    <div class="cst-dashboard__chart-grid">
                        <?php foreach ( $charts_by_category['safety'] as $chart ) : ?>
                            <div class="cst-chart-card cst-chart-card--no-js">
                                <div class="cst-chart-card__header">
                                    <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                                    <span class="cst-chart-card__badge cst-chart-card__badge--<?php echo esc_attr( $chart['type'] ); ?>"><?php echo esc_html( $chart['type'] ); ?></span>
                                </div>
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

            <?php if ( $has_education ) : ?>
            <section class="cst-section cst-dashboard__category cst-dashboard__category--education" aria-labelledby="education-heading">
                <div class="cst-container">
                    <div class="cst-dashboard__category-header">
                        <span class="cst-dashboard__category-icon dashicons dashicons-welcome-learn-more" aria-hidden="true"></span>
                        <h2 id="education-heading" class="cst-dashboard__category-title"><?php esc_html_e( 'Educación y alcance', 'cst-cannabis' ); ?></h2>
                    </div>
                    <div class="cst-dashboard__chart-grid">
                        <?php foreach ( $charts_by_category['education'] as $chart ) : ?>
                            <div class="cst-chart-card cst-chart-card--no-js">
                                <div class="cst-chart-card__header">
                                    <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                                    <span class="cst-chart-card__badge cst-chart-card__badge--<?php echo esc_attr( $chart['type'] ); ?>"><?php echo esc_html( $chart['type'] ); ?></span>
                                </div>
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

        </div><!-- #panel-all -->

        <!-- Individual category panels (shown when tab is selected) -->
        <?php if ( $has_patients ) : ?>
        <div id="panel-patients" class="cst-dashboard__panel" role="tabpanel" aria-labelledby="tab-patients" aria-hidden="true">
            <section class="cst-section cst-dashboard__category cst-dashboard__category--patients">
                <div class="cst-container">
                    <div class="cst-dashboard__category-header">
                        <span class="cst-dashboard__category-icon dashicons dashicons-heart" aria-hidden="true"></span>
                        <h2 class="cst-dashboard__category-title"><?php esc_html_e( 'Pacientes y datos médicos', 'cst-cannabis' ); ?></h2>
                    </div>
                    <div class="cst-dashboard__chart-grid">
                        <?php foreach ( $charts_by_category['patients'] as $chart ) : ?>
                            <div class="cst-chart-card cst-chart-card--no-js">
                                <div class="cst-chart-card__header">
                                    <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                                    <span class="cst-chart-card__badge cst-chart-card__badge--<?php echo esc_attr( $chart['type'] ); ?>"><?php echo esc_html( $chart['type'] ); ?></span>
                                </div>
                                <div class="cst-chart-card__canvas-wrap">
                                    <canvas
                                        id="cst-chart-patients-<?php echo esc_attr( $chart['id'] ); ?>"
                                        class="cst-chart-canvas"
                                        data-chart-id="<?php echo esc_attr( $chart['id'] ); ?>"
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
        </div>
        <?php endif; ?>

        <?php if ( $has_safety ) : ?>
        <div id="panel-safety" class="cst-dashboard__panel" role="tabpanel" aria-labelledby="tab-safety" aria-hidden="true">
            <section class="cst-section cst-dashboard__category cst-dashboard__category--safety">
                <div class="cst-container">
                    <div class="cst-dashboard__category-header">
                        <span class="cst-dashboard__category-icon dashicons dashicons-shield" aria-hidden="true"></span>
                        <h2 class="cst-dashboard__category-title"><?php esc_html_e( 'Seguridad vial', 'cst-cannabis' ); ?></h2>
                    </div>
                    <div class="cst-dashboard__chart-grid">
                        <?php foreach ( $charts_by_category['safety'] as $chart ) : ?>
                            <div class="cst-chart-card cst-chart-card--no-js">
                                <div class="cst-chart-card__header">
                                    <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                                    <span class="cst-chart-card__badge cst-chart-card__badge--<?php echo esc_attr( $chart['type'] ); ?>"><?php echo esc_html( $chart['type'] ); ?></span>
                                </div>
                                <div class="cst-chart-card__canvas-wrap">
                                    <canvas
                                        id="cst-chart-safety-<?php echo esc_attr( $chart['id'] ); ?>"
                                        class="cst-chart-canvas"
                                        data-chart-id="<?php echo esc_attr( $chart['id'] ); ?>"
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
        </div>
        <?php endif; ?>

        <?php if ( $has_education ) : ?>
        <div id="panel-education" class="cst-dashboard__panel" role="tabpanel" aria-labelledby="tab-education" aria-hidden="true">
            <section class="cst-section cst-dashboard__category cst-dashboard__category--education">
                <div class="cst-container">
                    <div class="cst-dashboard__category-header">
                        <span class="cst-dashboard__category-icon dashicons dashicons-welcome-learn-more" aria-hidden="true"></span>
                        <h2 class="cst-dashboard__category-title"><?php esc_html_e( 'Educación y alcance', 'cst-cannabis' ); ?></h2>
                    </div>
                    <div class="cst-dashboard__chart-grid">
                        <?php foreach ( $charts_by_category['education'] as $chart ) : ?>
                            <div class="cst-chart-card cst-chart-card--no-js">
                                <div class="cst-chart-card__header">
                                    <h3 class="cst-chart-card__title"><?php echo esc_html( $chart['title'] ); ?></h3>
                                    <span class="cst-chart-card__badge cst-chart-card__badge--<?php echo esc_attr( $chart['type'] ); ?>"><?php echo esc_html( $chart['type'] ); ?></span>
                                </div>
                                <div class="cst-chart-card__canvas-wrap">
                                    <canvas
                                        id="cst-chart-education-<?php echo esc_attr( $chart['id'] ); ?>"
                                        class="cst-chart-canvas"
                                        data-chart-id="<?php echo esc_attr( $chart['id'] ); ?>"
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
        </div>
        <?php endif; ?>

        <?php endif; /* $has_any_chart */ ?>

        <!-- Sources Footer -->
        <?php if ( ! empty( $sources ) ) : ?>
        <section class="cst-section cst-section--sources cst-dashboard__sources" aria-labelledby="sources-heading">
            <div class="cst-container">
                <?php cst_section_heading( __( 'Fuentes y metodología', 'cst-cannabis' ), __( 'Los datos presentados provienen de las siguientes fuentes oficiales.', 'cst-cannabis' ), 'h2' ); ?>
                <div class="cst-sources-grid">
                    <?php foreach ( array_slice( $sources, 0, 3 ) as $source ) : ?>
                        <div class="cst-source-card">
                            <span class="cst-source-card__icon dashicons dashicons-media-document" aria-hidden="true"></span>
                            <div class="cst-source-card__content">
                                <h3 class="cst-source-card__title"><?php echo esc_html( $source ); ?></h3>
                                <p class="cst-source-card__description"><?php esc_html_e( 'Datos oficiales del gobierno de Puerto Rico.', 'cst-cannabis' ); ?></p>
                            </div>
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
