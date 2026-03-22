<?php
// Campo Password
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Nota: el campo password devuelve el valor en texto plano.
// Úsalo solo en contextos seguros (ej. mostrar en zona privada de admin).
echo $this->indent . htmlspecialchars( "<?php \$password = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";