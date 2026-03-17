<section id="displaytresposts" class="flexcenter">
    <?php
        $args = array(
        'posts_per_page' => '3',  //-1 es para ver todos los posts//
        'post_type' => 'post',
        'orderby' => 'date', //poniendolo como rand se ordenan de manera aleatoria//
        'order' => 'DESC',
        ); //quedan todos los posts ordenados por fecha en forma descendente//
        $the_query = new WP_Query( $args);
            if ( $the_query->have_posts()){
            while ( $the_query->have_posts() ) {
            $the_query->the_post();
            include $plantillas .'/display-posts/card-posts.php';
        }
        }
        else{
            echo "No hay posts";
        }
        wp_reset_postdata();
    ?>
</section>