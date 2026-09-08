<!-- Esta plantilla se ha realizado mediante un plugin propio (template-generator.php).

Si se quiere crear nuevas plantillas o desativar esta, se realiza desde test.php -->

<?php
$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http' . '://';
$rutita = $current_url="//".$_SERVER['HTTP_HOST'];
$canonical = get_field( 'canonical' );
?><x-layout>
<section>
<div style="height:44px;"> </div>
<?php
// Blog
echo "<h2>Blog</h2>";
$domblog = new DOMDocument('1.0','UTF-8');
$domblog->formatOutput = true;
$domblog->preserveWhiteSpace = false;
$rootblog = $domblog->createElement('urlset');
$domblog->appendChild($rootblog);
$rootblog->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$rootblog->setAttribute('xmlns:news', 'http://www.google.com/schemas/sitemap-news/0.9');
$rootblog->setAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');

//$resultblog->setAttribute('id', 1);
$argsblog = array(
'posts_per_page' => -1,
//'post__not_in' => array($post->ID), // Ensure that the current post is not displayed
'post_type' => 'post',
'orderby' => 'date',
'order' => 'DESC',
'post_status' => 'publish',
);
$obtencionblog = new WP_Query( $argsblog );
if ($obtencionblog->have_posts()) :
while ($obtencionblog->have_posts()) : $obtencionblog->the_post();
if (!get_field("canonical")) {
$metarobots_checked_values = get_field('metarobots');
if ($metarobots_checked_values && (in_array('all', $metarobots_checked_values) || in_array('index', $metarobots_checked_values))) {
$enlace = get_permalink();
$lastestmod = get_the_modified_date('Y-m-d');
$resultblog = $domblog->createElement('url');
$rootblog->appendChild($resultblog);
$resultblog->appendChild($domblog->createElement('loc', $enlace));
$resultblog->appendChild($domblog->createElement('lastmod', $lastestmod));


// Añadir estructura adicional dentro de <news:news>
$newsElement = $domblog->createElement('news:news');
$resultblog->appendChild($newsElement);
$tituloblog = get_the_title();
$publishedblog = get_the_modified_date('Y-m-d\TH:i:s.uP');
$newstitle = get_field('title');

// Definir las variables dentro de <news:news> según tus necesidades
$publicationElement = $domblog->createElement('news:publication');
$publicationNameElement = $domblog->createElement('news:name', $tituloblog);
$publicationLanguageElement = $domblog->createElement('news:language', 'es');
$publicationElement->appendChild($publicationNameElement);
$publicationElement->appendChild($publicationLanguageElement);
$newsElement->appendChild($publicationElement);
$publicationDateElement = $domblog->createElement('news:publication_date', $publishedblog);
$newsElement->appendChild($publicationDateElement);
$titleElement = $domblog->createElement('news:title', $newstitle);
$newsElement->appendChild($titleElement);

// Imagen destacada del post
if (has_post_thumbnail()) {
$featured_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$image_element = $domblog->createElement('image:image');
$resultblog->appendChild($image_element);
$image_element->appendChild($domblog->createElement('image:loc', $featured_url));
}

// Obtener las imágenes en el contenido de the_content()
$content = get_the_content();
$pattern = '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/';
preg_match_all($pattern, $content, $matches);

// Agregar las URL de las imágenes al elemento <url>
if (!empty($matches[1])) {
foreach ($matches[1] as $image_url) {
$image_element = $domblog->createElement('image:image');
$resultblog->appendChild($image_element);

$loc_element = $domblog->createElement('image:loc', $image_url);
$image_element->appendChild($loc_element);
}
}

}
}
endwhile;
wp_reset_postdata();
endif;
// Así vemos el código que se hace
echo '<code class="codigo-post"><xmp>'. $domblog->saveXML() .'</xmp></code>';
echo '<a class="exitbutton" href="' . $rutita . '/ana.xml" target="_blank">Comprobar Sitemap</a>';
$domblog->save('ana.xml') or die('XML Create Error');
?>
</section>
<style>
.site-footer{display:none}.codigo-post{background:var(--light-grey);padding:40px 16px 16px;cursor:text;font-size:16px;overflow-x:scroll;display:block;max-width:100%;min-width:100px;background-color:#0c1021;color:#fff;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='54' height='14' viewBox='0 0 54 14'%3E%3Cg fill='none' fill-rule='evenodd' transform='translate(1 1)'%3E%3Ccircle cx='6' cy='6' r='6' fill='%23FF5F56' stroke='%23E0443E' stroke-width='.5'%3E%3C/circle%3E%3Ccircle cx='26' cy='6' r='6' fill='%23FFBD2E' stroke='%23DEA123' stroke-width='.5'%3E%3C/circle%3E%3Ccircle cx='46' cy='6' r='6' fill='%2327C93F' stroke='%231AAB29' stroke-width='.5'%3E%3C/circle%3E%3C/g%3E%3C/svg%3E");background-repeat:no-repeat;background-position:16px 8px;font-family:monospace;background-attachment:local}.codigo-post pre{margin:none}a.exitbutton{background:#8d096b;color:#faf7fb;text-decoration:inherit;font-size:22px;margin:16px auto auto;display:flex;width:fit-content;padding:16px;font-weight:700}h2{color:#8d096b;font-size:40px}
</style>
</x-layout>


