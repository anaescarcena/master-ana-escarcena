<?php
// Borrar Sitemap por defecto (wp-sitemap.xml). Está funcionando porque el plugin (test.php) está activo.
add_filter( 'wp_sitemaps_enabled', '__return_false' );
if (has_action('init', 'wp_sitemaps_get_server')){
remove_action('init', 'wp_sitemaps_get_server');
}
?>