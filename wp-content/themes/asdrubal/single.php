<?php include_once 'header.php'; ?>

<div class="generico">
    <h1><?php the_title(); ?></h1>

    <section id="descripcioncorta">
        <?php if ( get_field('descripcion_corta') ) : ?>
            <div>
                <?php the_field('descripcion_corta'); ?>
            </div>
        <?php endif; ?>
    </section>

    <section id="contenido">
        <?php the_content(); ?>

        <?php if ( get_field('precio') ) : ?>
            <div class="precio"><?php the_field('precio'); ?>€</div>
        <?php endif; ?>
    </section>
</div>

        <style>
            .aspectocoche{
                aspect-ratio: 3 / 2;
                object-fit: cover;
            }
        </style>
<div class="infocoche">
<img height="300px" class="aspectocoche" src="<?php the_field ('imagencoche'); ?>" />
</div>

<?php
if ( in_category('coches') ) {
    $metadesc_coches = 'Mi memorable experiencia con un ' . get_field('marca_coche') . ' ' . get_field('modelo_coche') . ' de ' . get_field('CV');
    ?>
    <meta name="description" content="<?php echo esc_attr($metadesc_coches); ?>">
    <meta property="og:description" content="<?php echo esc_attr($metadesc_coches); ?>">
    <meta property="twitter:description" content="<?php echo esc_attr($metadesc_coches); ?>">
    <?php 
} 
else { 
    ?>
    <meta name="description" content="<?php the_field('metadescription', $term); ?>">
    
    <meta property="og:description" content="<?php 
        if ( get_field('og_description', $term) ) {
            the_field('og_description', $term);
        } else {
            the_field('metadescription', $term);
        } ?>">

    <meta property="twitter:description" content="<?php 
        if ( get_field('twitter_description', $term) ) {
            the_field('twitter_description', $term);
        } elseif ( get_field('og_description', $term) ) {
            the_field('og_description', $term);
        } else {
            the_field('metadescription', $term);
        } ?>">
    <?php 
} 
?>

<?php include_once 'footer.php'; ?>