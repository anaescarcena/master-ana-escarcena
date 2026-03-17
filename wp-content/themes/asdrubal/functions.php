<?php
$plantillas = __DIR__ .'/plantillas/';

function tresposts (){
        $plantillas = __DIR__ .'/plantillas/';
    include $plantillas .'tresposts.php';

}
add_shortcode('lastest_posts', 'tresposts');

?>