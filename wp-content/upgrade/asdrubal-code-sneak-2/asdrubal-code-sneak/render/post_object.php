<?php
// Campo Post Object
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$multiple_values = $this->settings['multiple']       ?? '0'; // string: '0' | '1'
$return_format   = $this->settings['return_format']  ?? '';

// ── ID, valor único ──────────────────────────────────────────────────────────
if ( $return_format === 'id' && $multiple_values === '0' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php echo esc_url( get_permalink( \${$this->var_name} ) ); ?>\"><?php echo esc_html( get_the_title( \${$this->var_name} ) ); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}

// ── ID, múltiples valores ────────────────────────────────────────────────────
if ( $return_format === 'id' && $multiple_values === '1' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php foreach ( \${$this->var_name} as \$post_id ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "		<a href=\"<?php echo esc_url( get_permalink( \$post_id ) ); ?>\"><?php echo esc_html( get_the_title( \$post_id ) ); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php endforeach; ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}

// ── Objeto, valor único ──────────────────────────────────────────────────────
if ( $return_format === 'object' && $multiple_values === '0' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php \$post = \${$this->var_name}; ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php setup_postdata( \$post ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<a href=\"<?php the_permalink(); ?>\"><?php the_title(); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php wp_reset_postdata(); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}

// ── Objeto, múltiples valores ────────────────────────────────────────────────
if ( $return_format === 'object' && $multiple_values === '1' ) {
	echo $this->indent . htmlspecialchars( "<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php if ( \${$this->var_name} ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php foreach ( \${$this->var_name} as \$post ) : ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "		<?php setup_postdata( \$post ); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "		<a href=\"<?php the_permalink(); ?>\"><?php the_title(); ?></a>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php endforeach; ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "	<?php wp_reset_postdata(); ?>" ) . "\n";
	echo $this->indent . htmlspecialchars( "<?php endif; ?>" ) . "\n";
}