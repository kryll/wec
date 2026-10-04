<?php
/**
 * Plugin Name: WEC Core
 * Description: Funcionalidad propia de Welcome English Centre: CPTs (Cursos, Talleres), campos ACF, shortcodes de listado y rol de gestor de contenido.
 * Version: 1.0.0
 * Author: Welcome English Centre
 * Text Domain: wec-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ------------------------------------------------------------------
 * CPT: Curso
 * ------------------------------------------------------------------
 */
function wec_register_cpt_curso() {
	$labels = array(
		'name'               => 'Cursos',
		'singular_name'      => 'Curso',
		'menu_name'          => 'Cursos',
		'name_admin_bar'     => 'Curso',
		'add_new'            => 'Añadir nuevo',
		'add_new_item'       => 'Añadir nuevo curso',
		'new_item'           => 'Nuevo curso',
		'edit_item'          => 'Editar curso',
		'view_item'          => 'Ver curso',
		'all_items'          => 'Todos los cursos',
		'search_items'       => 'Buscar cursos',
		'not_found'          => 'No se encontraron cursos',
		'not_found_in_trash' => 'No se encontraron cursos en la papelera',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-welcome-learn-more',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'cursos', 'with_front' => false ),
		'capability_type'    => array( 'curso', 'cursos' ),
		'map_meta_cap'       => true,
		'show_in_menu'       => true,
		'show_ui'            => true,
	);

	register_post_type( 'curso', $args );
}
add_action( 'init', 'wec_register_cpt_curso' );

/**
 * ------------------------------------------------------------------
 * CPT: Taller
 * ------------------------------------------------------------------
 */
function wec_register_cpt_taller() {
	$labels = array(
		'name'               => 'Talleres',
		'singular_name'      => 'Taller',
		'menu_name'          => 'Talleres',
		'name_admin_bar'     => 'Taller',
		'add_new'            => 'Añadir nuevo',
		'add_new_item'       => 'Añadir nuevo taller',
		'new_item'           => 'Nuevo taller',
		'edit_item'          => 'Editar taller',
		'view_item'          => 'Ver taller',
		'all_items'          => 'Todos los talleres',
		'search_items'       => 'Buscar talleres',
		'not_found'          => 'No se encontraron talleres',
		'not_found_in_trash' => 'No se encontraron talleres en la papelera',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'talleres', 'with_front' => false ),
		'capability_type'    => array( 'taller', 'talleres' ),
		'map_meta_cap'       => true,
		'show_in_menu'       => true,
		'show_ui'            => true,
	);

	register_post_type( 'taller', $args );
}
add_action( 'init', 'wec_register_cpt_taller' );

/**
 * ------------------------------------------------------------------
 * ACF Field Groups (registrados en código para reproducibilidad)
 * ------------------------------------------------------------------
 */
function wec_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// ---- Campos: Curso ----
	acf_add_local_field_group( array(
		'key'      => 'group_wec_curso',
		'title'    => 'Datos del Curso',
		'fields'   => array(
			array(
				'key'   => 'field_wec_curso_nombre',
				'label' => 'Nombre del curso',
				'name'  => 'nombre_del_curso',
				'type'  => 'text',
			),
			array(
				'key'           => 'field_wec_curso_nivel',
				'label'         => 'Nivel',
				'name'          => 'nivel',
				'type'          => 'select',
				'choices'       => array(
					'infantil' => 'Infantil',
					'a1'       => 'A1',
					'a2'       => 'A2',
					'b1'       => 'B1',
					'b2'       => 'B2',
					'c1'       => 'C1',
					'c2'       => 'C2',
				),
				'allow_null'    => 0,
				'multiple'      => 0,
				'ui'            => 1,
			),
			array(
				'key'   => 'field_wec_curso_edad',
				'label' => 'Edad orientativa',
				'name'  => 'edad_orientativa',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wec_curso_horario',
				'label' => 'Horario',
				'name'  => 'horario',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wec_curso_precio',
				'label' => 'Precio',
				'name'  => 'precio',
				'type'  => 'number',
			),
			array(
				'key'   => 'field_wec_curso_duracion',
				'label' => 'Duración',
				'name'  => 'duracion',
				'type'  => 'text',
			),
			array(
				'key'      => 'field_wec_curso_profesor',
				'label'    => 'Profesor asignado',
				'name'     => 'profesor_asignado',
				'type'     => 'text',
				'required' => 0,
			),
			array(
				'key'   => 'field_wec_curso_descripcion',
				'label' => 'Descripción',
				'name'  => 'descripcion',
				'type'  => 'wysiwyg',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'curso',
				),
			),
		),
	) );

	// ---- Campos: Taller ----
	acf_add_local_field_group( array(
		'key'      => 'group_wec_taller',
		'title'    => 'Datos del Taller',
		'fields'   => array(
			array(
				'key'   => 'field_wec_taller_nombre',
				'label' => 'Nombre del taller',
				'name'  => 'nombre_del_taller',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wec_taller_descripcion_pedagogica',
				'label' => 'Descripción pedagógica',
				'name'  => 'descripcion_pedagogica',
				'type'  => 'wysiwyg',
			),
			array(
				'key'   => 'field_wec_taller_edades',
				'label' => 'Edades / cursos a los que va dirigido',
				'name'  => 'edades_cursos_dirigido',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wec_taller_duracion',
				'label' => 'Duración del taller',
				'name'  => 'duracion_taller',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wec_taller_precio_alumno',
				'label' => 'Precio por alumno',
				'name'  => 'precio_alumno',
				'type'  => 'number',
			),
			array(
				'key'   => 'field_wec_taller_precio_grupo',
				'label' => 'Precio por grupo',
				'name'  => 'precio_grupo',
				'type'  => 'number',
			),
			array(
				'key'   => 'field_wec_taller_galeria',
				'label' => 'Galería de fotos',
				'name'  => 'galeria_fotos',
				'type'  => 'gallery',
			),
			array(
				'key'   => 'field_wec_taller_colegios',
				'label' => 'Colegios donde se ha impartido',
				'name'  => 'colegios_impartido',
				'type'  => 'textarea',
				'instructions' => 'Un colegio por línea.',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'taller',
				),
			),
		),
	) );
}
add_action( 'acf/init', 'wec_register_acf_fields' );

