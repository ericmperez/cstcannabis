<?php
/**
 * WP-CLI: Seed the Cannabis Medicinal y Seguridad Vial course with mockup content.
 *
 * Usage: wp eval-file wp-content/plugins/cst-core/cli/seed-course.php
 *
 * @package CST_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return;
}

WP_CLI::log( '🌿 Seeding Cannabis Medicinal y Seguridad Vial course...' );

/* ======================================================================
   Course (ID 10)
   ====================================================================== */

$course_id = 10;

$course_content = <<<'HTML'
<!-- wp:paragraph -->
<p>Este curso gratuito de la <strong>Comisión para la Seguridad en el Tránsito (CST)</strong> provee información esencial sobre el cannabis medicinal y su impacto en la conducción vehicular en Puerto Rico. Aprenderás sobre el marco legal vigente, los efectos en la capacidad de conducir, los protocolos de seguridad vial, tus derechos y responsabilidades, y las estrategias de prevención comunitaria.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>¿A quién va dirigido?</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>Pacientes con licencia de cannabis medicinal que conducen vehículos</li>
<li>Profesionales de la salud que recetan cannabis medicinal</li>
<li>Conductores que desean conocer sobre el impacto del cannabis en la seguridad vial</li>
<li>Agentes del orden y profesionales de seguridad pública</li>
<li>Cualquier ciudadano interesado en la educación vial responsable</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3>Estructura del curso</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>El curso se compone de <strong>5 módulos</strong> con un total de <strong>10 lecciones</strong>. Cada lección incluye contenido informativo, datos estadísticos y recomendaciones prácticas. Al completar todos los módulos, recibirás un <strong>certificado digital verificable</strong> con código QR, válido por 90 días.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Requisitos</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>No se requieren conocimientos previos</li>
<li>Acceso a computadora, tableta o celular con conexión a internet</li>
<li>Tiempo estimado: 2-3 horas (a tu propio ritmo)</li>
</ul>
<!-- /wp:list -->
HTML;

wp_update_post( [
    'ID'           => $course_id,
    'post_title'   => 'Cannabis Medicinal y Seguridad Vial',
    'post_content' => $course_content,
    'post_excerpt' => 'Curso educativo gratuito de la CST sobre el uso responsable del cannabis medicinal y su impacto en la seguridad vial. 5 módulos, 10 lecciones, certificado digital.',
    'post_status'  => 'publish',
] );

// Course meta (Tutor LMS).
update_post_meta( $course_id, '_tutor_course_settings', [
    'maximum_students'  => 0,
    'content_drip_type' => '',
] );
update_post_meta( $course_id, '_course_duration', [
    'hours'   => 2,
    'minutes' => 30,
    'seconds' => 0,
] );
update_post_meta( $course_id, '_tutor_course_level', 'beginner' );
update_post_meta( $course_id, '_tutor_course_benefits', implode( "\n", [
    'Comprender el marco legal del cannabis medicinal en Puerto Rico',
    'Conocer los efectos del cannabis en la capacidad de conducción',
    'Aplicar protocolos de seguridad vial como paciente de cannabis',
    'Entender tus derechos y responsabilidades bajo la ley vigente',
    'Obtener un certificado digital verificable al completar el curso',
] ) );
update_post_meta( $course_id, '_tutor_course_requirements', implode( "\n", [
    'Acceso a internet y dispositivo (computadora, tableta o celular)',
    'No se requieren conocimientos previos',
] ) );
update_post_meta( $course_id, '_tutor_course_target_audience', implode( "\n", [
    'Pacientes con licencia de cannabis medicinal',
    'Conductores en Puerto Rico',
    'Profesionales de la salud',
    'Agentes del orden público',
] ) );
update_post_meta( $course_id, '_tutor_course_material_includes', implode( "\n", [
    '10 lecciones en 5 módulos temáticos',
    'Datos estadísticos de Puerto Rico',
    'Guías prácticas descargables',
    'Evaluación final con retroalimentación',
    'Certificado digital con código QR',
] ) );

WP_CLI::success( "Course #{$course_id} updated." );

/* ======================================================================
   Lessons Content — keyed by existing post ID
   ====================================================================== */

