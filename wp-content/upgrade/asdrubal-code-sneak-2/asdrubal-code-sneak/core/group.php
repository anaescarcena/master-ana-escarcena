<?php
// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Clase para la funcionalidad de grupo de campos
 *
 * Compatible con ACF (Free y Pro) y SCF (Secure Custom Fields).
 * Ambos almacenan campos en la tabla 'posts' con el post type 'acf-field'.
 */
class ACFTC_Group {

	/**
	 * ID del grupo de campos (para consultar sus campos)
	 */
	private ?int $id = null;

	/**
	 * Array de campos del grupo (WP_Post objects)
	 */
	public array $fields = [];

	/**
	 * Nivel de anidamiento:
	 *   0 = sin anidar
	 *   1 = dentro de un repeater/group
	 *   2 = dos niveles de profundidad, etc.
	 */
	public int $nesting_level = 0;

	/**
	 * Número de tabulaciones de indentación del grupo
	 */
	public int $indent_count = 0;

	/**
	 * Excluir wrappers HTML (útil para debug)
	 */
	private bool $exclude_html_wrappers = false;

	/**
	 * Si el grupo es un campo clone
	 */
	public bool $clone = false;

	/**
	 * Grupo padre si este grupo es un clone
	 */
	public ?ACFTC_Group $clone_parent_acftc_group = null;

	/**
	 * Parámetro de la regla de ubicación (ej. 'post', 'page', 'block')
	 */
	public string $location_rule_param = '';

	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Constructor
	 *
	 * @param array $args {
	 *   @type int|null      $field_group_id           ID del grupo de campos
	 *   @type array|null    $fields                   Campos ya obtenidos (para sub-grupos)
	 *   @type int           $nesting_level            Nivel de anidamiento
	 *   @type int           $indent_count             Sangría del código generado
	 *   @type string        $location_rule_param      Parámetro de ubicación
	 *   @type ACFTC_Group|null $clone_parent_acftc_group Grupo padre si es clone
	 *   @type bool          $exclude_html_wrappers    Excluir wrappers HTML
	 * }
	 */
	public function __construct( array $args = [] ) {

		$defaults = [
			'field_group_id'           => null,
			'fields'                   => null,
			'nesting_level'            => 0,
			'indent_count'             => 0,
			'location_rule_param'      => '',
			'clone_parent_acftc_group' => null,
			'exclude_html_wrappers'    => false,
		];

		$args = array_merge( $defaults, $args );

		// Se requiere o bien un ID de grupo o bien un array de campos
		if ( empty( $args['field_group_id'] ) && empty( $args['fields'] ) ) {
			return;
		}

		// Campos ya provistos (sub-grupos, repeaters, etc.)
		if ( ! empty( $args['fields'] ) && is_array( $args['fields'] ) ) {
			$this->fields = $args['fields'];
		}
		// Obtener campos por ID de grupo
		elseif ( ! empty( $args['field_group_id'] ) ) {
			$this->id     = (int) $args['field_group_id'];
			$this->fields = $this->get_fields();
		}

		$this->nesting_level            = (int) $args['nesting_level'];
		$this->indent_count             = (int) $args['indent_count'];
		$this->location_rule_param      = (string) $args['location_rule_param'];
		$this->clone_parent_acftc_group = $args['clone_parent_acftc_group'];
		$this->exclude_html_wrappers    = (bool) $args['exclude_html_wrappers'];

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Obtención de campos
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Obtiene todos los campos del grupo desde la tabla 'posts'.
	 *
	 * ACF 5+, ACF Pro y SCF almacenan campos como posts de tipo 'acf-field',
	 * hijos del post del grupo de campos, ordenados por menu_order.
	 *
	 * @return array WP_Post[]
	 */
	private function get_fields(): array {

		$query = new WP_Query( [
			'post_type'      => 'acf-field',
			'post_parent'    => $this->id,
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'no_found_rows'  => true, // optimización: no necesitamos paginación
		] );

		return $query->posts;

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Generación de HTML
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Genera el HTML del código de tema para todos los campos del grupo.
	 *
	 * @return string
	 */
	public function get_field_group_html(): string {

		$field_group_html  = '';
		$field_class_name  = ACFTC_Core::$class_prefix . 'Field';

		foreach ( $this->fields as $field_post_obj ) {

			$acftc_field = new $field_class_name( [
				'nesting_level'            => $this->nesting_level,
				'indent_count'             => $this->indent_count,
				'location_rule_param'      => $this->location_rule_param,
				'field_data_obj'           => $field_post_obj,
				'clone_parent_acftc_field' => $this->clone_parent_acftc_group,
				'exclude_html_wrappers'    => $this->exclude_html_wrappers,
			] );

			$field_group_html .= $acftc_field->get_field_html();

		}

		return $field_group_html;

	}

}