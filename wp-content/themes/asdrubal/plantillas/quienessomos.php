<?php 
include_once 'header.php';
/*Template Name: dinero */
?>

<div class="generico">

<div class="Precios ultrarrebajados">
<h1>
<?php the_title();?>
</h1>

<section id="contenido">
<?php the_content();?>

</section>
<?php
include $plantillas .'tresposts.php';
// include 'plantillas/tresposts.php'; Se puede añadir de ambas formas
?>
<div>

<?php
include_once 'footer.php';?>