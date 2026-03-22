<?php
// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Contenido del meta box de Theme Code
 *
 * Compatible con ACF (Free y Pro) y SCF (Secure Custom Fields).
 * Ambos plugins usan el mismo formato de almacenamiento desde la v5.
 */
class ACFTC_Locations {

	/**
	 * ID del post del grupo de campos
	 */
	protected ?int $field_group_post_ID = null;

	/**
	 * Reglas de ubicación del grupo de campos
	 */
	protected array $location_rules = [];

	/**
	 * Ubicaciones excluidas porque controlan visibilidad en el backend,
	 * no son ubicaciones reales de renderizado.
	 */
	private static array $locations_excluded = [
		'user_type', // ACF v4 legacy — se mantiene por si hay datos antiguos en BD
		'ef_user',   // ACF v4 legacy
	];

	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Constructor
	 *
	 * @param WP_Post $field_group_post_obj Post object del grupo de campos ACF/SCF
	 */
	public function __construct( WP_Post $field_group_post_obj ) {

		if ( ! empty( $field_group_post_obj ) ) {
			$this->field_group_post_ID = $field_group_post_obj->ID;
			$this->location_rules      = $this->get_location_rules( $field_group_post_obj );
		}

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Obtención de reglas de ubicación
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Obtiene las reglas de ubicación del grupo de campos.
	 *
	 * Tanto ACF 5+ como SCF almacenan los grupos de campos en la tabla 'posts'
	 * en formato JSON/serializado dentro de post_content.
	 *
	 * @param  WP_Post $field_group_post_obj
	 * @return array
	 */
	private function get_location_rules( WP_Post $field_group_post_obj ): array {

		$location_rules = [];

		// ACF/SCF almacenan el contenido del grupo en post_content.
		// html_entity_decode corrige el problema con 'Disable the visual editor when writing'.
		$content = maybe_unserialize(
			html_entity_decode( $field_group_post_obj->post_content )
		);

		if ( empty( $content['location'] ) || ! is_array( $content['location'] ) ) {
			return $location_rules;
		}

		foreach ( $content['location'] as $location_group ) {
			foreach ( $location_group as $location_rule ) {
				if ( $this->is_included_location_rule( $location_rule ) ) {
					$location_rules[] = $location_rule;
				}
			}
		}

		return $location_rules;

	}

	/**
	 * Determina si una regla de ubicación debe incluirse.
	 * Excluye las que solo controlan visibilidad en el backend.
	 *
	 * @param  array $location_rule
	 * @return bool
	 */
	private function is_included_location_rule( array $location_rule ): bool {
		return ! in_array( $location_rule['param'], self::$locations_excluded, true );
	}

	// ──────────────────────────────────────────────────────────────────────────
	// HTML de ubicaciones
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Devuelve el HTML con el código de todas las ubicaciones
	 *
	 * @param  ACFTC_Group $parent_field_group
	 * @return string
	 */
	public function get_locations_code_html( ACFTC_Group $parent_field_group ): string {

		if ( ! $parent_field_group ) {
			return '';
		}

		ob_start();

		// Sin ubicaciones detectadas → renderizamos los campos sin wrapper de ubicación
		if ( empty( $this->location_rules ) ) {
			echo $parent_field_group->get_field_group_html();
		} else {
			foreach ( $this->location_rules as $index => $location_rule ) {
				echo $this->get_single_location_html( $location_rule, $index );
			}
		}

		return ob_get_clean();

	}

	/**
	 * Devuelve el HTML para una ubicación individual
	 *
	 * @param  array $location_rule  [ param, operator, value ]
	 * @param  int   $index          Identificador de la ubicación
	 * @return string
	 */
	protected function get_single_location_html( array $location_rule, int $index ): string {

		$args = [
			'field_group_id'      => $this->field_group_post_ID,
			'location_rule_param' => $location_rule['param'],
		];

		$parent_field_group = new ACFTC_Group( $args );

		ob_start();
		?>
		<div id="acftc-group-<?php echo esc_attr( $index ); ?>" class="location-wrap">
			<?php echo $parent_field_group->get_field_group_html(); ?>
		</div>
		<?php

		return ob_get_clean();

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Selector de ubicación
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Devuelve el selector de ubicación (solo si hay más de una)
	 *
	 * @return string
	 */
	public function get_location_select_html(): string {

		if ( count( $this->location_rules ) <= 1 ) {
			return '';
		}

		ob_start(); ?>

		<div class="acftc-location-settings">
			<div class="acftc-location-settings__inside">
				<div class="acf-field acf-field-select" data-name="style" data-type="select">
					<div class="acf-label">
						<label for="acftc-group-option">
							<?php esc_html_e( 'Ubicación', 'acf-theme-code' ); ?>
						</label>
						<?php echo $this->get_location_select_instructions_html(); ?>
					</div>
					<div class="acf-input">
						<select
							id="acftc-group-option"
							data-ui="0"
							data-ajax="0"
							data-multiple="0"
							data-allow_null="0"
							data-placeholder="<?php esc_attr_e( 'Seleccionar', 'acf-theme-code' ); ?>"
						>
							<?php foreach ( $this->location_rules as $key => $location_rule ) : ?>
								<option value="acftc-group-<?php echo esc_attr( $key ); ?>">
									<?php echo esc_html( $this->get_location_clean_text( $location_rule ) ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<?php return ob_get_clean();

	}

	/**
	 * Devuelve las instrucciones del selector de ubicación.
	 * Usa el tooltip de ACF 6+ o el texto plano para versiones anteriores.
	 *
	 * @return string
	 */
	public function get_location_select_instructions_html(): string {

		$tooltip_text = esc_attr__( 'Selecciona una ubicación para ver el código de tema correspondiente', 'acf-theme-code' );

		ob_start();

		if ( version_compare( ACFTC_Core::$acf_version, '6', '<' ) ) : ?>

			<p class="description">
				<?php esc_html_e( 'Selecciona una ubicación para ver el código de tema correspondiente', 'acf-theme-code' ); ?>
			</p>

		<?php else : ?>

			<div class="acf-tip">
				<i tabindex="0"
				   class="acf-icon acf-icon-help acf-js-tooltip"
				   title="<?php echo $tooltip_text; ?>">?</i>
			</div>

		<?php endif;

		return ob_get_clean();

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Helpers de texto
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Formatea el texto de una regla de ubicación en Title Case legible
	 *
	 * @param  array $location_rule  [ param, operator, value ]
	 * @return string
	 */
	private function get_location_clean_text( array $location_rule ): string {

		if ( empty( $location_rule ) ) {
			return '';
		}

		$param_title = ucwords( str_replace( '_', ' ', $location_rule['param'] ) );

		$value_raw   = $location_rule['value'] ?? '';
		$value_clean = empty( $value_raw )
			? 'unknown'
			: ucwords( str_replace(
				[ '-', 'category:', 'acf/' ],
				[ ' ', '',          ''     ],
				$value_raw
			) );

		$operator_label = ( $location_rule['operator'] === '==' ) ? '' : 'Not ';

		return "{$param_title} ({$operator_label}{$value_clean})";

	}

}