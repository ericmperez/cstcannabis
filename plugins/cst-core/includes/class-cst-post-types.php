<?php
/**
 * CST_Post_Types — Registers CPTs and taxonomies for CST portals.
 *
 * CPTs: cst_resource, cst_statistic, cst_faq
 * Taxonomies: cst_resource_type
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Post_Types {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register(): void {
        $this->register_resource_type_taxonomy();
        $this->register_resource_cpt();
        $this->register_statistic_cpt();
        $this->register_faq_cpt();
    }

    /* ------------------------------------------------------------------ */
    /*  cst_resource — Educational resources (guides, videos, documents)  */
    /* ------------------------------------------------------------------ */
    private function register_resource_cpt(): void {
        $labels = [
            'name'               => __( 'Recursos', 'cst-core' ),
            'singular_name'      => __( 'Recurso', 'cst-core' ),
            'add_new'            => __( 'Añadir recurso', 'cst-core' ),
            'add_new_item'       => __( 'Añadir nuevo recurso', 'cst-core' ),
            'edit_item'          => __( 'Editar recurso', 'cst-core' ),
            'new_item'           => __( 'Nuevo recurso', 'cst-core' ),
            'view_item'          => __( 'Ver recurso', 'cst-core' ),
            'search_items'       => __( 'Buscar recursos', 'cst-core' ),
            'not_found'          => __( 'No se encontraron recursos', 'cst-core' ),
            'not_found_in_trash' => __( 'No se encontraron recursos en la papelera', 'cst-core' ),
            'all_items'          => __( 'Todos los recursos', 'cst-core' ),
            'menu_name'          => __( 'Recursos', 'cst-core' ),
        ];

        register_post_type( 'cst_resource', [
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => true,
            'rewrite'      => [ 'slug' => 'recursos', 'with_front' => false ],
            'menu_icon'    => 'dashicons-media-document',
            'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
            'taxonomies'   => [ 'cst_resource_type' ],
            'show_in_rest' => true,
        ] );
    }

    /* ------------------------------------------------------------------ */
    /*  cst_resource_type — Taxonomy for resource categorisation          */
    /* ------------------------------------------------------------------ */
    private function register_resource_type_taxonomy(): void {
        $labels = [
            'name'          => __( 'Tipos de recurso', 'cst-core' ),
            'singular_name' => __( 'Tipo de recurso', 'cst-core' ),
            'search_items'  => __( 'Buscar tipos', 'cst-core' ),
            'all_items'     => __( 'Todos los tipos', 'cst-core' ),
            'edit_item'     => __( 'Editar tipo', 'cst-core' ),
            'update_item'   => __( 'Actualizar tipo', 'cst-core' ),
            'add_new_item'  => __( 'Añadir nuevo tipo', 'cst-core' ),
            'new_item_name' => __( 'Nuevo nombre de tipo', 'cst-core' ),
            'menu_name'     => __( 'Tipos de recurso', 'cst-core' ),
        ];

        register_taxonomy( 'cst_resource_type', 'cst_resource', [
            'labels'       => $labels,
            'hierarchical' => true,
            'rewrite'      => [ 'slug' => 'tipo-recurso', 'with_front' => false ],
            'show_in_rest' => true,
        ] );
    }

    /* ------------------------------------------------------------------ */
    /*  cst_statistic — Public metrics / statistics                       */
    /* ------------------------------------------------------------------ */
    private function register_statistic_cpt(): void {
        $labels = [
            'name'               => __( 'Estadísticas', 'cst-core' ),
            'singular_name'      => __( 'Estadística', 'cst-core' ),
            'add_new'            => __( 'Añadir estadística', 'cst-core' ),
            'add_new_item'       => __( 'Añadir nueva estadística', 'cst-core' ),
            'edit_item'          => __( 'Editar estadística', 'cst-core' ),
            'new_item'           => __( 'Nueva estadística', 'cst-core' ),
            'view_item'          => __( 'Ver estadística', 'cst-core' ),
            'search_items'       => __( 'Buscar estadísticas', 'cst-core' ),
            'not_found'          => __( 'No se encontraron estadísticas', 'cst-core' ),
            'not_found_in_trash' => __( 'No se encontraron estadísticas en la papelera', 'cst-core' ),
            'all_items'          => __( 'Todas las estadísticas', 'cst-core' ),
            'menu_name'          => __( 'Estadísticas', 'cst-core' ),
        ];

        register_post_type( 'cst_statistic', [
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-chart-bar',
            'supports'     => [ 'title', 'revisions' ],
            'show_in_rest' => true,
        ] );

        // Custom fields for statistics.
        add_action( 'add_meta_boxes', [ $this, 'add_statistic_meta_boxes' ] );
        add_action( 'save_post_cst_statistic', [ $this, 'save_statistic_meta' ] );
    }

    public function add_statistic_meta_boxes(): void {
        add_meta_box(
            'cst_statistic_data',
            __( 'Datos de la estadística', 'cst-core' ),
            [ $this, 'render_statistic_meta_box' ],
            'cst_statistic',
            'normal',
            'high'
        );
    }

    public function render_statistic_meta_box( $post ): void {
        wp_nonce_field( 'cst_statistic_meta', 'cst_statistic_nonce' );
        $value       = get_post_meta( $post->ID, '_cst_stat_value', true );
        $unit        = get_post_meta( $post->ID, '_cst_stat_unit', true );
        $icon        = get_post_meta( $post->ID, '_cst_stat_icon', true );
        $order       = get_post_meta( $post->ID, '_cst_stat_order', true );
        $source      = get_post_meta( $post->ID, '_cst_stat_source', true );
        $trend       = get_post_meta( $post->ID, '_cst_stat_trend', true );
        $category    = get_post_meta( $post->ID, '_cst_stat_category', true );
        $chart_type  = get_post_meta( $post->ID, '_cst_stat_chart_type', true );
        $chart_label = get_post_meta( $post->ID, '_cst_stat_chart_label', true );
        $chart_data  = get_post_meta( $post->ID, '_cst_stat_chart_data', true );
        ?>
        <table class="form-table">
            <tr>
                <th><label for="cst_stat_value"><?php esc_html_e( 'Valor numérico', 'cst-core' ); ?></label></th>
                <td><input type="number" id="cst_stat_value" name="cst_stat_value" value="<?php echo esc_attr( $value ); ?>" class="regular-text" step="any"></td>
            </tr>
            <tr>
                <th><label for="cst_stat_unit"><?php esc_html_e( 'Unidad / sufijo', 'cst-core' ); ?></label></th>
                <td><input type="text" id="cst_stat_unit" name="cst_stat_unit" value="<?php echo esc_attr( $unit ); ?>" class="regular-text" placeholder="%, pacientes, accidentes…"></td>
            </tr>
            <tr>
                <th><label for="cst_stat_icon"><?php esc_html_e( 'Dashicon', 'cst-core' ); ?></label></th>
                <td><input type="text" id="cst_stat_icon" name="cst_stat_icon" value="<?php echo esc_attr( $icon ); ?>" class="regular-text" placeholder="dashicons-chart-line"></td>
            </tr>
            <tr>
                <th><label for="cst_stat_order"><?php esc_html_e( 'Orden', 'cst-core' ); ?></label></th>
                <td><input type="number" id="cst_stat_order" name="cst_stat_order" value="<?php echo esc_attr( $order ); ?>" class="small-text"></td>
            </tr>
            <tr>
                <th><label for="cst_stat_source"><?php esc_html_e( 'Fuente', 'cst-core' ); ?></label></th>
                <td><input type="text" id="cst_stat_source" name="cst_stat_source" value="<?php echo esc_attr( $source ); ?>" class="large-text" placeholder="Departamento de Salud, 2024"></td>
            </tr>
            <tr>
                <th><label for="cst_stat_trend"><?php esc_html_e( 'Tendencia (%)', 'cst-core' ); ?></label></th>
                <td>
                    <input type="number" id="cst_stat_trend" name="cst_stat_trend" value="<?php echo esc_attr( $trend ); ?>" class="small-text" step="0.1" placeholder="+12.5 o -3.2">
                    <p class="description"><?php esc_html_e( 'Porcentaje de cambio (positivo o negativo)', 'cst-core' ); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="cst_stat_category"><?php esc_html_e( 'Categoría', 'cst-core' ); ?></label></th>
                <td>
                    <select id="cst_stat_category" name="cst_stat_category">
                        <option value="" <?php selected( $category, '' ); ?>><?php esc_html_e( '— Solo KPI (sin gráfica) —', 'cst-core' ); ?></option>
                        <option value="patients" <?php selected( $category, 'patients' ); ?>><?php esc_html_e( 'Pacientes y datos médicos', 'cst-core' ); ?></option>
                        <option value="safety" <?php selected( $category, 'safety' ); ?>><?php esc_html_e( 'Seguridad vial', 'cst-core' ); ?></option>
                        <option value="education" <?php selected( $category, 'education' ); ?>><?php esc_html_e( 'Educación y alcance', 'cst-core' ); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cst_stat_chart_type"><?php esc_html_e( 'Tipo de gráfica', 'cst-core' ); ?></label></th>
                <td>
                    <select id="cst_stat_chart_type" name="cst_stat_chart_type">
                        <option value="none" <?php selected( $chart_type, 'none' ); ?>><?php esc_html_e( 'Ninguna', 'cst-core' ); ?></option>
                        <option value="bar" <?php selected( $chart_type, 'bar' ); ?>><?php esc_html_e( 'Barras', 'cst-core' ); ?></option>
                        <option value="line" <?php selected( $chart_type, 'line' ); ?>><?php esc_html_e( 'Líneas', 'cst-core' ); ?></option>
                        <option value="doughnut" <?php selected( $chart_type, 'doughnut' ); ?>><?php esc_html_e( 'Dona', 'cst-core' ); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cst_stat_chart_label"><?php esc_html_e( 'Etiqueta de gráfica', 'cst-core' ); ?></label></th>
                <td><input type="text" id="cst_stat_chart_label" name="cst_stat_chart_label" value="<?php echo esc_attr( $chart_label ); ?>" class="regular-text" placeholder="Eje Y o leyenda"></td>
            </tr>
            <tr>
                <th><label for="cst_stat_chart_data"><?php esc_html_e( 'Datos de gráfica (JSON)', 'cst-core' ); ?></label></th>
                <td>
                    <textarea id="cst_stat_chart_data" name="cst_stat_chart_data" rows="5" class="large-text code"><?php echo esc_textarea( $chart_data ); ?></textarea>
                    <p class="description"><?php esc_html_e( 'Formato: [{"label":"2020","value":85000}, {"label":"2021","value":92000}]', 'cst-core' ); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    public function save_statistic_meta( $post_id ): void {
        if ( ! isset( $_POST['cst_statistic_nonce'] ) || ! wp_verify_nonce( $_POST['cst_statistic_nonce'], 'cst_statistic_meta' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $fields = [
            'cst_stat_value'       => '_cst_stat_value',
            'cst_stat_unit'        => '_cst_stat_unit',
            'cst_stat_icon'        => '_cst_stat_icon',
            'cst_stat_order'       => '_cst_stat_order',
            'cst_stat_source'      => '_cst_stat_source',
            'cst_stat_trend'       => '_cst_stat_trend',
            'cst_stat_category'    => '_cst_stat_category',
            'cst_stat_chart_type'  => '_cst_stat_chart_type',
            'cst_stat_chart_label' => '_cst_stat_chart_label',
        ];

        foreach ( $fields as $input => $meta_key ) {
            if ( isset( $_POST[ $input ] ) ) {
                update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $input ] ) ) );
            }
        }

        // Handle JSON chart data separately — validate JSON, store empty string if invalid.
        if ( isset( $_POST['cst_stat_chart_data'] ) ) {
            $raw_json = wp_unslash( $_POST['cst_stat_chart_data'] );
            $decoded  = json_decode( $raw_json, true );
            $valid    = ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded ) );
            update_post_meta( $post_id, '_cst_stat_chart_data', $valid ? $raw_json : '' );
        }
    }

    /* ------------------------------------------------------------------ */
    /*  cst_faq — Chatbot knowledge base                                  */
    /* ------------------------------------------------------------------ */
    private function register_faq_cpt(): void {
        $labels = [
            'name'               => __( 'Preguntas frecuentes', 'cst-core' ),
            'singular_name'      => __( 'Pregunta frecuente', 'cst-core' ),
            'add_new'            => __( 'Añadir pregunta', 'cst-core' ),
            'add_new_item'       => __( 'Añadir nueva pregunta', 'cst-core' ),
            'edit_item'          => __( 'Editar pregunta', 'cst-core' ),
            'new_item'           => __( 'Nueva pregunta', 'cst-core' ),
            'view_item'          => __( 'Ver pregunta', 'cst-core' ),
            'search_items'       => __( 'Buscar preguntas', 'cst-core' ),
            'not_found'          => __( 'No se encontraron preguntas', 'cst-core' ),
            'not_found_in_trash' => __( 'No se encontraron preguntas en la papelera', 'cst-core' ),
            'all_items'          => __( 'Todas las preguntas', 'cst-core' ),
            'menu_name'          => __( 'FAQ / Chatbot', 'cst-core' ),
        ];

        register_post_type( 'cst_faq', [
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-format-chat',
            'supports'     => [ 'title', 'editor', 'revisions' ],
            'show_in_rest' => true,
        ] );
    }
}
