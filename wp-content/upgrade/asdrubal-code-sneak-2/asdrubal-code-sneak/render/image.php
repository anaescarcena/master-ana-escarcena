<?php
// Campo Image
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// ACF/SCF 5+ almacena el formato en 'return_format'
$return_format = $this->settings['return_format'] ?? '';

// Imagen devuelta como array
if ( $return_format === 'array' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<img src=\"<?php echo esc_url( \${$this->var_name}['url'] ); ?>\" alt=\"<?php echo esc_attr( \${$this->var_name}['alt'] ); ?>\" />" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}

// Imagen devuelta como URL
if ( $return_format === 'url' ) {
	echo $this->indent . htmlspecialchars( "<?php if ( {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ) ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<img src=\"<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\" alt=\"\" />" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}

// Imagen devuelta como ID
if ( $return_format === 'id' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php \$size = 'full'; ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php echo wp_get_attachment_image( \${$this->var_name}, \$size ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}