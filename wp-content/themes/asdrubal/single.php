<?php 
include_once 'header.php';?>

<div class="generico">
<h1>
<?php the_title();?>
</h1>

<section id="descripcioncorta">
<?php if ( get_field('descripcion_corta') ) : ?>
    <div>
        <?php the_field('descripcion_corta'); ?>
    </div>
<?php endif; ?>
</section>

<section id="contenido">
<?php the_content();?>

<?php 
if (get_field('precio')){
    ?>

        <div class="precio"><?php the_field( 'precio' );?>€</div>

<?php
}

else {;}
?>

</section>
</div>

<?php
include_once 'footer.php';?>