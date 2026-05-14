<?php
/**
 * CST_Content_Seeder — One-shot creation of the legal pages every PR
 * government portal must publish: Privacy Policy (Ley 39-2012), Terms
 * of Use, Cookie Policy, and Accessibility Statement (Ley 229-2003).
 *
 * Pages are created as **drafts** in Spanish with PR-specific boilerplate
 * clearly marked PLANTILLA — REVISAR ANTES DE PUBLICAR so legal review
 * happens before they go live. The seeder runs once per install (gated
 * by an option flag) so editors keep control of subsequent edits.
 *
 * Also trashes the default WP "¡Hola, mundo!" / "Hello world!" seed
 * post if it's still present.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Content_Seeder {

    private const OPTION_KEY = 'cst_content_seeded_v1';

    public function __construct() {
        add_action( 'init', [ $this, 'maybe_seed' ], 99 );
    }

    public function maybe_seed(): void {
        if ( get_option( self::OPTION_KEY ) ) {
            return;
        }
        // Only run on admin requests so a public 404 cron doesn't race us.
        if ( ! is_admin() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
            return;
        }

        $created = [];
        foreach ( $this->pages() as $slug => $page ) {
            $id = $this->create_draft( $slug, $page['title'], $page['content'] );
            if ( $id ) {
                $created[ $slug ] = $id;
            }
        }

        // Assign the privacy policy page to WP's privacy option.
        if ( ! empty( $created['politica-de-privacidad'] ) && ! get_option( 'wp_page_for_privacy_policy' ) ) {
            update_option( 'wp_page_for_privacy_policy', $created['politica-de-privacidad'] );
        }

        $this->trash_hello_world();

        update_option( self::OPTION_KEY, [
            'date'    => current_time( 'mysql' ),
            'created' => $created,
        ], false );
    }

    private function create_draft( string $slug, string $title, string $content ): int {
        $existing = get_page_by_path( $slug, OBJECT, 'page' );
        if ( $existing instanceof WP_Post ) {
            return (int) $existing->ID;
        }
        $banner = '<!-- wp:paragraph -->'
            . '<p style="background:#fff3cd;border-left:4px solid #f0ad4e;padding:12px 16px;"><strong>PLANTILLA — REVISAR ANTES DE PUBLICAR.</strong> '
            . 'Esta página fue generada automáticamente. Sustituya o valide el contenido con su asesor legal antes de cambiar el estado a "publicada".</p>'
            . '<!-- /wp:paragraph -->';
        $id = wp_insert_post( [
            'post_type'    => 'page',
            'post_status'  => 'draft',
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => $banner . "\n\n" . $content,
        ] );
        return is_wp_error( $id ) ? 0 : (int) $id;
    }

    private function trash_hello_world(): void {
        foreach ( [ 'hello-world', 'hola-mundo' ] as $slug ) {
            $post = get_page_by_path( $slug, OBJECT, 'post' );
            if ( $post instanceof WP_Post && 'trash' !== $post->post_status ) {
                wp_trash_post( $post->ID );
            }
        }
    }

    /**
     * @return array<string, array{title:string, content:string}>
     */
    private function pages(): array {
        return [
            'politica-de-privacidad' => [
                'title'   => 'Política de Privacidad',
                'content' => $this->privacy_content(),
            ],
            'terminos-de-uso' => [
                'title'   => 'Términos de Uso',
                'content' => $this->terms_content(),
            ],
            'politica-de-cookies' => [
                'title'   => 'Política de Cookies',
                'content' => $this->cookie_content(),
            ],
            'accesibilidad' => [
                'title'   => 'Declaración de Accesibilidad',
                'content' => $this->accessibility_content(),
            ],
        ];
    }

    private function privacy_content(): string {
        return <<<'HTML'
<!-- wp:heading --><h2>1. Responsable del tratamiento</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>La Comisión para la Seguridad en el Tránsito (CST) de Puerto Rico es la entidad responsable del tratamiento de los datos personales recopilados a través de este portal. Esta política se rige por la Ley 39-2012 sobre Acceso a la Información Pública y la normativa de protección de datos aplicable en Puerto Rico.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>2. Datos que recopilamos</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li>Datos de registro al curso (nombre, correo electrónico) cuando el usuario crea una cuenta.</li>
<li>Datos del formulario de contacto (nombre, correo, mensaje).</li>
<li>Datos técnicos anónimos de navegación (dirección IP, navegador, páginas visitadas) sujetos al consentimiento de cookies.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>3. Finalidad del tratamiento</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Los datos se utilizan exclusivamente para: (a) administrar la cuenta y el progreso del curso, (b) responder consultas del formulario de contacto, (c) generar estadísticas agregadas y anónimas de uso del portal. No se venden ni se comparten con terceros con fines comerciales.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>4. Base legal</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>El tratamiento se realiza sobre la base del consentimiento del usuario al registrarse o enviar un formulario, y del interés legítimo de la CST en cumplir su mandato educativo bajo la Ley 22-2000.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>5. Plazo de conservación</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Los datos de cuenta se conservan mientras la cuenta esté activa. Los datos del formulario de contacto se conservan por un máximo de 24 meses tras la última interacción. Las estadísticas anónimas pueden conservarse indefinidamente.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>6. Derechos del titular</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Usted tiene derecho a solicitar acceso, rectificación, eliminación, oposición y portabilidad de sus datos personales, así como retirar el consentimiento en cualquier momento. Las solicitudes se canalizan por escrito a <a href="mailto:comunicaciones@cst.pr.gov">comunicaciones@cst.pr.gov</a>.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>7. Medidas de seguridad</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>El portal aplica cifrado TLS, encabezados de seguridad (CSP, HSTS, COOP), limitación de intentos de acceso y registro auditado de eventos. El acceso a los datos personales está restringido al personal autorizado.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>8. Contacto</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Para preguntas sobre esta política: Comisión para la Seguridad en el Tránsito de Puerto Rico — <a href="mailto:comunicaciones@cst.pr.gov">comunicaciones@cst.pr.gov</a>.</p><!-- /wp:paragraph -->
HTML;
    }

    private function terms_content(): string {
        return <<<'HTML'
<!-- wp:heading --><h2>1. Aceptación</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>El acceso y uso de este portal implica la aceptación plena de los presentes Términos de Uso. Si no está de acuerdo, le rogamos no utilizar el sitio.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>2. Objeto</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Este portal de la Comisión para la Seguridad en el Tránsito (CST) ofrece información educativa sobre el cannabis medicinal y la seguridad vial, así como un curso gratuito de capacitación. El uso del portal es voluntario y gratuito.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>3. Uso permitido</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li>Consultar el contenido informativo y descargar materiales educativos.</li>
<li>Registrarse y completar el curso.</li>
<li>Comunicarse con la CST mediante los canales habilitados.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>4. Conducta prohibida</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li>Intentar acceder a áreas privadas, eludir controles de seguridad o realizar pruebas no autorizadas.</li>
<li>Suplantar la identidad de otra persona al registrarse.</li>
<li>Utilizar el contenido del portal con fines comerciales sin autorización por escrito.</li>
<li>Cargar contenido ofensivo, ilegal o que vulnere derechos de terceros mediante los formularios.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>5. Propiedad intelectual</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>El contenido del portal (textos, imágenes, video, código) es propiedad de la CST o se utiliza bajo licencia. Se permite la reproducción con fines educativos no comerciales citando la fuente.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>6. Limitación de responsabilidad</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>La información publicada se ofrece con fines educativos y no sustituye asesoría médica, legal o profesional. La CST no se responsabiliza por interpretaciones, decisiones o daños derivados del uso del contenido.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>7. Enlaces a terceros</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>El portal puede enlazar a sitios externos (por ejemplo, oig.pr.gov, accesibilidad.pr.gov). La CST no se hace responsable del contenido ni de las prácticas de privacidad de dichos sitios.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>8. Modificaciones</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>La CST se reserva el derecho de modificar estos términos en cualquier momento. Los cambios entran en vigor al publicarse en esta página.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>9. Jurisdicción</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Estos términos se rigen por las leyes del Estado Libre Asociado de Puerto Rico. Cualquier controversia se someterá a los tribunales del Tribunal General de Justicia de Puerto Rico.</p><!-- /wp:paragraph -->
HTML;
    }

    private function cookie_content(): string {
        return <<<'HTML'
<!-- wp:heading --><h2>1. ¿Qué son las cookies?</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Las cookies son pequeños archivos que el portal almacena en su navegador para recordar preferencias, mantener su sesión o medir el uso del sitio de manera anónima.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>2. Cookies que utilizamos</h2><!-- /wp:heading -->
<!-- wp:table --><figure class="wp-block-table"><table>
<thead><tr><th>Cookie</th><th>Propósito</th><th>Duración</th></tr></thead>
<tbody>
<tr><td>wordpress_logged_in_*</td><td>Mantener la sesión iniciada del estudiante.</td><td>Sesión / 14 días</td></tr>
<tr><td>pll_language</td><td>Recordar el idioma preferido (Polylang).</td><td>1 año</td></tr>
<tr><td>cst_consent_v1 (localStorage)</td><td>Recordar su elección sobre cookies analíticas.</td><td>Hasta que la elimine</td></tr>
</tbody>
</table></figure><!-- /wp:table -->

<!-- wp:heading --><h2>3. Cookies analíticas (opcionales)</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Si usted acepta cookies analíticas mediante el banner del portal, podremos medir el tráfico de forma agregada y anónima. Si no las acepta, no se activarán scripts de seguimiento de terceros.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>4. Cómo gestionar sus cookies</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Puede borrar las cookies y el almacenamiento local desde la configuración de su navegador en cualquier momento. Al volver al portal, le presentaremos nuevamente el banner de consentimiento.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>5. Más información</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Consulte también nuestra <a href="/politica-de-privacidad/">Política de Privacidad</a> o escríbanos a <a href="mailto:comunicaciones@cst.pr.gov">comunicaciones@cst.pr.gov</a>.</p><!-- /wp:paragraph -->
HTML;
    }

    private function accessibility_content(): string {
        return <<<'HTML'
<!-- wp:heading --><h2>Compromiso</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>La Comisión para la Seguridad en el Tránsito (CST) se compromete a hacer este portal accesible para todas las personas, incluidas aquellas con discapacidades, conforme a la <strong>Ley 229 de 2003</strong> del Estado Libre Asociado de Puerto Rico, las Pautas de Accesibilidad para el Contenido Web (<strong>WCAG 2.1 nivel AA</strong>) y la Sección 508 del Acta de Rehabilitación de los Estados Unidos.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Estado de cumplimiento</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Este portal cumple <strong>parcialmente</strong> con el nivel AA de las WCAG 2.1. Las excepciones se documentan más abajo y se trabajan en un plan de remediación activo.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Características de accesibilidad implementadas</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li>Navegación completa por teclado con indicadores de foco visibles.</li>
<li>Atajos ARIA en menús, formularios y el chatbot.</li>
<li>Contraste de color verificado (mínimo 4.5:1 para texto normal).</li>
<li>Respeto a la preferencia <em>prefers-reduced-motion</em>.</li>
<li>Selector de idioma español / inglés.</li>
<li>Tamaño de objetivo táctil mínimo de 44×44 px.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>Limitaciones conocidas</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li>Algunos documentos PDF descargables aún no cumplen con el estándar PDF/UA.</li>
<li>El contenido del curso en inglés está en proceso de revisión por traductor profesional.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>Reportar barreras de accesibilidad</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Si encuentra una barrera de accesibilidad en este portal, contacte a <a href="mailto:comunicaciones@cst.pr.gov">comunicaciones@cst.pr.gov</a>. Le responderemos en un plazo de 10 días laborables. Si no recibe respuesta satisfactoria, puede escalarlo ante la <a href="https://accesibilidad.pr.gov" target="_blank" rel="noopener noreferrer">Oficina de Accesibilidad de Puerto Rico</a>.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Auditoría</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>La última auditoría externa de accesibilidad se documenta en el archivo CST-Cannabis-Portal-ADA-Audit-Report.pdf disponible bajo solicitud a Comunicaciones.</p><!-- /wp:paragraph -->
HTML;
    }
}
