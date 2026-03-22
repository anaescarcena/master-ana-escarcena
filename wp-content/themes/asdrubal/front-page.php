<?php 
include_once 'header.php';?>

<div class="generico">
<h1>hola
<?php the_title();?>
</h1>

<section id="contenido">
<?php the_content();?>

</section>
    
    <div class="trespost">
    <?php
    include $plantillas .'tresposts.php';
    // include 'plantillas/tresposts.php'; 
    ?>
    </div>
    
</div>

<?php
// include_once 'footer.php'; 
get_footer();

?>