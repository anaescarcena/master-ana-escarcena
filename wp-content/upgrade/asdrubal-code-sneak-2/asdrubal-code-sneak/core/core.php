<?php
// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

final class ACFTC_Core {

	/**
	 * Prefijo de clases (sin versión Pro, siempre ACFTC_)
	 */
	public static string $class_prefix = 'ACFTC_';

	/**
	 * Versión del plugin de campos activo (ACF o SCF)
	 */
	public static ?string $acf_version = null;

	/**
	 * Tabla de base de datos utilizada por ACF/SCF
	 * Desde ACF 5+ siempre es 'posts'
	 */
	public static string $db_table = 'posts';

	/**
	 * Sangría para campos dentro de repeaters y flexible content
	 */
	public static int $indent_repeater         = 2;
	public static int $indent_flexible_content = 3;

	/**
	 * Tipos de campo que se ignoran en la generación de código
	 */
	public static array $ignored_field_types = [
		'tab',
		'message',
		'accordion',
		'enhanced_message',
		'row',
		'page', // Advanced Forms Pro (formularios multi-paso)
	];

	/**
	 * Tipos de campo básicos soportados
	 */
	public static array $field_types_basic = [
		'text',
		'textarea',
		'number',
		'range',
		'email',
		'url',
		'wysiwyg',
		'oembed',
		'date_picker',
		'date_time_picker',
		'time_picker',
		'color_picker',
		// Campos de ACF/SCF sin coste adicional
		'image',
		'file',
		'gallery',
		'select',
		'checkbox',
		'radio',
		'button_group',
		'true_false',
		'link',
		'post_object',
		'page_link',
		'relationship',
		'taxonomy',
		'user',
		'google_map',
		'password',
		// Campos de layout
		'repeater',
		'flexible_content',
		'group',
		'clone',
	];

	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->add_core_actions();
	}

	/**
	 * Registra las acciones y filtros del plugin
	 */
	private function add_core_actions(): void {

		add_action( 'admin_init',             [ $this, 'set_acf_version' ] );
		add_action( 'add_meta_boxes',         [ $this, 'register_meta_boxes' ] );
		add_action( 'admin_enqueue_scripts',  [ $this, 'enqueue' ] );
		add_action( 'admin_init',             [ $this, 'load_textdomain' ] );

		add_filter(
			'postbox_classes_acf-field-group_acftc-meta-box',
			[ $this, 'add_metabox_classes' ]
		);

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Versión y tabla DB
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Detecta la versión del plugin de campos activo (ACF o SCF).
	 *
	 * SCF es un fork de ACF y expone la misma función acf_get_setting(),
	 * por lo que la detección es idéntica para ambos.
	 */
	public function set_acf_version(): void {

		if ( ! acftc_has_cf() ) {
			return;
		}

		if ( function_exists( 'acf_get_setting' ) ) {
			self::$acf_version = acf_get_setting( 'version' );
		}

	}

	// ──────────────────────────────────────────────────────────────────────────
	// Meta box
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Registra el meta box en la pantalla de edición de grupo de campos.
	 *
	 * Tanto ACF como SCF utilizan el post type 'acf-field-group'.
	 */
	public function register_meta_boxes(): void {

		if ( ! acftc_has_cf() ) {
			return;
		}

		add_meta_box(
			'acftc-meta-box',
			__( 'Theme Code', 'acf-theme-code' ),
			[ $this, 'display_callback' ],
			[ 'acf-field-group' ]
		);

	}

	/**
	 * Añade clases CSS al meta box
	 *
	 * @param  array $classes
	 * @return array
	 */
	public function add_metabox_classes( array $classes ): array {

		$cf = acftc_cf_active();

		if ( $cf ) {
			$classes[] = 'acftc-' . $cf . '-meta-box'; // acftc-acf-meta-box | acftc-scf-meta-box
		}

		return $classes;

	}

	/**
	 * Callback de visualización del meta box
	 *
	 * @param WP_Post $field_group_post_obj
	 */
	public function display_callback( WP_Post $field_group_post_obj ): void {
		echo $this->get_meta_box_content_html( $field_group_post_obj );
	}

	/**
	 * Devuelve el HTML del contenido del meta box
	 *
	 * @param  WP_Post $field_group_post_obj
	 * @return string
	 */
	public function get_meta_box_content_html( WP_Post $field_group_post_obj ): string {
		return ACFTC_Field_Group_UI::get_field_group_ui_html( $field_group_post_obj );
	}

	// ──────────────────────────────────────────────────────────────────────────
	// Assets
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Devuelve el nombre del archivo CSS según la versión de ACF/SCF.
	 * ACF/SCF < 6 usa la hoja de estilos legacy.
	 */
	private function get_stylesheet_filename(): string {

		if ( self::$acf_version === null ) {
			return 'acf-theme-code';
		}

		return version_compare( self::$acf_version, '6', '<' )
			? 'acf-theme-code-legacy'
			: 'acf-theme-code';

	}

	/**
	 * Encola estilos y scripts del plugin
	 *
	 * @param string $hook Sufijo de la página actual
	 */
	public function enqueue( string $hook ): void {

		global $post_type, $plugin_page;

		// Tanto ACF como SCF usan el post type 'acf-field-group'
		$en_pantalla_campos = (
			'acf-field-group' === $post_type
			|| 'acf-tools'    === $plugin_page
		);

		if ( ! $en_pantalla_campos ) {
			return;
		}

		$stylesheet = $this->get_stylesheet_filename();

		// Estilos
		wp_enqueue_style(
			'acftc',
			ACFTC_PLUGIN_DIR_URL . "assets/{$stylesheet}.css",
			[],
			ACFTC_PLUGIN_VERSION
		);

		wp_enqueue_style(
			'acftc-prism',
			ACFTC_PLUGIN_DIR_URL . 'assets/prism.css',
			[],
			ACFTC_PLUGIN_VERSION
		);

		// Scripts
		wp_enqueue_script(
			'acftc-prism',
			ACFTC_PLUGIN_DIR_URL . 'assets/prism.js',
			[],
			ACFTC_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
			'acftc-clipboard',
			ACFTC_PLUGIN_DIR_URL . 'assets/clipboard.min.js',
			[],
			'2.0.11',
			true
		);

		wp_enqueue_script(
			'acftc',
			ACFTC_PLUGIN_DIR_URL . 'assets/acf-theme-code.js',
			[ 'wp-i18n', 'jquery', 'acftc-clipboard' ],
			ACFTC_PLUGIN_VERSION,
			true
		);

		// Traducciones JS (WordPress.org se encarga de servirlas)
		wp_set_script_translations( 'acftc', 'acf-theme-code' );

		// Datos disponibles en JS: qué plugin de campos está activo
		wp_localize_script( 'acftc', 'acftcData', [
			'cfPlugin' => acftc_cf_active(), // 'acf' | 'scf' | false
			'version'  => self::$acf_version,
		] );

	}

	// ──────────────────────────────────────────────────────────────────────────
	// i18n
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Carga el textdomain del plugin.
	 * Al estar en WordPress.org, WP lo gestiona automáticamente desde WP 4.6+,
	 * pero lo cargamos manualmente como fallback.
	 */
	public function load_textdomain(): void {

		load_plugin_textdomain(
			'acf-theme-code',
			false,
			dirname( ACFTC_PLUGIN_BASENAME ) . '/languages'
		);

	}

}