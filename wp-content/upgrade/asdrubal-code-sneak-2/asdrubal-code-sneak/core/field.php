<?php
// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Clase para la funcionalidad de campo individual
 *
 * Compatible con ACF (Free y Pro) y SCF (Secure Custom Fields).
 */
class ACFTC_Field {

	protected ?string $render_partial = null;

	protected int    $nesting_level = 0;
	protected int    $indent_count  = 0;
	protected string $indent        = '';

	protected bool   $exclude_html_wrappers = false;

	protected string $quick_link_id          = '';
	protected string $the_field_method        = 'the_field';
	protected string $get_field_method        = 'get_field';
	protected string $get_field_object_method = 'get_field_object';

	protected ?int   $id    = null; // Requerido para flexible layouts
	protected string $label = '';
	protected string $name  = '';
	protected string $type  = '';
	protected string $var_name = '';

	/**
	 * Datos completos del campo sin serializar.
	 * Public para permitir acceso desde ACFTC_Group.
	 */
	public array $settings = [];

	protected string $location_rule_param     = ''; // ej. 'post', 'page', 'block'
	protected string $location_rendered_param = ''; // ej. ", 'option'"

	protected bool $clone = false;

	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Constructor
	 *
	 * @param array $args {
	 *   @type int    $nesting_level            Nivel de anidamiento
	 *   @type int    $indent_count             Sangría del código generado
	 *   @type string $location_rule_param      Parámetro de ubicación
	 *   @type mixed  $field_data_obj           WP_Post del campo (posts table)
	 *   @type mixed  $clone_parent_acftc_field Campo padre si es clone
	 *   @type bool   $exclude_html_wrappers    Excluir wrappers HTML
	 * }
	 */
	public function __construct( array $args = [] ) {

		$defaults = [
			'nesting_level'            => 0,
			'indent_count'             => 0,
			'location_rule_param'      => '',
			'field_data_obj'           => null,
			'clone_parent_acftc_field' => null,
			'exclude_html_wrappers'    => false,
		];

		$args = array_merge( $defaults, $args );

		$this->nesting_level = (int) $args['nesting_level'];
		$this->indent_count  = (int) $args['indent_count'];

		$this->location_rule_param     = (string) $args['location_rule_param'];
		$this->location_rendered_param = $this->get_location_rendered_param();

		// Cadena de sangría
		$this->indent = $this->get_indent();

		// Si el campo está anidado, usar métodos de sub campo
		if ( $this->nesting_level > 0 ) {
			$this->the_field_method        = 'the_sub_field';
			$this->get_field_method        = 'get_sub_field';
			$this->get_field_object_method = 'get_sub_field_object';
		}

		// Construir desde la tabla posts (ACF 5+ / SCF)
		$this->construct_from_posts_table( $args['field_data_obj'] );

		// Nombre de variable para el código generado
		$this->var_name = $this->get_var_name( $this->name );

		// Campos clone: ajustar nombre si tiene prefijo
		if ( $args['clone_parent_acftc_field'] ) {

			$this->clone          = true;
			$clone_settings       = $args['clone_parent_acftc_field']->settings;
			$this->location_rule_param = (string) $args['location_rule_param'];

			if ( ! empty( $clone_settings['prefix_name'] ) && 1 === (int) $clone_settings['prefix_name'] ) {
				$this->name = $args['clone_parent_acftc_field']->name . '_' . $this->name;
			}

		}

		// Partial de renderizado
		$this->render_partial = $this->get_render_partial();

		$this->exclude_html_wrappers = (bool) $args['exclude_html_wrappers'];

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Construcción desde tabla posts
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Inicializa las propiedades del campo a partir de un WP_Post de tipo 'acf-field'.
	 *
	 * ACF 5+, ACF Pro y SCF almacenan los campos en la tabla posts.
	 * El contenido del campo viene en post_content serializado.
	 *
	 * @param WP_Post|null $field_data_obj
	 */
	private function construct_from_posts_table( ?WP_Post $field_data_obj ): void {

		if ( empty( $field_data_obj ) ) {
			return;
		}

		$this->settings = (array) maybe_unserialize( $field_data_obj->post_content );

		$this->id    = (int) $field_data_obj->ID;
		$this->label = (string) $field_data_obj->post_title;
		$this->name  = (string) $field_data_obj->post_excerpt;
		$this->type  = (string) ( $this->settings['type'] ?? '' );

		// ID de acceso rápido solo en campos raíz (no anidados)
		if ( $this->nesting_level === 0 ) {
			$this->quick_link_id = (string) $this->id;
		}

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Helpers de formato
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Genera la cadena de tabulaciones para el nivel de indentación actual
	 *
	 * @return string
	 */
	private function get_indent(): string {

		return str_repeat( "\t", $this->indent_count );

	}

	/**
	 * Convierte el nombre del campo en un nombre de variable PHP válido
	 *
	 * @param  string $name
	 * @return string
	 */
	private function get_var_name( string $name ): string {

		// Guiones → guiones bajos
		$var_name = str_replace( '-', '_', $name );

		// Caracteres especiales → guiones bajos
		$var_name = preg_replace( '/[^A-Za-z0-9_]/', '_', $var_name );

		// Múltiples guiones bajos seguidos → uno solo
		$var_name = preg_replace( '/_+/', '_', $var_name );

		return $var_name;

	}

	/**
	 * Devuelve el parámetro de ubicación que se incluirá en el código generado.
	 * Ej: para 'options_page' devuelve ", 'option'"
	 *
	 * @return string
	 */
	protected function get_location_rendered_param(): string {

		return ( $this->location_rule_param === 'options_page' ) ? ", 'option'" : '';

	}

	/**
	 * Devuelve la ruta al partial de renderizado para este tipo de campo.
	 *
	 * Si el tipo es básico, usa render/basic.php.
	 * Si tiene partial propio, usa render/{type}.php.
	 *
	 * @return string|null
	 */
	protected function get_render_partial(): ?string {

		if ( empty( $this->type ) ) {
			return null;
		}

		if ( in_array( $this->type, ACFTC_Core::$field_types_basic, true ) ) {
			return ACFTC_PLUGIN_DIR_PATH . 'render/basic.php';
		}

		return ACFTC_PLUGIN_DIR_PATH . 'render/' . $this->type . '.php';

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Comprobaciones
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Comprueba si el tipo de campo está en la lista de ignorados
	 *
	 * @param  string $field_type
	 * @return bool
	 */
	protected function is_ignored_field_type( string $field_type = '' ): bool {
		return in_array( $field_type, ACFTC_Core::$ignored_field_types, true );
	}

	/**
	 * Comprueba si el modo debug está activo (?debug=on en la URL)
	 *
	 * @return bool
	 */
	private function is_debugging(): bool {

		if ( ! isset( $_GET['debug'] ) ) {
			return false;
		}

		return sanitize_key( $_GET['debug'] ) === 'on';

	}

	/**
	 * Determina si el campo necesita wrapper HTML (solo campos raíz no clone)
	 *
	 * @return bool
	 */
	private function needs_html_wrapper(): bool {
		return ( $this->nesting_level === 0 && ! $this->clone );
	}

	// ──────────────────────────────────────────────────────────────────────────
	// Generación de HTML
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Devuelve el HTML del título del bloque de código del campo
	 *
	 * @return string
	 */
	private function get_field_html_title(): string {

		ob_start();

		if ( $this->is_debugging() ) {

			echo htmlspecialchars( '<h3>Debug: ' . $this->label . '</h3>' );

		} else {
			?>
			<span
				class="acftc-field-meta__title"
				data-type="<?php echo esc_attr( $this->type ); ?>"
				data-pseudo-content="<?php echo esc_attr( $this->label ); ?>"
			></span>
			<?php
		}

		return ob_get_clean();

	}

	/**
	 * Devuelve el HTML del cuerpo del bloque de código del campo.
	 * Incluye el partial correspondiente o muestra un mensaje de error si no existe.
	 *
	 * @return string
	 */
	protected function get_field_html_body(): string {

		ob_start();

		if ( $this->render_partial && file_exists( $this->render_partial ) ) {

			include $this->render_partial;

		} else {

			// Tipo de campo no soportado
			$error_message_1 = sprintf(
				/* translators: %s: Tipo de campo */
				__( 'El tipo de campo `%s` no está soportado en esta versión del plugin.', 'acf-theme-code' ),
				$this->type
			);
			$error_message_2 = sprintf(
				/* translators: %s: URL del autor */
				__( 'Contacta con %s para solicitar soporte para este tipo de campo.', 'acf-theme-code' ),
				ACFTC_AUTHOR_URL
			);

			echo $this->indent . htmlspecialchars( "<?php // {$error_message_1} ?>\n" );
			echo $this->indent . htmlspecialchars( "<?php // {$error_message_2} ?>\n" );

		}

		return ob_get_clean();

	}

	/**
	 * Devuelve el HTML completo del campo (wrapper + título + código)
	 *
	 * @return string
	 */
	public function get_field_html(): string {

		if ( empty( $this->type ) || $this->is_ignored_field_type( $this->type ) ) {
			return '';
		}

		ob_start();

		if ( $this->needs_html_wrapper() && ! $this->exclude_html_wrappers ) {
			?>
			<div class="acftc-field-meta">
				<?php echo $this->get_field_html_title(); ?>
			</div>
			<div class="acftc-field-code" id="acftc-<?php echo esc_attr( $this->quick_link_id ); ?>">
				<a href="#"
				   class="acftc-field__copy acf-js-tooltip"
				   title="<?php esc_attr_e( 'Copiar al portapapeles', 'acf-theme-code' ); ?>">
				</a>
				<pre class="line-numbers"><code class="language-php"><?php echo $this->get_field_html_body(); ?></code></pre>
			</div>
			<?php
		} else {

			echo $this->get_field_html_body();

		}

		return ob_get_clean();

	}

}