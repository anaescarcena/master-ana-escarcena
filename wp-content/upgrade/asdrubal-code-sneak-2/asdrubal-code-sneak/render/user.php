<?php
// Campo User
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$multiple_values = $this->settings['multiple']      ?? '0'; // string: '0' | '1'
$return_format   = $this->settings['return_format'] ?? '';

// Nota: se usa get_author_posts_url() en lugar de user_url porque
// el campo user_url estaba vacío en las pruebas con ACF/SCF.

// ── Array ────────────────────────────────────────────────────────────────────
if ( $return_format === 'array' ) {

	// Valor único
	if ( $multiple_values === '0' ) {
		echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( get_author_posts_url( \${$this->var_name}['ID'] ) ); ?>\"><?php echo esc_html( \${$this->var_name}['display_name'] ); ?></a>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
	}

	// Múltiples valores
	if ( $multiple_values === '1' ) {
		echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php foreach ( \${$this->var_name} as \$user ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "		<a href=\"<?php echo esc_url( get_author_posts_url( \$user['ID'] ) ); ?>\"><?php echo esc_html( \$user['display_name'] ); ?></a>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php endforeach; ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
	}

}

// ── Objeto ───────────────────────────────────────────────────────────────────
if ( $return_format === 'object' ) {

	// Valor único
	if ( $multiple_values === '0' ) {
		echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( get_author_posts_url( \${$this->var_name}->ID ) ); ?>\"><?php echo esc_html( \${$this->var_name}->display_name ); ?></a>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
	}

	// Múltiples valores
	if ( $multiple_values === '1' ) {
		echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php foreach ( \${$this->var_name} as \$user ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "		<a href=\"<?php echo esc_url( get_author_posts_url( \$user->ID ) ); ?>\"><?php echo esc_html( \$user->display_name ); ?></a>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php endforeach; ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
	}

}

// ── ID ───────────────────────────────────────────────────────────────────────
if ( $return_format === 'id' ) {

	// Valor único
	if ( $multiple_values === '0' ) {
		echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php \$user_data = get_userdata( \${$this->var_name} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php if ( \$user_data ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "		<a href=\"<?php echo esc_url( get_author_posts_url( \${$this->var_name} ) ); ?>\"><?php echo esc_html( \$user_data->display_name ); ?></a>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php endif; ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
	}

	// Múltiples valores
	if ( $multiple_values === '1' ) {
		echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php foreach ( \${$this->var_name} as \$user_id ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "		<?php \$user_data = get_userdata( \$user_id ); ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "		<?php if ( \$user_data ) : ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "			<a href=\"<?php echo esc_url( get_author_posts_url( \$user_id ) ); ?>\"><?php echo esc_html( \$user_data->display_name ); ?></a>" ) . "\n";
		echo $this->indent . htmlspecialchars( "		<?php endif; ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "	<?php endforeach; ?>" ) . "\n";
		echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
	}

}