/**
 * ------------------------------------------------------------------
 * Google Fonts de marca (Libre Baskerville + Montserrat)
 * ------------------------------------------------------------------
 */
function wec_enqueue_brand_fonts() {
	wp_enqueue_style(
		'wec-google-fonts',
		'https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Montserrat:wght@400;500;600;700&family=Archivo+Black&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'wec_enqueue_brand_fonts' );

/**
 * ------------------------------------------------------------------
 * Shortcodes de listado
 * ------------------------------------------------------------------
 */
/**
 * ------------------------------------------------------------------
 * Clases de registro B2C/B2B en <body> según la página
 * Útil para que las plantillas de contenido puedan escribir reglas
 * CSS como `body.wec-registry-b2b .mi-seccion { ... }` sin tener que
 * repetir el chequeo de slug en cada página.
 * ------------------------------------------------------------------
 */
function wec_body_registry_classes( $classes ) {
	if ( is_page( 'academia-de-ingles' ) || is_singular( 'curso' ) ) {
		$classes[] = 'wec-registry-b2c';
	}
	if ( is_page( 'talleres-para-colegios' ) || is_singular( 'taller' ) ) {
		$classes[] = 'wec-registry-b2b';
	}
	return $classes;
}
add_filter( 'body_class', 'wec_body_registry_classes' );

function wec_cursos_listado_shortcode() {
	$query = new WP_Query( array(
		'post_type'      => 'curso',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );

	if ( ! $query->have_posts() ) {
		return '<p>Próximamente nuevos cursos.</p>';
	}

	$choices = array(
		'infantil' => 'Infantil',
		'a1'       => 'A1',
		'a2'       => 'A2',
		'b1'       => 'B1',
		'b2'       => 'B2',
		'c1'       => 'C1',
		'c2'       => 'C2',
	);

	ob_start();
	echo '<div class="wec-listado wec-listado-cursos">';
	while ( $query->have_posts() ) {
		$query->the_post();
		$nivel_raw = get_field( 'nivel' );
		$nivel     = isset( $choices[ $nivel_raw ] ) ? $choices[ $nivel_raw ] : $nivel_raw;
		$precio    = get_field( 'precio' );
		echo '<div class="wec-listado-item wec-curso-item" data-nivel="' . esc_attr( $nivel_raw ? $nivel_raw : 'sin-nivel' ) . '">';
		echo '<div class="wec-item-media">';
		if ( has_post_thumbnail() ) {
			echo get_the_post_thumbnail( get_the_ID(), 'medium_large', array( 'class' => 'wec-item-img', 'loading' => 'lazy' ) );
		} else {
			echo '<div class="wec-item-img wec-item-img-placeholder" aria-hidden="true"></div>';
		}
		if ( $nivel_raw ) {
			echo '<span class="wec-nivel-badge wec-nivel-' . esc_attr( $nivel_raw ) . '">' . esc_html( $nivel ) . '</span>';
		}
		echo '</div>';
		echo '<div class="wec-item-body">';
		echo '<h3 class="wec-item-title">' . esc_html( get_the_title() ) . '</h3>';
		if ( $precio ) {
			echo '<p class="wec-item-precio"><span class="wec-item-precio-value">' . esc_html( $precio ) . ' €</span></p>';
		}
		echo '<p class="wec-item-cta"><a class="wec-item-link" href="' . esc_url( get_permalink() ) . '">Ver más &rarr;</a></p>';
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'wec_cursos_listado', 'wec_cursos_listado_shortcode' );

function wec_talleres_listado_shortcode() {
	$query = new WP_Query( array(
		'post_type'      => 'taller',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );

	if ( ! $query->have_posts() ) {
		return '<p>Próximamente nuevos talleres.</p>';
	}

	ob_start();
	echo '<div class="wec-listado wec-listado-talleres">';
	while ( $query->have_posts() ) {
		$query->the_post();
		$edades = get_field( 'edades_cursos_dirigido' );
		$precio_alumno = get_field( 'precio_alumno' );
		echo '<div class="wec-listado-item wec-taller-item">';
		echo '<div class="wec-item-media">';
		if ( has_post_thumbnail() ) {
			echo get_the_post_thumbnail( get_the_ID(), 'medium_large', array( 'class' => 'wec-item-img', 'loading' => 'lazy' ) );
		} else {
			echo '<div class="wec-item-img wec-item-img-placeholder" aria-hidden="true"></div>';
		}
		echo '</div>';
		echo '<div class="wec-item-body">';
		echo '<h3 class="wec-item-title">' . esc_html( get_the_title() ) . '</h3>';
		if ( $edades ) {
			echo '<p class="wec-item-edades"><strong>Dirigido a:</strong> ' . esc_html( $edades ) . '</p>';
		}
		if ( $precio_alumno ) {
			echo '<p class="wec-item-precio"><span class="wec-item-precio-value">' . esc_html( $precio_alumno ) . ' €</span> <span class="wec-item-precio-label">/ alumno</span></p>';
		}
		echo '<p class="wec-item-cta"><a class="wec-item-link" href="' . esc_url( get_permalink() ) . '">Ver más &rarr;</a></p>';
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'wec_talleres_listado', 'wec_talleres_listado_shortcode' );

/**
 * ------------------------------------------------------------------
 * Rol personalizado: Gestor de Contenido
 * ------------------------------------------------------------------
 */
function wec_add_gestor_contenido_role() {
	remove_role( 'gestor_contenido' );

	add_role(
		'gestor_contenido',
		'Gestor de Contenido',
		array(
			'read'                   => true,
			'edit_posts'             => true,
			'edit_published_posts'   => true,
			'publish_posts'          => true,
			'delete_posts'           => true,
			'upload_files'           => true,

			'edit_curso'             => true,
			'edit_cursos'            => true,
			'edit_others_cursos'     => true,
			'publish_cursos'         => true,
			'edit_published_cursos'  => true,

			'edit_taller'            => true,
			'edit_talleres'          => true,
			'edit_others_talleres'   => true,
			'publish_talleres'       => true,
			'edit_published_talleres' => true,
		)
	);
}
register_activation_hook( __FILE__, 'wec_add_gestor_contenido_role' );

function wec_deactivate() {
	remove_role( 'gestor_contenido' );
}
// Nota: no eliminamos el rol en desactivación para no perder asignaciones accidentalmente.

/**
 * ------------------------------------------------------------------
 * Header sticky: añade .is-scrolled a #masthead al hacer scroll
 * ------------------------------------------------------------------
 * Selector real servido por Kadence: <header id="masthead" class="site-header">
 * Los estilos de ambos estados (arriba/transparente vs scrolled/blanco
 * con sombra) viven en el CSS de marca (post 28, Additional CSS).
 */
function wec_enqueue_header_scroll_script() {
	wp_register_script( 'wec-header-scroll', false, array(), '1.0.0', true );
	wp_enqueue_script( 'wec-header-scroll' );
	wp_add_inline_script(
		'wec-header-scroll',
		"(function(){
			var header = document.getElementById('masthead');
			if (!header) { return; }
			var THRESHOLD = 40;
			function onScroll() {
				if (window.scrollY > THRESHOLD) {
					header.classList.add('is-scrolled');
				} else {
					header.classList.remove('is-scrolled');
				}
			}
			onScroll();
			window.addEventListener('scroll', onScroll, { passive: true });
		})();"
	);
}
add_action( 'wp_enqueue_scripts', 'wec_enqueue_header_scroll_script' );

/**
 * ------------------------------------------------------------------
 * Banner de cookies minimalista (RGPD) — sin plugin externo
 * ------------------------------------------------------------------
 * Solo informativo por ahora: no se carga ningún script de analítica
 * condicionado a la aceptación (GA4 no está conectado todavía). Usa
 * localStorage para no volver a mostrarse tras la primera aceptación.
 * Enlaza a /politica-de-privacidad/ (la creará otro agente más adelante).
 */
function wec_cookie_banner_markup() {
	$privacy_url = home_url( '/politica-de-privacidad/' );
	?>
	<div id="wec-cookie-banner" role="dialog" aria-live="polite" aria-label="Aviso de cookies" hidden>
		<p>
			Usamos cookies técnicas necesarias para el funcionamiento de la web.
			Consulta nuestra <a href="<?php echo esc_url( $privacy_url ); ?>">política de privacidad</a>.
		</p>
		<button type="button" class="wec-cookie-accept">Aceptar</button>
	</div>
	<script>
	(function () {
		try {
			var KEY = 'wec_cookie_consent';
			if (localStorage.getItem(KEY)) { return; }
			var banner = document.getElementById('wec-cookie-banner');
			if (!banner) { return; }
			banner.removeAttribute('hidden');
			var btn = banner.querySelector('.wec-cookie-accept');
			btn.addEventListener('click', function () {
				try { localStorage.setItem(KEY, '1'); } catch (e) {}
				banner.setAttribute('hidden', '');
			});
		} catch (e) {
			/* localStorage no disponible (modo privado, etc.): no mostramos el banner. */
		}
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'wec_cookie_banner_markup' );

/**
 * ==================================================================
 * --- FAQ Schema (Academia) ---
 * Añadido de forma aislada por el agente de contenido de Academia de
 * Inglés / Talleres para Colegios. No modifica nada de lo anterior.
 * Imprime JSON-LD schema.org FAQPage SOLO en la página
 * "academia-de-ingles" (slug), replicando las preguntas del acordeón
 * (bloques nativos wp:details) de esa página. Preguntas hardcodeadas
 * a propósito: si se edita el contenido del acordeón en el editor,
 * hay que actualizar también este array para mantenerlos en sync.
 * ==================================================================
 */
function wec_academia_faq_schema() {
	if ( ! is_page( 'academia-de-ingles' ) ) {
		return;
	}

	$faqs = array(
		array(
			'q' => '¿Cuál es el precio de las clases de inglés?',
			'a' => 'El precio depende del curso y del número de horas semanales. Puedes consultar las tarifas orientativas en la sección de precios de esta página, y te confirmamos el importe exacto al reservar tu clase de prueba.',
		),
		array(
			'q' => '¿A partir de qué edad se pueden apuntar los niños?',
			'a' => 'Tenemos grupos desde infantil (3-5 años) hasta adultos, pasando por primaria, secundaria y bachillerato. Cada grupo se adapta a la edad y al nivel del alumnado.',
		),
		array(
			'q' => '¿Cómo sé en qué nivel debo matricularme?',
			'a' => 'En la clase de prueba gratuita realizamos una breve evaluación oral y escrita para recomendarte el grupo y nivel (A1 a C2) que mejor se ajusta a tu punto de partida.',
		),
		array(
			'q' => '¿La clase de prueba es realmente gratuita?',
			'a' => 'Sí. La primera clase de prueba no tiene ningún coste ni compromiso de continuidad. Es una forma de que conozcas al profesorado y la metodología antes de matricularte.',
		),
		array(
			'q' => '¿Qué horarios tenéis disponibles?',
			'a' => 'Contamos con horarios de tarde de lunes a viernes para niños y adolescentes, y franjas de mañana y tarde para adultos. Consulta la disponibilidad concreta de cada curso en el listado de cursos.',
		),
		array(
			'q' => '¿En qué consiste vuestra metodología?',
			'a' => 'Combinamos práctica oral constante, grupos reducidos, profesorado nativo y cualificado, y preparación específica para certificaciones oficiales de Cambridge, siempre en un ambiente cercano y motivador.',
		),
	);

	$items = array();
	foreach ( $faqs as $faq ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $items,
	);

	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
}
add_action( 'wp_head', 'wec_academia_faq_schema' );

/**
 * ==================================================================
 * Página 404 personalizada
 * Engancha a template_redirect, fuerza el código 404 real y pinta
 * contenido propio envuelto en el header/footer de Kadence.
 * ==================================================================
 */
function wec_custom_404() {
	if ( ! is_404() ) {
		return;
	}

	status_header( 404 );
	nocache_headers();

	get_header();
	?>
	<div class="wp-block-group alignfull wec-section-light" style="padding-top:4rem;padding-bottom:4rem">
		<div class="wp-block-group" style="max-width:640px;margin:0 auto;padding:0 1.5rem;text-align:center">
			<h1 class="wp-block-heading">Página no encontrada</h1>
			<p style="font-size:1.1rem">
				Vaya, parece que esta página se ha ido de excursión y no ha vuelto. Puede que el enlace esté desactualizado o que la dirección tenga una errata. Pero tranquilo, el resto de Welcome English Centre sigue aquí, esperándote.
			</p>
			<div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;margin-top:2rem">
				<a class="btn-b2c-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Volver a Inicio</a>
				<a class="btn-b2c-ghost" href="<?php echo esc_url( home_url( '/academia-de-ingles/' ) ); ?>">Ver Academia de Inglés</a>
			</div>
		</div>
	</div>
	<?php
	get_footer();
	exit;
}
add_action( 'template_redirect', 'wec_custom_404' );

/**
 * ==================================================================
 * ContactPoint Schema
 * JSON-LD schema.org en la página de Contacto: Organization con
 * ContactPoint anidado (teléfono, email, tipo de contacto, área
 * atendida). El teléfono es un PLACEHOLDER: +34 941 000 000 — hay
 * que sustituirlo por el número real de la academia.
 * ==================================================================
 */
function wec_contact_point_schema() {
	if ( ! is_page( 'contacto' ) ) {
		return;
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Organization',
		'name'        => 'Welcome English Centre',
		'url'         => home_url( '/' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Av. Solidaridad, 64, bajo 2',
			'addressLocality' => 'Logroño',
			'addressRegion'   => 'La Rioja',
			'postalCode'      => '26003',
			'addressCountry'  => 'ES',
		),
		'contactPoint' => array(
			'@type'       => 'ContactPoint',
			'telephone'   => '+34 941 000 000',
			'email'       => 'jose.amezcua.inf@gmail.com',
			'contactType' => 'customer service',
			'areaServed'  => 'ES',
		),
	);

	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
}
add_action( 'wp_head', 'wec_contact_point_schema' );

/**
 * ==================================================================
 * Blog: color por categoría + tiempo de lectura en el listado
 * - post_class añade wec-cat-academia / wec-cat-colegios al <article>
 *   según la categoría del post, para poder colorear la tarjeta.
 * - CSS mínimo solo en la página de archivo del blog (is_home()),
 *   no toca el CSS global del post 28.
 * - Tiempo de lectura estimado (palabras / 200 wpm) añadido al
 *   extracto del listado. Kadence ya muestra autor y fecha de serie,
 *   así que solo se añade lo que falta (no se duplica nada).
 * ==================================================================
 */
function wec_post_class_by_category( $classes ) {
	if ( ! is_singular( 'post' ) && ! is_home() && ! is_archive() ) {
		return $classes;
	}
	if ( has_category( 'academia' ) ) {
		$classes[] = 'wec-cat-academia';
	}
	if ( has_category( 'colegios' ) ) {
		$classes[] = 'wec-cat-colegios';
	}
	return $classes;
}
add_filter( 'post_class', 'wec_post_class_by_category' );

function wec_blog_archive_inline_css() {
	if ( ! is_home() && ! is_archive() ) {
		return;
	}
	?>
	<style>
		article.wec-cat-academia { border-left: 4px solid var(--b2c-cta, #E66852); }
		article.wec-cat-colegios { border-left: 4px solid var(--b2b-primary, #162638); }
		.wec-reading-time { display: block; font-size: 0.85rem; opacity: 0.75; margin-top: 0.4rem; }
	</style>
	<?php
}
add_action( 'wp_head', 'wec_blog_archive_inline_css' );

function wec_reading_time_excerpt( $excerpt ) {
	if ( ( is_home() || is_archive() ) && in_the_loop() && is_main_query() ) {
		$word_count  = str_word_count( wp_strip_all_tags( get_the_content() ) );
		$reading_min = max( 1, (int) ceil( $word_count / 200 ) );
		$excerpt    .= '<span class="wec-reading-time">Tiempo de lectura estimado: ' . $reading_min . ' min</span>';
	}
	return $excerpt;
}
add_filter( 'the_excerpt', 'wec_reading_time_excerpt' );
