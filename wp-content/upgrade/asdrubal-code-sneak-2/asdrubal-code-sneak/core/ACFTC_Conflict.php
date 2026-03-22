<?php
// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Gestiona el conflicto cuando hay más de una versión del plugin activada simultáneamente
 */
class ACFTC_Conflict {

	/**
	 * Basenames de las versiones del plugin que pueden entrar en conflicto
	 */
	private array $basenames = [
		'acf-theme-code/acf_theme_code.php',
	];

	public function __construct() {

		deactivate_plugins( $this->basenames );

		$error_message  = '<p>';
		$error_message .= wp_kses(
			__( 'Parece que tienes más de una versión del plugin <strong>Asdrubal Custom Fields: Theme Code</strong> activada. Para evitar conflictos, <strong>todas las versiones</strong> del plugin han sido desactivadas.', 'acf-theme-code' ),
			[ 'strong' => [] ]
		);
		$error_message .= '</p>';
		$error_message .= '<p><strong>' . esc_html__( 'Por favor, activa únicamente la versión que quieras usar.', 'acf-theme-code' ) . '</strong></p>';

		wp_die(
			$error_message,
			esc_html__( 'Conflicto de plugin detectado', 'acf-theme-code' ),
			[
				'link_url'  => admin_url( 'plugins.php' ),
				'link_text' => esc_html__( '« Gestionar plugins', 'acf-theme-code' ),
				'response'  => 200,
			]
		);

	}

}