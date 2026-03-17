<?php 
include_once 'header.php';?>

<div class="generico">
<h1>hola
<?php the_title();?>
</h1>

<section id="contenido">
<?php the_content();?>

</section>

<?php
 include $plantillas .'tresposts.php';
// include 'plantillas/tresposts.php'; 
?>

<div>

<?php
// include_once 'footer.php'; 
get_footer();

?>