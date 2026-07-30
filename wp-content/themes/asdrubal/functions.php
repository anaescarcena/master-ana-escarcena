<?php
$plantillas = __DIR__ .'/plantillas/';

function tresposts (){
        $plantillas = __DIR__ .'/plantillas/';
    include $plantillas .'tresposts.php';

}
add_shortcode('lastest_posts', 'tresposts');

?>

<?php
// Borrar Sitemap por defecto
add_filter( 'wp_sitemaps_enabled', '__return_false' );
if (has_action('init', 'wp_sitemaps_get_server')){
remove_action('init', 'wp_sitemaps_get_server');
}
?>