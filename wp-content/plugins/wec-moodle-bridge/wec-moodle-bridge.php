<?php
/**
 * Plugin Name: WEC Moodle Bridge
 * Description: Muestra el catálogo de cursos de Welcome English Centre leyéndolo en vivo desde el Campus Online (Moodle) vía Web Services, mediante el shortcode [wec_moodle_cursos]. Si no hay token configurado, muestra un CTA al Campus Online.
 * Version: 1.0.0
 * Author: Welcome English Centre
 * Text Domain: wec-moodle-bridge
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WEC_MOODLE_BRIDGE_WWWROOT_DEFAULT', 'https://wec-acad.jamezcuarodriguez.es' );
define( 'WEC_MOODLE_BRIDGE_TRANSFER_FILE', '/var/www/vhosts/wec.jamezcuarodriguez.es/moodle-integration.json' );
define( 'WEC_MOODLE_BRIDGE_CACHE_KEY', 'wec_moodle_cursos_cache' );
define( 'WEC_MOODLE_BRIDGE_CACHE_TTL', HOUR_IN_SECONDS );

/**
 * ------------------------------------------------------------------
 * Activación: lee el archivo de traspaso una vez y guarda sus datos
 * como opciones de WordPress (no hardcodeadas en el código).
 * ------------------------------------------------------------------
 */
function wec_moodle_bridge_activate() {
	wec_moodle_bridge_import_transfer_file();
}
register_activation_hook( __FILE__, 'wec_moodle_bridge_activate' );

/**
 * Lee (si existe) el JSON de traspaso generado por la integración de Moodle
 * y guarda wwwroot / token / endpoint como opciones de WordPress.
 *
 * @return bool true si se importaron datos válidos.
 */
function wec_moodle_bridge_import_transfer_file() {
	if ( ! file_exists( WEC_MOODLE_BRIDGE_TRANSFER_FILE ) || ! is_readable( WEC_MOODLE_BRIDGE_TRANSFER_FILE ) ) {
		return false;
	}

	$raw = file_get_contents( WEC_MOODLE_BRIDGE_TRANSFER_FILE );
	if ( empty( $raw ) ) {
		return false;
	}

	$data = json_decode( $raw, true );
	if ( empty( $data ) || empty( $data['ws_token'] ) ) {
		return false;
	}

	update_option( 'wec_moodle_ws_token', sanitize_text_field( $data['ws_token'] ), false );
	update_option( 'wec_moodle_wwwroot', ! empty( $data['wwwroot'] ) ? esc_url_raw( $data['wwwroot'] ) : WEC_MOODLE_BRIDGE_WWWROOT_DEFAULT, false );
	update_option( 'wec_moodle_ws_endpoint', ! empty( $data['ws_rest_endpoint'] ) ? esc_url_raw( $data['ws_rest_endpoint'] ) : trailingslashit( WEC_MOODLE_BRIDGE_WWWROOT_DEFAULT ) . 'webservice/rest/server.php', false );

	return true;
}

/**
 * Devuelve el token de Web Services de Moodle.
 * Prioridad: opción de WordPress guardada; si no existe, intenta
 * leer el archivo de traspaso una vez más (por si apareció después
 * de activar el plugin) y lo guarda como opción.
 */
function wec_moodle_bridge_get_token() {
	$token = get_option( 'wec_moodle_ws_token', '' );
	if ( ! empty( $token ) ) {
		return $token;
	}

	if ( wec_moodle_bridge_import_transfer_file() ) {
		return get_option( 'wec_moodle_ws_token', '' );
	}

	return '';
}

function wec_moodle_bridge_get_wwwroot() {
	$wwwroot = get_option( 'wec_moodle_wwwroot', '' );
	return ! empty( $wwwroot ) ? $wwwroot : WEC_MOODLE_BRIDGE_WWWROOT_DEFAULT;
}

function wec_moodle_bridge_get_endpoint() {
	$endpoint = get_option( 'wec_moodle_ws_endpoint', '' );
	if ( ! empty( $endpoint ) ) {
		return $endpoint;
	}
	return trailingslashit( wec_moodle_bridge_get_wwwroot() ) . 'webservice/rest/server.php';
}

/**
 * Llama a core_course_get_courses en Moodle, con cache de 1 hora via transient.
 *
 * @return array|WP_Error Lista de cursos o WP_Error en caso de fallo.
 */
