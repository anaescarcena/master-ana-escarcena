<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/header.php';
?>

        <div class="contenedor">  
   <h1>Bienvenidos a la página Contacto</h1>
   <video width="600" height="400" controls autoplay muted>
    <source src="./video/pajarito.mp4" type="video/mp4">

   </video>

<?php 
$ejercicio= "Esto es un h2";

switch ($ejercicio) {
        case ("Esto es un h1"):
                echo "<h1>La variable ejercicio es un h1</h1>";
                break;
        case ("Esto es un h2"):
                echo "<h2>La variable ejercicio es un h2</h2>";
                break;

        case ("Esto es un h3"):
                echo "<h3>La variable ejercicio es un h3</h3>";
                break;
        default: 
                echo "No sabemos qué encabezado es la variable ejercicio";
                break;
}
?>
            <?php reutilizable1();?>


<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/footer.php';
?>
<script src="/scripts/pruebas.js"></script>