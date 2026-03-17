<!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head><meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" media="all">

<?php /*
    <link rel="stylesheet" href="/css/estilo.css">

<title>
    <?php 
    if (empty($titulo)) {
    echo "Página sin metatittle";
    }

    else {
        echo $titulo ;
    }


    include_once $_SERVER['DOCUMENT_ROOT']. '/assets/functions.php';
       

    ?>

</title>
*/ 

wp_head();
?>

</head>

<body>

    <header>
        <nav id="menu-principal">
            <ul class="menu">
                <li><a href="/">Inicio</a>
                </li><li><a href="/quienes-somos/">Quiénes Somos</a>
                </li><li><a href="/contacto/">Contacto</a>
                </li><li><a href="/carpeta/archivo-carpeta/">Archivo dentro de carpeta</a>
                </li><li><a href="/nuevo/">Nueva página redirección</a>
                </li><li><a href="/basica/">Web básica</a>
               
                </li>
            </ul>
            
            </nav>
        </header>