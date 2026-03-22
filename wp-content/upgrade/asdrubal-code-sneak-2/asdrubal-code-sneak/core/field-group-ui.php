<?php
// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Componentes de UI para el meta box del grupo de campos
 */
class ACFTC_Field_Group_UI {

	/**
	 * Devuelve el HTML completo del meta box del grupo de campos
	 *
	 * @param  WP_Post $field_group_post_obj
	 * @return string
	 */
	public static function get_field_group_ui_html( WP_Post $field_group_post_obj ): string {

		if ( ! $field_group_post_obj ) {
			return '';
		}

		// Objeto de ubicaciones
		$locations_class_name = ACFTC_Core::$class_prefix . 'Locations';
		$locations_ui         = new $locations_class_name( $field_group_post_obj );

		// Grupo de campos padre
		$parent_field_group = new ACFTC_Group( [
			'field_group_id' => $field_group_post_obj->ID,
		] );

		// Si no hay campos, mostramos aviso
		if ( empty( $parent_field_group->fields ) ) {
			return self::get_empty_field_group_notice_html();
		}

		ob_start(); ?>

		<?php echo $locations_ui->get_location_select_html(); ?>

		<div class="acftc-code-container">
			<?php echo $locations_ui->get_locations_code_html( $parent_field_group ); ?>
		</div>

		<?php
		// Aviso informativo sobre qué plugin de campos está activo
		echo self::get_cf_plugin_notice_html();

		return ob_get_clean();

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Avisos
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Aviso cuando el grupo de campos no tiene campos publicados
	 *
	 * @return string
	 */
	private static function get_empty_field_group_notice_html(): string {

		ob_start(); ?>

		<div class="acftc-notice acftc-notice--empty-field-group">
			<p><?php esc_html_e( 'Para generar el código de tema, crea algunos campos y publica el grupo de campos.', 'acf-theme-code' ); ?></p>
		</div>

		<?php return ob_get_clean();

	}

	/**
	 * Aviso informativo sobre el plugin de campos detectado (ACF o SCF)
	 *
	 * Solo se muestra si la detección es posible, sin ningún call-to-action de pago.
	 *
	 * @return string
	 */
	private static function get_cf_plugin_notice_html(): string {

		$cf = acftc_cf_active();

		if ( ! $cf ) {
			return '';
		}

		$label = match ( $cf ) {
			'scf'   => 'Secure Custom Fields (SCF)',
			default => 'Advanced Custom Fields (ACF)',
		};

		ob_start(); ?>

		<div class="acftc-notice acftc-notice--cf-plugin">
			<p>
				<?php
				printf(
					/* translators: %s: nombre del plugin de campos detectado */
					esc_html__( 'Plugin de campos detectado: %s', 'acf-theme-code' ),
					'<strong>' . esc_html( $label ) . '</strong>'
				);
				?>
			</p>
		</div>

		<?php return ob_get_clean();

	}

}