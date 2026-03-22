<?php
// Campo Group (basado en el partial de Repeater)
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$group_field_group = new ACFTC_Group( [
	'field_group_id'      => $this->id,
	'fields'              => null,
	'nesting_level'       => 1,
	'indent_count'        => $this->indent_count + ACFTC_Core::$indent_repeater,
	'exclude_html_wrappers' => $this->exclude_html_wrappers,
] );

// El grupo tiene subcampos
if ( ! empty( $group_field_group->fields ) ) {

	echo $this->indent . htmlspecialchars( "<?php if ( have_rows( '{$this->name}'{$this->location_rendered_param} ) ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php while ( have_rows( '{$this->name}'{$this->location_rendered_param} ) ) : the_row(); ?>" ) . "\n";

	echo $group_field_group->get_field_group_html();

	echo $this->indent . htmlspecialchars( "	<?php endwhile; ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";

} else {

	// El grupo no tiene subcampos configurados
	$aviso = sprintf(
		/* translators: %s: nombre del campo group */
		__( 'Aviso: el campo Group \'%s\' no tiene subcampos', 'acf-theme-code' ),
		$this->name
	);
	echo $this->indent . htmlspecialchars( "<?php // {$aviso} ?>" ) . "\n";

}