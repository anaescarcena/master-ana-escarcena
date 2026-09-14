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

<?php if ( is_singular('post') && get_post_field('post_name') === 'lo-que-hace-el-marketing-digital' ) : ?>
<!-- Datos estructurados: BlogPosting (ejemplo, solo en este artículo) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://master-ana-escarcena.test/articulo/lo-que-hace-el-marketing-digital/"
  },
  "headline": "Lo que hace el marketing digital",
  "description": "Una introducción práctica a qué es el marketing digital, sus canales principales y cómo puede ayudar a un negocio a crecer online.",
  "image": "https://master-ana-escarcena.test/wp-content/uploads/lo-que-hace-el-marketing-digital.jpg",
  "datePublished": "2026-03-20T10:00:00+01:00",
  "dateModified": "2026-03-27T21:22:42+01:00",
  "author": { "@id": "https://master-ana-escarcena.test/#persona", "name": "Ana Escárcena Álvarez" },
  "publisher": { "@id": "https://master-ana-escarcena.test/#organization", "name": "Future" }
}
</script>
<?php endif; ?>

<?php include_once 'footer.php'; ?>