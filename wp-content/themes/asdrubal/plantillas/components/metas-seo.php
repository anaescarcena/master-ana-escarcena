<meta name="viewport" content="width=device-width,initial-scale=1">
<meta charset="UTF-8">
<?php
$term = get_queried_object();
$robots_val = get_field('robots_config', $term) ?: 'index, follow';
$robots_fijos = 'nosnippet, indexifembedded, notranslate, noimageindex';
echo '<meta name="robots" content="' . esc_attr($robots_val) . ', ' . $robots_fijos . '">';
?>
<?php

add_action('wp_head', 'master_seo_meta_tags', 1);
function master_seo_meta_tags() {
    $term = get_queried_object();
    if (!$term) return;

    $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $current_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"], '?');

    $main_title = get_field('title', $term); 
    $main_desc  = get_field('metadescription', $term);
    $canonical  = get_field('canonical', $term) ?: $current_url;
    
    $acf_img = get_field('og_image', $term);
    $default_img = 'https://master-ana-escarcena.test/wp-content/uploads/logo-ana-scaled.png';
    $final_img = $acf_img ? $acf_img : $default_img;

    $og_title = get_field('og_title', $term) ?: $main_title;
    $og_desc  = get_field('og_description', $term) ?: $main_desc;
    $tw_title = get_field('twitter_title', $term) ?: $og_title;
    $tw_desc  = get_field('twitter_description', $term) ?: $og_desc;

    ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta charset="UTF-8" /> 
    <!-- Viewport y charset repetidos, ya está al inicio -->
    <title><?php echo esc_html($main_title); ?></title>
    <meta name="description" content="<?php echo esc_attr($main_desc); ?>">
    <link rel="canonical" href="<?php echo esc_url($canonical); ?>">

    <?php if ( get_field('rrss', $term) ) : ?>
    <meta property="og:title" content="<?php echo esc_attr($og_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($og_desc); ?>">
    <meta property="og:url" content="<?php echo esc_url($canonical); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo esc_url($final_img); ?>">
    <meta property="og:image:secure_url" content="<?php echo esc_url($final_img); ?>">
    <meta property="og:image:alt" content="<?php echo esc_attr($main_title); ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($tw_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($tw_desc); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($final_img); ?>">
    <?php endif; ?>

    <?php the_field('metatags_personalizados', $term); ?>

    <?php if ( get_field('adultos', $term) ): ?>
        <meta name="rating" content="adult">
    <?php endif; ?>
    <?php
}

add_action('wp_footer', 'master_fix_css_names');
function master_fix_css_names() {
    ?>
 
 
 <script id="css-renamer-script">
    (function() {
        const styles = document.querySelectorAll('link[rel="stylesheet"]');
        const updateHref = (element, newName) => {
            if (!element || !element.href) return;
            element.href = element.href.replace(/\/[^\/]+\.css/, '/' + newName);
        };
        if (styles[0]) updateHref(styles[0], 'style.css');
        if (styles[1]) updateHref(styles[1], 'estilos-revisar.css');
    })();
    </script>
    <?php
}

