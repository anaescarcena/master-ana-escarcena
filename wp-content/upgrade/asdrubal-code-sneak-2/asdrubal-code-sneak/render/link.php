<?php
// Campo Link (añadido en ACF 5.6)
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$return_format = $this->settings['return_format'] ?? '';

// Enlace devuelto como array
if ( $return_format === 'array' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( \${$this->var_name}['url'] ); ?>\" target=\"<?php echo esc_attr( \${$this->var_name}['target'] ); ?>\"><?php echo esc_html( \${$this->var_name}['title'] ); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}

// Enlace devuelto como URL
if ( $return_format === 'url' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( \${$this->var_name} ); ?>\"><?php echo esc_html( \${$this->var_name} ); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}