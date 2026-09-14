<?php 
include_once 'header.php';?>

<div class="generico">
<h1>
<?php the_title();?>
</h1>

<section id="contenido">
<?php the_content();?>

</section>
<div>

<!-- Datos estructurados: Persona (solo en esta página) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "@id": "https://master-ana-escarcena.test/#persona",
  "name": "Ana Escárcena Álvarez",
  "jobTitle": "SEO Specialist",
  "description": "Especialista en SEO con experiencia en posicionamiento web, estrategia de contenidos y análisis de datos. Ayuda a negocios locales de Estepona y la Costa del Sol a mejorar su visibilidad en Google.",
  "email": "anaescalvarez@gmail.com",
  "url": "https://master-ana-escarcena.test/quienes-somos/",
  "worksFor": { "@id": "https://master-ana-escarcena.test/#organization" }
}
</script>

<?php
include_once 'footer.php';?>