function wec_moodle_bridge_fetch_courses() {
	$cached = get_transient( WEC_MOODLE_BRIDGE_CACHE_KEY );
	if ( false !== $cached ) {
		return $cached;
	}

	$token = wec_moodle_bridge_get_token();
	if ( empty( $token ) ) {
		return new WP_Error( 'wec_moodle_no_token', 'No hay token de Moodle configurado.' );
	}

	$endpoint = wec_moodle_bridge_get_endpoint();

	$url = add_query_arg(
		array(
			'wstoken'            => $token,
			'wsfunction'         => 'core_course_get_courses',
			'moodlewsrestformat' => 'json',
		),
		$endpoint
	);

	$response = wp_remote_get( $url, array( 'timeout' => 10 ) );

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		return new WP_Error( 'wec_moodle_http_error', 'Moodle respondió con código ' . $code );
	}

	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body, true );

	if ( ! is_array( $data ) || isset( $data['exception'] ) ) {
		$message = isset( $data['message'] ) ? $data['message'] : 'Respuesta inválida de Moodle.';
		return new WP_Error( 'wec_moodle_api_error', $message );
	}

	// El curso "site" (id 1) es el curso raíz del sitio Moodle, no un curso real.
	$courses = array_values(
		array_filter(
			$data,
			function ( $course ) {
				return isset( $course['id'] ) && (int) $course['id'] !== 1;
			}
		)
	);

	set_transient( WEC_MOODLE_BRIDGE_CACHE_KEY, $courses, WEC_MOODLE_BRIDGE_CACHE_TTL );

	return $courses;
}

/**
 * CTA de respaldo hacia el Campus Online, usado cuando no hay token
 * configurado o cuando falla la llamada a la API de Moodle.
 */
function wec_moodle_bridge_fallback_cta( $message = '' ) {
	$wwwroot = esc_url( wec_moodle_bridge_get_wwwroot() );
	$html  = '<div class="wec-moodle-fallback" style="text-align:center;padding:2rem 1rem;">';
	if ( ! empty( $message ) ) {
		$html .= '<p style="opacity:0.75;margin-bottom:1rem;">' . esc_html( $message ) . '</p>';
	}
	$html .= '<div class="wp-block-buttons" style="display:flex;justify-content:center;">';
	$html .= '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . $wwwroot . '" target="_blank" rel="noopener">Ver todos los cursos en nuestro Campus Online &rarr;</a></div>';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}

/**
 * Pinta una tarjeta de curso individual usando la clase global .wec-card.
 */
function wec_moodle_bridge_render_card( $course ) {
	$wwwroot     = wec_moodle_bridge_get_wwwroot();
	$course_id   = isset( $course['id'] ) ? (int) $course['id'] : 0;
	$fullname    = isset( $course['fullname'] ) ? $course['fullname'] : '';
	$summary     = isset( $course['summary'] ) ? wp_strip_all_tags( $course['summary'] ) : '';
	$category    = isset( $course['categoryname'] ) ? $course['categoryname'] : ( isset( $course['coursecategory'] ) ? $course['coursecategory'] : '' );
	$course_url  = trailingslashit( $wwwroot ) . 'course/view.php?id=' . $course_id;

	if ( strlen( $summary ) > 160 ) {
		$summary = substr( $summary, 0, 157 ) . '...';
	}

	ob_start();
	?>
	<div class="wec-card wec-moodle-card" style="display:flex;flex-direction:column;height:100%;">
		<?php if ( ! empty( $category ) ) : ?>
			<span class="wec-badge-verde" style="align-self:flex-start;margin-bottom:0.75rem;"><?php echo esc_html( $category ); ?></span>
		<?php endif; ?>
		<h3 style="margin:0 0 0.5rem;font-family:'Montserrat',sans-serif;color:#1A1A1A;"><?php echo esc_html( $fullname ); ?></h3>
		<?php if ( ! empty( $summary ) ) : ?>
			<p style="flex-grow:1;margin:0 0 1rem;color:#1A1A1A;"><?php echo esc_html( $summary ); ?></p>
		<?php endif; ?>
		<div class="wp-block-buttons" style="margin-top:auto;">
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $course_url ); ?>" target="_blank" rel="noopener">Apúntate en el Campus</a></div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Shortcode [wec_moodle_cursos]: pinta el catálogo de cursos leído de Moodle.
 */
function wec_moodle_bridge_shortcode() {
	$token = wec_moodle_bridge_get_token();

	if ( empty( $token ) ) {
		return wec_moodle_bridge_fallback_cta();
	}

	$courses = wec_moodle_bridge_fetch_courses();

	if ( is_wp_error( $courses ) || empty( $courses ) ) {
		return wec_moodle_bridge_fallback_cta( 'Catálogo no disponible temporalmente.' );
	}

	$html  = '<div class="wec-moodle-cursos-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.5rem;margin:1.5rem 0;">';
	foreach ( $courses as $course ) {
		$html .= wec_moodle_bridge_render_card( $course );
	}
	$html .= '</div>';

	return $html;
}
add_shortcode( 'wec_moodle_cursos', 'wec_moodle_bridge_shortcode' );
