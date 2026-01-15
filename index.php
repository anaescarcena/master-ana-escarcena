<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/header.php';
?>

<?php 
echo $_SERVER['DOCUMENT_ROOT'];
$frase= "Frase con variable";
$A= 5;
$B= 2;
?>




        <div class="contenedor">  
    <!--Me he liado mucho al hacer las carpetas-->    
        <h1> <?php echo "Hello teacher";?></h1>
       <picture>    
        <img class="tam-imagen decor-imagen" src="imagenes/imagen1.webp" alt="texto alt"><br>
        </picture>
        <a href="https://www.google.com" target="_blank" title="">Haz click para ir a Google</a>
        <ol>
            <li>perro</li>
            <li>gato</li>
            <li>oso</li>
        </ol>
        <?php 
        /* Buen uso del if-elseif-else. Está funcionando bien. */
        if ($A>$B) {
            echo "A es mayor que B";
        }
        elseif ($A==$B) {
            echo "A es igual que B";
        }
        else {
            echo "A es menor que B";
        }
        ?>


        <?php echo $frase; ?>
        <section class="preguntas-frecuentes">
            <h2 class="descendiente">Preguntas frecuentes</h2>
            <details>
                <summary class="faq">¿Esto es una pregunta frecuente?</summary>
                Puede serlo, y esta respuesta solo la verá el usuario si despliega el elemento
            </details>

            <details>
               <summary class="faq">¿Se entiende la clase?</summary>
                Perfectamente, gracias Carlos, muy amable.
            </details>
        </section><br>
    
<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/footer.php';
?>