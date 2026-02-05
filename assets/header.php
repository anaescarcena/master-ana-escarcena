<!DOCTYPE html><html>
    <head><meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="UTF-8"><link rel="stylesheet" href="/css/estilo.css">

<title>
    <?php 
    if (empty($titulo)) {
    echo "Página sin metatittle";
    }

    else {
        echo $titulo ;
    }

    /*No lo he entendido mucho pero listo. O sea, lo entiendo, pero tiene que asentarse en mi cabeza*/

    include_once $_SERVER['DOCUMENT_ROOT']. '/assets/functions.php';
       

    ?>

</title>
</head>

<body>

    <header>
        <nav id="menu-principal">
            <ul class="menu">
                <li><a href="/">Inicio</a>
                </li><li><a href="/quienes-somos">Quiénes Somos</a>
                </li><li><a href="/contacto">Contacto</a>
                </li><li><a href="/carpeta/archivo-carpeta">Archivo dentro de carpeta</a>
                </li><li><a href="/nuevo">Nueva página redirección</a>
                </li>
            </ul>
            
            </nav>
        </header>