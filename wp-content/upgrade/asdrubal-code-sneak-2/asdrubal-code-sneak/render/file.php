<?php
// Campo File
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// ACF/SCF 5+ almacena el formato en 'return_format'
$return_format = $this->settings['return_format'] ?? '';

// Fichero devuelto como array
if ( $return_format === 'array' ) {

	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( \${$this->var_name}['url'] ); ?>\"><?php echo esc_html( \${$this->var_name}['filename'] ); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";

}

// Fichero devuelto como URL
if ( $return_format === 'url' ) {

	$i18n_download = __( 'Descargar archivo', 'acf-theme-code' );

	echo $this->indent . htmlspecialchars( "<?php if ( {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ) ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\">{$i18n_download}</a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";

}

// Fichero devuelto como ID
if ( $return_format === 'id' ) {

	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php \$url = wp_get_attachment_url( \${$this->var_name} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( \$url ); ?>\"><?php esc_html_e( 'Descargar archivo', 'acf-theme-code' ); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";

}