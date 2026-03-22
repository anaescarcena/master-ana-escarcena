<?php
// Campo True / False
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// get_field() devuelve true/false como booleano en ACF/SCF 5+
echo $this->indent . htmlspecialchars( "<?php if ( {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ) ) : ?>" ) . "\n";
echo $this->indent . htmlspecialchars( "	<?php // echo 'true'; ?>" ) . "\n";
echo $this->indent . htmlspecialchars( "<?php else : ?>" ) . "\n";
echo $this->indent . htmlspecialchars( "	<?php // echo 'false'; ?>" ) . "\n";
echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";