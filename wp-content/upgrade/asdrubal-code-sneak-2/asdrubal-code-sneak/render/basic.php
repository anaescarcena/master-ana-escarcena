<?php
// Campos básicos (text, textarea, number, email, url, wysiwyg, etc.)
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Partial compartido para tipos de campo básicos que renderizan con the_field / the_sub_field
echo $this->indent . htmlspecialchars( "<?php " . $this->the_field_method . "( '" . $this->name . "'" . $this->location_rendered_param . " ); ?>" ) . "\n";