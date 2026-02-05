<?php
/**
 * CST_Course — Registers course CPT, taxonomy, and meta fields for driver education.
 *
 * CPT: cst_course_module (Course modules / lessons)
 * Taxonomy: cst_course_level (Course difficulty levels)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Course {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register(): void {
        $this->register_course_level_taxonomy();
        $this->register_course_module_cpt();
    }

    /* ------------------------------------------------------------------ */
    /*  cst_course_level — Taxonomy for course difficulty / category       */
    /* ------------------------------------------------------------------ */
    private function register_course_level_taxonomy(): void {
        $labels = [
            'name'          => __( 'Niveles del curso', 'cst-core' ),
            'singular_name' => __( 'Nivel del curso', 'cst-core' ),
            'search_items'  => __( 'Buscar niveles', 'cst-core' ),
            'all_items'     => __( 'Todos los niveles', 'cst-core' ),
            'edit_item'     => __( 'Editar nivel', 'cst-core' ),
            'update_item'   => __( 'Actualizar nivel', 'cst-core' ),
            'add_new_item'  => __( 'Añadir nuevo nivel', 'cst-core' ),
            'new_item_name' => __( 'Nuevo nombre de nivel', 'cst-core' ),
            'menu_name'     => __( 'Niveles', 'cst-core' ),
        ];

        register_taxonomy( 'cst_course_level', 'cst_course_module', [
            'labels'       => $labels,
            'hierarchical' => true,
            'rewrite'      => [ 'slug' => 'nivel-curso', 'with_front' => false ],
            'show_in_rest' => true,
        ] );
    }

    /* ------------------------------------------------------------------ */
    /*  cst_course_module — Course modules / lessons                      */
    /* ------------------------------------------------------------------ */
    private function register_course_module_cpt(): void {
        $labels = [
            'name'               => __( 'Módulos del curso', 'cst-core' ),
            'singular_name'      => __( 'Módulo del curso', 'cst-core' ),
            'add_new'            => __( 'Añadir módulo', 'cst-core' ),
            'add_new_item'       => __( 'Añadir nuevo módulo', 'cst-core' ),
            'edit_item'          => __( 'Editar módulo', 'cst-core' ),
            'new_item'           => __( 'Nuevo módulo', 'cst-core' ),
            'view_item'          => __( 'Ver módulo', 'cst-core' ),
            'search_items'       => __( 'Buscar módulos', 'cst-core' ),
            'not_found'          => __( 'No se encontraron módulos', 'cst-core' ),
            'not_found_in_trash' => __( 'No se encontraron módulos en la papelera', 'cst-core' ),
            'all_items'          => __( 'Todos los módulos', 'cst-core' ),
            'menu_name'          => __( 'Curso: Módulos', 'cst-core' ),
        ];

        register_post_type( 'cst_course_module', [
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => true,
            'rewrite'      => [ 'slug' => 'curso/modulo', 'with_front' => false ],
            'menu_icon'    => 'dashicons-welcome-learn-more',
            'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ],
            'taxonomies'   => [ 'cst_course_level' ],
            'show_in_rest' => true,
        ] );

        add_action( 'add_meta_boxes', [ $this, 'add_module_meta_boxes' ] );
        add_action( 'save_post_cst_course_module', [ $this, 'save_module_meta' ] );
    }

    /* ------------------------------------------------------------------ */
    /*  Meta Boxes                                                         */
    /* ------------------------------------------------------------------ */
    public function add_module_meta_boxes(): void {
        add_meta_box(
            'cst_module_data',
            __( 'Datos del módulo', 'cst-core' ),
            [ $this, 'render_module_meta_box' ],
            'cst_course_module',
            'normal',
            'high'
        );
    }

    public function render_module_meta_box( $post ): void {
        wp_nonce_field( 'cst_module_meta', 'cst_module_nonce' );
        $order      = get_post_meta( $post->ID, '_cst_module_order', true );
        $duration   = get_post_meta( $post->ID, '_cst_module_duration', true );
        $icon       = get_post_meta( $post->ID, '_cst_module_icon', true );
        $objectives = get_post_meta( $post->ID, '_cst_module_objectives', true );
        $quiz_data  = get_post_meta( $post->ID, '_cst_module_quiz', true );
        ?>
        <table class="form-table">
            <tr>
                <th><label for="cst_module_order"><?php esc_html_e( 'Orden del módulo', 'cst-core' ); ?></label></th>
                <td><input type="number" id="cst_module_order" name="cst_module_order" value="<?php echo esc_attr( $order ); ?>" class="small-text" min="1"></td>
            </tr>
            <tr>
                <th><label for="cst_module_duration"><?php esc_html_e( 'Duración estimada (minutos)', 'cst-core' ); ?></label></th>
                <td><input type="number" id="cst_module_duration" name="cst_module_duration" value="<?php echo esc_attr( $duration ); ?>" class="small-text" min="1"></td>
            </tr>
            <tr>
                <th><label for="cst_module_icon"><?php esc_html_e( 'Icono (dashicon)', 'cst-core' ); ?></label></th>
                <td><input type="text" id="cst_module_icon" name="cst_module_icon" value="<?php echo esc_attr( $icon ); ?>" class="regular-text" placeholder="dashicons-car"></td>
            </tr>
            <tr>
                <th><label for="cst_module_objectives"><?php esc_html_e( 'Objetivos de aprendizaje (uno por línea)', 'cst-core' ); ?></label></th>
                <td><textarea id="cst_module_objectives" name="cst_module_objectives" rows="5" class="large-text"><?php echo esc_textarea( $objectives ); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="cst_module_quiz"><?php esc_html_e( 'Preguntas del quiz (JSON)', 'cst-core' ); ?></label></th>
                <td>
                    <textarea id="cst_module_quiz" name="cst_module_quiz" rows="10" class="large-text code"><?php echo esc_textarea( $quiz_data ); ?></textarea>
                    <p class="description"><?php esc_html_e( 'Formato JSON: [{"question":"...","options":["A","B","C","D"],"correct":0,"explanation":"..."}]', 'cst-core' ); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    public function save_module_meta( $post_id ): void {
        if ( ! isset( $_POST['cst_module_nonce'] ) || ! wp_verify_nonce( $_POST['cst_module_nonce'], 'cst_module_meta' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $text_fields = [
            'cst_module_order'      => '_cst_module_order',
            'cst_module_duration'   => '_cst_module_duration',
            'cst_module_icon'       => '_cst_module_icon',
        ];

        foreach ( $text_fields as $input => $meta_key ) {
            if ( isset( $_POST[ $input ] ) ) {
                update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $input ] ) ) );
            }
        }

        // Textarea fields.
        if ( isset( $_POST['cst_module_objectives'] ) ) {
            update_post_meta( $post_id, '_cst_module_objectives', sanitize_textarea_field( wp_unslash( $_POST['cst_module_objectives'] ) ) );
        }
        if ( isset( $_POST['cst_module_quiz'] ) ) {
            update_post_meta( $post_id, '_cst_module_quiz', sanitize_textarea_field( wp_unslash( $_POST['cst_module_quiz'] ) ) );
        }
    }

    /* ------------------------------------------------------------------ */
    /*  REST API — Course Progress (via localStorage on front-end)        */
    /* ------------------------------------------------------------------ */

    /**
     * Get all modules ordered for curriculum display.
     *
     * @return WP_Post[]
     */
    public static function get_ordered_modules(): array {
        $query = new WP_Query( [
            'post_type'      => 'cst_course_module',
            'posts_per_page' => -1,
            'meta_key'       => '_cst_module_order',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ] );

        return $query->posts;
    }

    /**
     * Get module quiz data.
     *
     * @param int $post_id Module post ID.
     * @return array Decoded quiz questions or empty array.
     */
    public static function get_quiz_data( int $post_id ): array {
        $raw = get_post_meta( $post_id, '_cst_module_quiz', true );
        if ( empty( $raw ) ) {
            return [];
        }
        $decoded = json_decode( $raw, true );
        return is_array( $decoded ) ? $decoded : [];
    }

    /**
     * Get module learning objectives.
     *
     * @param int $post_id Module post ID.
     * @return array Array of objective strings.
     */
    public static function get_objectives( int $post_id ): array {
        $raw = get_post_meta( $post_id, '_cst_module_objectives', true );
        if ( empty( $raw ) ) {
            return [];
        }
        return array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
    }
}
