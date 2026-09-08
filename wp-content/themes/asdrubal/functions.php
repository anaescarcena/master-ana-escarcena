<?php
$plantillas = __DIR__ .'/plantillas/';

// Activar la imagen destacada en entradas y páginas
add_theme_support('post-thumbnails');

function tresposts (){
        $plantillas = __DIR__ .'/plantillas/';
    include $plantillas .'tresposts.php';

}
add_shortcode('lastest_posts', 'tresposts');

?>