$lessons = [

    /* --- Módulo 1: Marco Legal del Cannabis Medicinal --- */

    16 => [
        'title'   => 'Introducción a la Ley de Cannabis Medicinal',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Ley 42-2017: Cannabis Medicinal en Puerto Rico</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>El 9 de julio de 2017, el Gobernador de Puerto Rico firmó la <strong>Ley 42-2017</strong>, conocida como la "Ley para Manejar el Estudio, Desarrollo e Investigación del Cannabis para la Innovación, Normas Aplicables y Límites" (Ley MEDICINAL). Esta ley establece el marco regulatorio para el uso medicinal del cannabis en la isla.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Aspectos clave de la Ley 42-2017</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Autorización:</strong> Permite el uso, posesión y adquisición de cannabis medicinal por pacientes autorizados con una licencia válida expedida por el Departamento de Salud.</li>
<li><strong>Condiciones cualificantes:</strong> Incluyen cáncer, epilepsia, esclerosis múltiple, enfermedad de Parkinson, fibromialgia, artritis, VIH/SIDA, PTSD, enfermedad de Crohn, Alzheimer, entre otras condiciones aprobadas.</li>
<li><strong>Límites de posesión:</strong> Los pacientes pueden poseer hasta 2.5 onzas (71 gramos) de cannabis para un período de 30 días.</li>
<li><strong>Prohibiciones:</strong> Fumar cannabis sigue siendo ilegal; el consumo se limita a aceites, tinturas, cápsulas, vaporizadores y otros métodos aprobados.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Junta Reglamentadora de Cannabis Medicinal</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>La <strong>Junta Reglamentadora de Cannabis Medicinal</strong>, adscrita al Departamento de Salud, es responsable de supervisar la industria, otorgar licencias a dispensarios, cultivadores y manufactureros, y garantizar el cumplimiento de los estándares de calidad y seguridad.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--info"} -->
<p class="cst-callout cst-callout--info"><strong>Dato importante:</strong> Para el 2024, Puerto Rico cuenta con más de 130,000 pacientes registrados de cannabis medicinal, lo que representa aproximadamente el 4% de la población adulta de la isla.</p>
<!-- /wp:paragraph -->
HTML,
    ],

    17 => [
        'title'   => 'Regulaciones y permisos',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Proceso para obtener una licencia de cannabis medicinal</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Para utilizar cannabis medicinal legalmente en Puerto Rico, debes completar un proceso regulado por el Departamento de Salud. A continuación se detallan los pasos necesarios:</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Paso 1: Evaluación médica</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Un médico autorizado debe evaluar tu condición de salud y determinar si cualificas para el uso de cannabis medicinal. El médico debe estar registrado en el sistema del Departamento de Salud como proveedor de recomendaciones de cannabis medicinal.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Paso 2: Registro en el sistema</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Con la recomendación médica, debes registrarte en el portal del Departamento de Salud y completar la solicitud de licencia de paciente. Se requiere:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Identificación válida con foto (licencia de conducir o Real ID)</li>
<li>Prueba de residencia en Puerto Rico</li>
<li>Recomendación médica vigente</li>
<li>Pago de la tarifa correspondiente</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Paso 3: Recibir la licencia</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Una vez aprobada la solicitud, recibirás una <strong>tarjeta de identificación de paciente</strong> que debes llevar contigo al adquirir y transportar cannabis medicinal. Esta licencia es válida por un año y debe renovarse antes de su vencimiento.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Restricciones importantes para conductores</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--warning"} -->
<p class="cst-callout cst-callout--warning"><strong>Atención:</strong> Poseer una licencia de cannabis medicinal <strong>no</strong> te exime de las leyes de tránsito. Conducir bajo los efectos del cannabis es ilegal bajo la Ley 22-2000 (Ley de Vehículos y Tránsito) y puede resultar en multas, suspensión de licencia y cargos criminales.</p>
<!-- /wp:paragraph -->
HTML,
    ],

    /* --- Módulo 2: Efectos del Cannabis en la Conducción --- */

    18 => [
        'title'   => 'Efectos cognitivos y motores del cannabis',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>¿Cómo afecta el cannabis la capacidad de conducir?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>El tetrahidrocannabinol (THC), el principal compuesto psicoactivo del cannabis, afecta múltiples funciones cognitivas y motoras que son esenciales para la conducción segura. Es fundamental comprender estos efectos para tomar decisiones responsables.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Efectos cognitivos</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Tiempo de reacción:</strong> El THC aumenta el tiempo de reacción entre un 20% y un 40%, lo que significa que tardarás más en responder a situaciones de emergencia en la carretera.</li>
<li><strong>Atención dividida:</strong> La capacidad de prestar atención a múltiples estímulos simultáneamente (otros vehículos, señales, peatones) se reduce significativamente.</li>
<li><strong>Toma de decisiones:</strong> El juicio y la evaluación de riesgos se ven afectados, pudiendo llevar a decisiones imprudentes al volante.</li>
<li><strong>Memoria a corto plazo:</strong> La dificultad para retener información reciente puede hacer que olvides señales de tránsito o instrucciones de navegación.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Efectos motores</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Coordinación:</strong> La coordinación mano-ojo, esencial para maniobrar el volante, se deteriora.</li>
<li><strong>Control del vehículo:</strong> Se observa mayor dificultad para mantener el carril, especialmente en curvas y maniobras de estacionamiento.</li>
<li><strong>Percepción de distancia:</strong> La habilidad de juzgar distancias entre vehículos y objetos se reduce.</li>
<li><strong>Visión periférica:</strong> El campo visual se estrecha, limitando la detección de peligros laterales.</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--info"} -->
<p class="cst-callout cst-callout--info"><strong>Dato estadístico:</strong> Según estudios del National Highway Traffic Safety Administration (NHTSA), los conductores bajo los efectos del cannabis tienen un 25% más de probabilidad de verse involucrados en un accidente vehicular.</p>
<!-- /wp:paragraph -->
HTML,
    ],

    19 => [
        'title'   => 'Tiempos de espera y seguridad',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>¿Cuánto tiempo esperar antes de conducir?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>No existe un período de espera universalmente seguro, ya que los efectos del cannabis varían según la persona, el método de consumo, la dosis y la tolerancia individual. Sin embargo, las siguientes son guías generales basadas en investigaciones científicas:</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Según el método de consumo</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Inhalación (vaporización):</strong> Los efectos psicoactivos comienzan en minutos y pueden durar de 2 a 4 horas. Se recomienda esperar un <strong>mínimo de 6 horas</strong> antes de conducir.</li>
<li><strong>Aceites y tinturas (sublingual):</strong> Los efectos comienzan en 15-45 minutos y duran de 4 a 6 horas. Se recomienda esperar un <strong>mínimo de 8 horas</strong>.</li>
<li><strong>Cápsulas y comestibles:</strong> Los efectos pueden tardar de 30 minutos a 2 horas en comenzar y durar de 6 a 12 horas. Se recomienda esperar un <strong>mínimo de 12 horas</strong>.</li>
<li><strong>Tópicos (cremas, ungüentos):</strong> Generalmente no producen efectos psicoactivos y no afectan la capacidad de conducir.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Factores que afectan la duración</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Concentración de THC:</strong> Productos con mayor concentración de THC producen efectos más intensos y prolongados.</li>
<li><strong>Peso corporal y metabolismo:</strong> Personas con menor peso corporal o metabolismo más lento pueden experimentar efectos más prolongados.</li>
<li><strong>Tolerancia:</strong> Aunque usuarios frecuentes pueden desarrollar tolerancia, esto no significa que sus capacidades de conducción no estén afectadas.</li>
<li><strong>Interacción con medicamentos:</strong> Otros medicamentos pueden potenciar o prolongar los efectos del cannabis.</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--warning"} -->
<p class="cst-callout cst-callout--warning"><strong>Regla de oro:</strong> Si sientes <em>cualquier</em> efecto del cannabis — por mínimo que sea — <strong>no conduzcas</strong>. Utiliza alternativas seguras: transporte público, servicio de taxi/plataforma, o pide que alguien más conduzca.</p>
<!-- /wp:paragraph -->
HTML,
    ],

    /* --- Módulo 3: Protocolos de Seguridad Vial --- */

    20 => [
        'title'   => 'Fiscalización y puntos de control',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>¿Qué ocurre en un punto de control vehicular?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>La Policía de Puerto Rico y la CST realizan regularmente puntos de control vehicular (checkpoints) como parte de los esfuerzos de seguridad vial. Es importante conocer tus derechos y el procedimiento que siguen los agentes.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Procedimiento de los agentes</h4>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol>
<li><strong>Detención y observación:</strong> El agente te solicitará licencia de conducir, registro del vehículo y marbete vigente. Durante esta interacción, observará señales de impedimento.</li>
<li><strong>Señales de sospecha:</strong> Ojos enrojecidos, pupilas dilatadas, olor a cannabis, habla lenta, tiempo de reacción reducido, o comportamiento errático pueden llevar a una evaluación adicional.</li>
<li><strong>Pruebas de sobriedad de campo (FST):</strong> Si hay sospecha, el agente puede solicitar pruebas como caminar en línea recta, pararse en un pie, o seguir un objeto con los ojos.</li>
<li><strong>Drug Recognition Expert (DRE):</strong> En casos de sospecha confirmada, un agente certificado como DRE puede realizar una evaluación más detallada de 12 pasos.</li>
</ol>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Tu licencia de cannabis medicinal en un punto de control</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Si eres paciente de cannabis medicinal y transportas producto legalmente:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Lleva siempre tu <strong>tarjeta de paciente</strong> vigente</li>
<li>El cannabis debe estar en su <strong>envase original</strong> del dispensario autorizado</li>
<li>Mantén el producto en un <strong>compartimiento cerrado</strong> (guantera, baúl)</li>
<li>Tener cannabis medicinal <strong>no te autoriza a conducir bajo sus efectos</strong></li>
</ul>
<!-- /wp:list -->
HTML,
    ],

    21 => [
        'title'   => 'Pruebas de detección y procedimientos',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Métodos de detección de cannabis en conductores</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A diferencia del alcohol, que se mide con precisión mediante el análisis de aliento (breathalyzer), la detección de cannabis presenta desafíos únicos. Comprender los métodos utilizados te ayudará a conocer el proceso legal.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Pruebas utilizadas en Puerto Rico</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Prueba de saliva (oral fluid):</strong> Detecta uso reciente de cannabis (últimas 24-48 horas). Es la prueba más común en puntos de control por su rapidez.</li>
<li><strong>Análisis de sangre:</strong> Mide la concentración de THC en sangre. Es más precisa pero requiere extracción en un centro médico. Valores superiores a 5 ng/mL de THC en sangre se consideran indicativos de impedimento.</li>
<li><strong>Análisis de orina:</strong> Detecta metabolitos de THC, pero no indica impedimento actual. El THC puede permanecer detectable en orina por semanas en usuarios regulares.</li>
<li><strong>Evaluación DRE (Drug Recognition Expert):</strong> Evaluación física y conductual realizada por agentes especializados que incluye observación de pupilas, presión arterial, temperatura y coordinación.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Consecuencias legales por conducir bajo efectos del cannabis</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Primera ofensa:</strong> Multa de $300-$500, suspensión de licencia por 30 días, asistencia obligatoria a programa de educación vial.</li>
<li><strong>Segunda ofensa:</strong> Multa de $500-$1,000, suspensión de licencia por 90 días, posible arresto.</li>
<li><strong>Tercera ofensa o más:</strong> Cargos criminales, revocación de licencia por 1 año, posible encarcelamiento.</li>
<li><strong>Si resulta en accidente con lesiones:</strong> Cargos graves que pueden incluir negligencia criminal.</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--info"} -->
<p class="cst-callout cst-callout--info"><strong>Importante:</strong> Tu licencia de cannabis medicinal no es una defensa legal contra cargos por conducir impedido. La ley trata la conducción bajo efectos del cannabis de manera similar a la conducción bajo efectos del alcohol.</p>
<!-- /wp:paragraph -->
HTML,
    ],

    /* --- Módulo 4: Derechos y Responsabilidades --- */

    22 => [
        'title'   => 'Derechos del paciente de cannabis medicinal',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Tus derechos como paciente registrado</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Como paciente de cannabis medicinal con licencia vigente en Puerto Rico, la ley te protege con una serie de derechos fundamentales. Conocerlos es esencial para ejercerlos adecuadamente.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Derechos principales</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Acceso al tratamiento:</strong> Derecho a adquirir cannabis medicinal en dispensarios autorizados según la recomendación de tu médico.</li>
<li><strong>Protección laboral limitada:</strong> Aunque la ley prohíbe la discriminación laboral por ser paciente de cannabis medicinal, los empleadores pueden mantener políticas de lugar de trabajo libre de drogas en posiciones de seguridad.</li>
<li><strong>Privacidad médica:</strong> Tu condición de paciente es información médica protegida bajo HIPAA y la Ley 39-2012 de privacidad de Puerto Rico.</li>
<li><strong>Transporte legal:</strong> Puedes transportar cannabis medicinal en tu vehículo siempre que esté en su envase original y no lo consumas mientras conduces.</li>
<li><strong>Protección contra arresto:</strong> No puedes ser arrestado por posesión de cannabis medicinal dentro de los límites legales (2.5 oz / 30 días) si portas tu tarjeta de paciente vigente.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Situaciones donde tus derechos tienen límites</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>No puedes consumir cannabis en lugares públicos ni en vehículos</li>
<li>No puedes compartir o vender tu cannabis medicinal a otras personas</li>
<li>Las pruebas de detección positivas durante la conducción son procesables legalmente</li>
<li>Propiedades federales (instalaciones militares, edificios federales) no reconocen la ley de cannabis medicinal de PR</li>
</ul>
<!-- /wp:list -->
HTML,
    ],

    23 => [
        'title'   => 'Responsabilidades como conductor',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Tu responsabilidad como paciente y conductor</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ser paciente de cannabis medicinal y conductor conlleva una doble responsabilidad: manejar tu tratamiento adecuadamente y garantizar que tu conducción sea segura en todo momento.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Plan de seguridad personal</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Todo paciente de cannabis medicinal que conduce debe tener un plan de seguridad que incluya:</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol>
<li><strong>Conoce tu producto:</strong> Familiarízate con la concentración de THC y CBD de tu producto, el método de consumo y cómo te afecta personalmente.</li>
<li><strong>Planifica tu consumo:</strong> Programa el uso de cannabis medicinal en horarios donde no necesites conducir. Consumir antes de dormir es una estrategia segura.</li>
<li><strong>Ten alternativas de transporte:</strong> Mantén una lista de contactos para transporte alternativo — familiares, amigos, servicios de taxi, Uber/plataformas.</li>
<li><strong>Comunica con tu médico:</strong> Informa a tu médico si conduces regularmente. Puede ajustar la dosis, el producto o el horario de administración.</li>
<li><strong>Auto-evaluación honesta:</strong> Antes de conducir, pregúntate: "¿Siento algún efecto?" Si la respuesta es sí o "no estoy seguro", no conduzcas.</li>
</ol>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>En caso de accidente</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Si estás involucrado en un accidente de tránsito y eres paciente de cannabis medicinal:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Coopera con las autoridades y presenta tu documentación</li>
<li>No ofrezcas información sobre tu uso de cannabis voluntariamente</li>
<li>Tienes derecho a consultar con un abogado antes de someterte a pruebas</li>
<li>Si te solicitan prueba de sangre, es tu derecho conocer los resultados</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--warning"} -->
<p class="cst-callout cst-callout--warning"><strong>Recuerda:</strong> La mejor estrategia legal es la prevención. Si no consumiste cannabis recientemente, no tendrás que preocuparte por los resultados de ninguna prueba.</p>
<!-- /wp:paragraph -->
HTML,
    ],

    /* --- Módulo 5: Prevención y Educación Comunitaria --- */

    24 => [
        'title'   => 'Estrategias de prevención comunitaria',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Prevención: una responsabilidad compartida</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>La prevención de accidentes relacionados con la conducción bajo efectos del cannabis no recae únicamente en el individuo. Es una responsabilidad compartida entre pacientes, familias, comunidades, profesionales de la salud y las agencias gubernamentales.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Estrategias a nivel individual</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Conductor designado:</strong> Así como se designa un conductor cuando se consume alcohol, establece un sistema similar para días de uso de cannabis medicinal.</li>
<li><strong>Almacenamiento responsable:</strong> Guarda el cannabis en un lugar seguro y fuera del alcance de otros, especialmente menores.</li>
<li><strong>Registro de consumo:</strong> Mantén un diario de cuándo consumes, qué producto usas y cuándo te sientes completamente apto para conducir.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Estrategias a nivel comunitario</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Educación entre pares:</strong> Comparte esta información con otros pacientes de cannabis medicinal en tu comunidad.</li>
<li><strong>Apoyo familiar:</strong> Involucra a tu familia en tu plan de seguridad vial. Ellos pueden ser tus primeros aliados.</li>
<li><strong>Dispensarios como educadores:</strong> Los dispensarios tienen la responsabilidad de informar a los pacientes sobre seguridad vial al momento de la compra.</li>
<li><strong>Campañas comunitarias:</strong> Participa en las campañas de seguridad vial de la CST y comparte materiales educativos.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Recursos de la CST</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>La Comisión para la Seguridad en el Tránsito ofrece los siguientes recursos gratuitos:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Materiales educativos descargables sobre cannabis y seguridad vial</li>
<li>Charlas comunitarias (solicita una para tu organización)</li>
<li>Línea de información: 787-721-4142</li>
<li>Correo electrónico: comunicaciones@cst.pr.gov</li>
</ul>
<!-- /wp:list -->
HTML,
    ],

    25 => [
        'title'   => 'Recursos y apoyo disponible',
        'content' => <<<'HTML'
<!-- wp:heading {"level":3} -->
<h3>Directorio de recursos en Puerto Rico</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A continuación encontrarás un directorio de recursos gubernamentales y comunitarios relacionados con el cannabis medicinal y la seguridad vial en Puerto Rico.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Agencias gubernamentales</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Comisión para la Seguridad en el Tránsito (CST):</strong> 787-721-4142 | comunicaciones@cst.pr.gov</li>
<li><strong>Departamento de Salud — Junta de Cannabis Medicinal:</strong> 787-765-2929</li>
<li><strong>Departamento de Transportación y Obras Públicas (DTOP):</strong> 787-729-8989</li>
<li><strong>CESCO (Centros de Servicios al Conductor):</strong> 787-777-7777</li>
<li><strong>Policía de Puerto Rico — División de Tránsito:</strong> 787-343-2020</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Líneas de ayuda</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Línea PAS (Primera Ayuda Sicosocial):</strong> 1-800-981-0023 (24/7)</li>
<li><strong>ASSMCA (Administración de Servicios de Salud Mental y Contra la Adicción):</strong> 787-763-7575</li>
<li><strong>Emergencias:</strong> 911</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Próximos pasos</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Completar este curso es solo el primer paso hacia una conducción más segura. Te recomendamos:</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol>
<li>Revisar periódicamente las actualizaciones de la legislación de cannabis medicinal</li>
<li>Mantener comunicación abierta con tu médico sobre tu tratamiento</li>
<li>Compartir lo aprendido con familiares y compañeros pacientes</li>
<li>Guardar este certificado como evidencia de tu compromiso con la seguridad vial</li>
</ol>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"cst-callout cst-callout--info"} -->
<p class="cst-callout cst-callout--info"><strong>¡Felicitaciones!</strong> Al completar este curso, demuestras tu compromiso con la seguridad vial y el uso responsable del cannabis medicinal. Tu certificado digital será enviado a tu correo electrónico una vez completes la evaluación final.</p>
<!-- /wp:paragraph -->
HTML,
    ],
];

foreach ( $lessons as $id => $data ) {
    wp_update_post( [
        'ID'           => $id,
        'post_title'   => $data['title'],
        'post_content' => $data['content'],
        'post_status'  => 'publish',
    ] );
    WP_CLI::log( "  ✓ Lesson #{$id}: {$data['title']}" );
}

/* ======================================================================
   Topic (Module) ordering — ensure menu_order is set
   ====================================================================== */

$topic_order = [ 11, 12, 13, 14, 15 ];
foreach ( $topic_order as $i => $topic_id ) {
    wp_update_post( [
        'ID'         => $topic_id,
        'menu_order' => $i + 1,
    ] );
}

WP_CLI::success( 'All 10 lessons seeded with mockup content. Course is ready.' );
