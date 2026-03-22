<?php
/**
 * Plugin Name:       Asdrubal Custom Fields: Theme Code
 * Plugin URI:        https://asdrubalseo.com/software/
 * Description:       Genera código de tema para grupos de campos de ACF / SCF para acelerar el desarrollo.
 * Version:           3.0.0
 * Author:            Asdrubal SEO
 * Author URI:        https://asdrubalseo.com
 * Text Domain:       acf-theme-code
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */

// Salir si se accede directamente
if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_admin() ) {

	if ( ! class_exists( 'ACFTC_Core' ) ) {

		// ── Constantes ──────────────────────────────────────────────────────────
		defined( 'ACFTC_PLUGIN_VERSION' )   or define( 'ACFTC_PLUGIN_VERSION',   '3.0.0' );
		defined( 'ACFTC_PLUGIN_DIR_PATH' )  or define( 'ACFTC_PLUGIN_DIR_PATH',  plugin_dir_path( __FILE__ ) );
		defined( 'ACFTC_PLUGIN_DIR_URL' )   or define( 'ACFTC_PLUGIN_DIR_URL',   plugin_dir_url( __FILE__ ) );
		defined( 'ACFTC_PLUGIN_BASENAME' )  or define( 'ACFTC_PLUGIN_BASENAME',  plugin_basename( __FILE__ ) );
		defined( 'ACFTC_PLUGIN_FILE' )      or define( 'ACFTC_PLUGIN_FILE',      __FILE__ );
		defined( 'ACFTC_AUTHOR_URL' )       or define( 'ACFTC_AUTHOR_URL',       'https://asdrubalseo.com' );

		// ── Detección ACF / SCF ─────────────────────────────────────────────────
		// Ambos plugins exponen la misma API (get_field, have_rows, etc.).
		// Detectamos cuál está activo para mostrarlo en la UI si fuera necesario.
		// 'acf'  → Advanced Custom Fields  (advanced-custom-fields/acf.php  o  advanced-custom-fields-pro/acf.php)
		// 'scf'  → Secure Custom Fields     (secure-custom-fields/acf.php)
		// false  → ninguno activo

		/**
		 * Devuelve 'acf', 'scf' o false según el plugin de campos activo.
		 *
		 * @return string|false
		 */
		function acftc_cf_active(): string|false {
			if ( ! function_exists( 'acf' ) ) {
				return false;
			}
			$active_plugins = (array) get_option( 'active_plugins', [] );
			// Red/Multisite
			if ( is_multisite() ) {
				$active_plugins = array_merge(
					$active_plugins,
					array_keys( (array) get_site_option( 'active_sitewide_plugins', [] ) )
				);
			}
			foreach ( $active_plugins as $plugin ) {
				if ( str_contains( $plugin, 'secure-custom-fields' ) ) {
					return 'scf';
				}
			}
			return 'acf';
		}

		/**
		 * Comprueba si hay algún plugin de campos compatible activo.
		 *
		 * @return bool
		 */
		function acftc_has_cf(): bool {
			return acftc_cf_active() !== false;
		}

		// ── Archivos core ───────────────────────────────────────────────────────
		require_once ACFTC_PLUGIN_DIR_PATH . 'core/core.php';
		require_once ACFTC_PLUGIN_DIR_PATH . 'core/field-group-ui.php';
		require_once ACFTC_PLUGIN_DIR_PATH . 'core/locations.php';
		require_once ACFTC_PLUGIN_DIR_PATH . 'core/group.php';
		require_once ACFTC_PLUGIN_DIR_PATH . 'core/field.php';

		// ── Instancia principal ─────────────────────────────────────────────────
		/**
		 * Devuelve la instancia única del core del plugin.
		 *
		 * @return ACFTC_Core
		 */
		function acftc(): ACFTC_Core {
			static $instance;

			if ( ! $instance ) {
				$instance = new ACFTC_Core();
			}

			return $instance;
		}

		acftc();

	} else {

		require_once ACFTC_PLUGIN_DIR_PATH . 'core/ACFTC_Conflict.php';
		new ACFTC_Conflict();

	}

}