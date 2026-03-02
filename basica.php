<?php 
// 1. Configuraciones siempre al principio
define("pagina", "basica");
$tituloprov = "Título básico";
define("tituloprov", "Título específico de una web básica");

// 2. Carga de cabecera
include $_SERVER['DOCUMENT_ROOT'].'/assets/header.php';
?>

<p class="ctarepaso">JS para web básica</p>
<button type="button"
    onclick='document.getElementsByClassName("ctarepaso")[0].innerHTML = "Esto es un botón";'>

<p class="ctarepaso">Esto es un botón</p>
     <button type="button"
    onclick='document.getElementsByClassName("ctarepaso")[0].innerHTML = "JS para botón de web básica";'>
    Púlsame
</button>

<?php reutilizable1(); ?>

<h2 id="tipopantalla"></h2>
<h3 id="estacion"></h3>

<script>
// Lógica de detección de pantalla
let anchoPantalla = window.innerWidth;
let mensaje = (anchoPantalla > 1300) ? "Monitor" : (anchoPantalla > 700 ? "Portátil" : "Móvil");
document.getElementById("tipopantalla").innerHTML = "Me estás viendo desde el " + mensaje;

// Lógica de estación
let mes = new Date().getMonth();
let periodo = ([6, 7].includes(mes)) ? "¡Sí! Es verano" : "No es verano actualmente";
document.getElementById("estacion").innerHTML = periodo;
</script>

<script src="/scripts/pruebas.js"></script>

<?php 
// 4. El cierre siempre al final de TODO
include $_SERVER['DOCUMENT_ROOT'].'/assets/footer.php';
?>
<script src="/scripts/pruebas.js"></script>
