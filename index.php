<?php 
$titulo = "Inicio";
define("pagina","inicio");

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

        <h1 id="heading1"> Hello teacher</h1>
        <h2>Texto de prueba</h2>

    <!-- <h1> <?php echo "Hello teacher";?></h1> (h1 hecho en php) -->

         <noscript><p>Cuando no funcione javascript saldrá esto</p></noscript>

        <p id="selectorid" class="selectorclass">Mi primer Javascript</p>
        <p id="secondjs" class="selectorclass"><a href="https://www.google.com/">Mi segundo Javascript</a></p>
        <p id="selectorid" class="selectorclass">Mi tercer Javascript </p>

        <div id="jsasdrubal" class="selectorclass"></div>
        <p id="selectorid" class="selectorclass">Mi cuarto Javascript</p>

        <script>
        // Seleccionar elemnto por ID
        // document.getElementById("selectorid").innerHTML = "ESTO ES UN TEXTO DE JS";

        // Seleccionar elemnto por Clase
       // document.getElementsByClassName("selectorclass")[i].innerHTML = "ESTO ES UN TEXTO DE JS cogido por la clase";
       
       // Muchas clases
       /* const collection = document.getElementsByClassName("pruebaclassjs");
        for (let i = 0; i < collection.length; i++) {
        collection[i].innerHTML = "ESTO ES UN TEXTO DE JS codigo por la clase Multiplicado";
        } */
        
        // Un solo tag
       // document.getElementsByTagName("h2")[0].innerHTML = "ESTO es un h2 modificado por js";

        // const collection = document.querySelectorAll('a[href^="http"]');
        /*for (let i = 0; i < collection.length; i++) {
            collection[i].innerHTML = "Página hacia Google";
                } */
    
    // const collection = document.querySelectorAll('a[href^="http"]');
    /*for (let i = 0; i < collection.length; i++) {
    collection[i].setAttribute("class" , "rojojs");
        }    ¿Por que solo pilla un id class cuando hay mas?  */   

        const collection = document.querySelectorAll('a[href^="http"]');
    for (let i = 0; i < collection.length; i++) {
    collection[i].classList.add ("rojojs");
        } 
        </script>

        <style>
            .rojojs{
                color: red;
            }

        </style>
 

        <button type="button"
        onclick='document.getElementById("secondjs").innerHTML = "¡Ha funcionado!" + ejemplo + profesores[1]'>
        Pulsame 2    
        </button>

        <button type="button"
        onclick='document.getElementById("secondjs").innerHTML = "¡Ha funcionado distinto!" + testeo + loquequiera'>
        Pulsame    
        </button>


        
 <script> 
const collection = document.querySelectorAll('a[href^="http"]');
    for (let i = 0; i < collection.length; i++) {
    collection[i].classList.className += "rojojs" ;
        } 

let ejemplo = 'Variable con let' ;
const loquequiera = 'Constante';
var testeo = 'Variable con var' ;
let profesores = ['Ana', 'Clase', 'Sí'];
        </script>

        // Qué falla aqui y por que esto no comenta


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
        ?> <br>

        <?php ctas(); ?>
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
<script src="/scripts/pruebas.js"></script>
<script>
       const collection = document.getElementsByTagName("h2");
        for (let i = 0; i < collection.length; i++) {
        collection[i].innerHTML = "ESTO son muchos h2 modificado por js";
        }
</script>
