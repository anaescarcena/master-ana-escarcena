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


        <div id="cambiante">

        </div>
        <div class="efectito">
            Pulsame para funcionar
        </div>
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
        const activador = document.getElementsByClassName("efectito");
        activador[0].addEventListener("click", funcionana);

        function funcionana(){
        const collection = document.getElementsByClassName("selectorclass");
        for (let i = 0; i < collection.length; i++) {
        collection[i].classList.add("rojojs");
        } 
        activador[0].setAttribute("onclick", "funcionNumero2()");
        }
        
        function funcionNumero2(){
        const ejemplazo = document.getElementsByClassName("selectorclass");
        for (let i = 0; i < ejemplazo.length; i++) {
        ejemplazo[i].classList.remove("rojojs");        
        }
        }
// Para utilizar la funcionana poner onclick en el div

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
.efectito {
    display: flex;
    width: 200px;
    height: 100px;
    box-sizing: border-box;
    align-items: center;
    justify-content: center;
    background: rgb(244, 167, 25);
    text-align: center;
    color: white;
    cursor: pointer;
    margin: auto;
}
        </style>
 

        <button type="button"
        onclick='document.getElementById("secondjs").innerHTML = "¡Ha funcionado!" + (numberseo - 5) + ejemplo + profesores[1] + masterana.nombre'>
        Pulsame 2    
        </button>

        <button type="button"
        onclick='document.getElementById("secondjs").innerHTML = "¡Ha funcionado distinto!" + testeo + loquequiera'>
        Pulsame    
        </button>

 <script> 

let ejemplo = 'Variable con let' ;
const loquequiera = 'Constante';
var testeo = 'Variable con var' ;
let profesores = ['Ana', 'Clase', 'Sí'];
let numberseo = 60;
let masterana = {nombre: 'Javascript', Profesor: 'Carlos'};
        </script>
        
 <script> 
const collection = document.querySelectorAll('a[href^="http"]');
    for (let i = 0; i < collection.length; i++) {
    collection[i].classList.className + = "rojojs" ;
        } 
        </script>


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
