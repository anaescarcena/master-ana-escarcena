<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/header.php';
?>

        <div class="contenedor">  
   <h1>Crítica de 'Todo a la vez en todas partes', el regreso de Ke Huy Quan</h1>

<?php 
$ejercicio= "Esto es un h2";

switch ($ejercicio) {
        case ("Esto es un h1"):
                echo "<h1>La variable ejercicio es un h1</h1>";
                break;
        case ("Esto es un h2"):
                echo "<h2>El estreno de la marciana película nos devuelve a la pantalla a uno de los rostros más familiares del cine USA de los 80.</h2>";
                break;

        case ("Esto es un h3"):
                echo "<h3>La variable ejercicio es un h3</h3>";
                break;
        default: 
                echo "No sabemos qué encabezado es la variable ejercicio";
                break;
}
?>
<div>Fausto Fernández valora Todo a la vez en todas partes como una película desbordante, imaginativa y difícil de encasillar, que utiliza el multiverso para explorar el sinsentido de la existencia, las relaciones familiares y la búsqueda de identidad. El crítico destaca la influencia de los Monty Python, especialmente de Terry Gilliam, y compara el recorrido de Evelyn Wang (Michelle Yeoh) con un viaje a través de múltiples géneros y realidades que combinan ciencia ficción, artes marciales, romance y fantasía.

Según Fernández, detrás de su compleja estructura y su aparente caos narrativo se esconde una idea sencilla: la lucha por convertirse en alguien diferente suele enfrentarse a los caprichos del destino, y la verdadera heroicidad puede residir en afrontar la vida cotidiana más que en salvar el universo. Considera que la película ofrece una experiencia única para los espectadores que buscan propuestas originales y arriesgadas.

Como aspecto más destacado, subraya el regreso a la gran pantalla de Ke Huy Quan, mientras que señala como posible punto débil que algunos espectadores podrían agotarse antes que la propia película debido a su intensidad y exceso visual.</div>
            <blockquote>Salvar tu día a día es incluso más heroico que salvar al universo, o al multiverso - Fausto Fernández</blockquote>



            <div>En conjunto, la crítica es muy positiva y otorga a la película la máxima valoración (5 estrellas), destacando su ambición, creatividad y capacidad para sorprender.</div><br>
<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/footer.php';
?>
<script src="/scripts/pruebas.js"></script>