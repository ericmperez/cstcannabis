<?php
/**
 * WP-CLI Command: Seed Statistics Dashboard Data
 *
 * Usage: wp cst seed-statistics
 *
 * Creates/updates statistics for the dashboard:
 * - 4 KPI cards with trend data
 * - 6 chart-enabled statistics (2 per category)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WP_CLI' ) ) {
    return;
}

WP_CLI::add_command( 'cst seed-statistics', function () {

    // =========================================================================
    // KPI Statistics (no category — shown in top row)
    // =========================================================================

    $kpi_stats = [
        [
            'title'  => 'Pacientes registrados',
            'value'  => 128547,
            'unit'   => '',
            'icon'   => 'dashicons-groups',
            'order'  => 1,
            'source' => 'Departamento de Salud, 2024',
            'trend'  => 12.5,
        ],
        [
            'title'  => 'Fatalidades viales',
            'value'  => 267,
            'unit'   => '',
            'icon'   => 'dashicons-warning',
            'order'  => 2,
            'source' => 'Comisión para la Seguridad en el Tránsito, 2024',
            'trend'  => -8.3,
        ],
        [
            'title'  => 'Dispensarios activos',
            'value'  => 134,
            'unit'   => '',
            'icon'   => 'dashicons-store',
            'order'  => 3,
            'source' => 'Junta Reglamentadora del Cannabis Medicinal, 2024',
            'trend'  => 5.2,
        ],
        [
            'title'  => 'Talleres educativos',
            'value'  => 342,
            'unit'   => '',
            'icon'   => 'dashicons-welcome-learn-more',
            'order'  => 4,
            'source' => 'CST Educación, 2024',
            'trend'  => 22.1,
        ],
    ];

    // =========================================================================
    // Chart Statistics — Patients Category
    // =========================================================================

    $patients_stats = [
        [
            'title'       => 'Registro de pacientes por año',
            'value'       => 0,
            'unit'        => '',
            'icon'        => 'dashicons-chart-bar',
            'order'       => 10,
            'source'      => 'Departamento de Salud, 2024',
            'trend'       => '',
            'category'    => 'patients',
            'chart_type'  => 'bar',
            'chart_label' => 'Pacientes registrados',
            'chart_data'  => json_encode( [
                [ 'label' => '2018', 'value' => 45000 ],
                [ 'label' => '2019', 'value' => 62000 ],
                [ 'label' => '2020', 'value' => 78000 ],
                [ 'label' => '2021', 'value' => 89000 ],
                [ 'label' => '2022', 'value' => 102000 ],
                [ 'label' => '2023', 'value' => 118000 ],
                [ 'label' => '2024', 'value' => 128547 ],
            ] ),
        ],
        [
            'title'       => 'Condiciones más comunes',
            'value'       => 0,
            'unit'        => '',
            'icon'        => 'dashicons-heart',
            'order'       => 11,
            'source'      => 'Departamento de Salud, 2024',
            'trend'       => '',
            'category'    => 'patients',
            'chart_type'  => 'doughnut',
            'chart_label' => 'Porcentaje de pacientes',
            'chart_data'  => json_encode( [
                [ 'label' => 'Dolor crónico', 'value' => 52 ],
                [ 'label' => 'Ansiedad', 'value' => 18 ],
                [ 'label' => 'Insomnio', 'value' => 12 ],
                [ 'label' => 'PTSD', 'value' => 8 ],
                [ 'label' => 'Otras', 'value' => 10 ],
            ] ),
        ],
    ];

    // =========================================================================
    // Chart Statistics — Safety Category
    // =========================================================================

    $safety_stats = [
        [
            'title'       => 'Fatalidades viales por año',
            'value'       => 0,
            'unit'        => '',
            'icon'        => 'dashicons-chart-line',
            'order'       => 20,
            'source'      => 'Comisión para la Seguridad en el Tránsito, 2024',
            'trend'       => '',
            'category'    => 'safety',
            'chart_type'  => 'line',
            'chart_label' => 'Fatalidades',
            'chart_data'  => json_encode( [
                [ 'label' => '2018', 'value' => 312 ],
                [ 'label' => '2019', 'value' => 298 ],
                [ 'label' => '2020', 'value' => 245 ],
                [ 'label' => '2021', 'value' => 289 ],
                [ 'label' => '2022', 'value' => 301 ],
                [ 'label' => '2023', 'value' => 291 ],
                [ 'label' => '2024', 'value' => 267 ],
            ] ),
        ],
        [
            'title'       => 'Desglose de accidentes por sustancia',
            'value'       => 0,
            'unit'        => '',
            'icon'        => 'dashicons-chart-bar',
            'order'       => 21,
            'source'      => 'Comisión para la Seguridad en el Tránsito, 2024',
            'trend'       => '',
            'category'    => 'safety',
            'chart_type'  => 'bar',
            'chart_label' => 'Accidentes',
            'chart_data'  => json_encode( [
                [ 'label' => 'Alcohol', 'value' => 1842 ],
                [ 'label' => 'Cannabis', 'value' => 187 ],
                [ 'label' => 'Opioides', 'value' => 94 ],
                [ 'label' => 'Múltiples', 'value' => 312 ],
                [ 'label' => 'Ninguna', 'value' => 8456 ],
            ] ),
        ],
    ];

    // =========================================================================
    // Chart Statistics — Education Category
    // =========================================================================

    $education_stats = [
        [
            'title'       => 'Participantes en talleres por año',
            'value'       => 0,
            'unit'        => '',
            'icon'        => 'dashicons-chart-line',
            'order'       => 30,
            'source'      => 'CST Educación, 2024',
            'trend'       => '',
            'category'    => 'education',
            'chart_type'  => 'line',
            'chart_label' => 'Participantes',
            'chart_data'  => json_encode( [
                [ 'label' => '2020', 'value' => 1250 ],
                [ 'label' => '2021', 'value' => 2840 ],
                [ 'label' => '2022', 'value' => 4120 ],
                [ 'label' => '2023', 'value' => 5890 ],
                [ 'label' => '2024', 'value' => 7340 ],
            ] ),
        ],
        [
            'title'       => 'Alcance por tipo de actividad',
            'value'       => 0,
            'unit'        => '',
            'icon'        => 'dashicons-megaphone',
            'order'       => 31,
            'source'      => 'CST Educación, 2024',
            'trend'       => '',
            'category'    => 'education',
            'chart_type'  => 'doughnut',
            'chart_label' => 'Porcentaje',
            'chart_data'  => json_encode( [
                [ 'label' => 'Talleres presenciales', 'value' => 35 ],
                [ 'label' => 'Webinars', 'value' => 28 ],
                [ 'label' => 'Ferias de salud', 'value' => 18 ],
                [ 'label' => 'Escuelas', 'value' => 12 ],
                [ 'label' => 'Empresas', 'value' => 7 ],
            ] ),
        ],
    ];

    // =========================================================================
    // Helper function to create or update a statistic
    // =========================================================================

    $create_or_update = function ( $data, $is_kpi = true ) {
        // Check if stat already exists by title.
        $existing = get_posts( [
            'post_type'      => 'cst_statistic',
            'post_status'    => 'any',
            'title'          => $data['title'],
            'posts_per_page' => 1,
        ] );

        if ( ! empty( $existing ) ) {
            $post_id = $existing[0]->ID;
            wp_update_post( [
                'ID'          => $post_id,
                'post_status' => 'publish',
            ] );
            WP_CLI::log( "Updated: {$data['title']}" );
        } else {
            $post_id = wp_insert_post( [
                'post_type'   => 'cst_statistic',
                'post_title'  => $data['title'],
                'post_status' => 'publish',
            ] );
            WP_CLI::log( "Created: {$data['title']}" );
        }

        // Update meta fields.
        update_post_meta( $post_id, '_cst_stat_value', $data['value'] );
        update_post_meta( $post_id, '_cst_stat_unit', $data['unit'] );
        update_post_meta( $post_id, '_cst_stat_icon', $data['icon'] );
        update_post_meta( $post_id, '_cst_stat_order', $data['order'] );
        update_post_meta( $post_id, '_cst_stat_source', $data['source'] );
        update_post_meta( $post_id, '_cst_stat_trend', $data['trend'] ?? '' );

        // Chart fields (only for non-KPI stats).
        if ( ! $is_kpi ) {
            update_post_meta( $post_id, '_cst_stat_category', $data['category'] ?? '' );
            update_post_meta( $post_id, '_cst_stat_chart_type', $data['chart_type'] ?? 'none' );
            update_post_meta( $post_id, '_cst_stat_chart_label', $data['chart_label'] ?? '' );
            update_post_meta( $post_id, '_cst_stat_chart_data', $data['chart_data'] ?? '' );
        } else {
            // Clear chart fields for KPIs.
            update_post_meta( $post_id, '_cst_stat_category', '' );
            update_post_meta( $post_id, '_cst_stat_chart_type', 'none' );
            update_post_meta( $post_id, '_cst_stat_chart_label', '' );
            update_post_meta( $post_id, '_cst_stat_chart_data', '' );
        }

        return $post_id;
    };

    // =========================================================================
    // Execute seeding
    // =========================================================================

    WP_CLI::log( '' );
    WP_CLI::log( '=== Seeding KPI Statistics ===' );
    foreach ( $kpi_stats as $stat ) {
        $create_or_update( $stat, true );
    }

    WP_CLI::log( '' );
    WP_CLI::log( '=== Seeding Patients Category ===' );
    foreach ( $patients_stats as $stat ) {
        $create_or_update( $stat, false );
    }

    WP_CLI::log( '' );
    WP_CLI::log( '=== Seeding Safety Category ===' );
    foreach ( $safety_stats as $stat ) {
        $create_or_update( $stat, false );
    }

    WP_CLI::log( '' );
    WP_CLI::log( '=== Seeding Education Category ===' );
    foreach ( $education_stats as $stat ) {
        $create_or_update( $stat, false );
    }

    WP_CLI::success( 'Statistics dashboard data seeded successfully!' );
    WP_CLI::log( '' );
    WP_CLI::log( 'Total: 4 KPI cards + 6 charts (10 statistics)' );
    WP_CLI::log( 'View dashboard at: /estadisticas/' );
} );
