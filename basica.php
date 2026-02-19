<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/header.php';
?>

<p class="ctarepaso">Esto es un botón</p>
<button type="button"
    onclick='document.getElementsByClassName("ctarepaso")[0].innerHTML = "JS para botón de web básica";'>
    Púlsame
</button>

            <?php reutilizable1();?>

<h2 id= "tipopantalla"></h2>
<h3 id= "estacion"></h3>

<script>
let anchoPantalla = window.innerWidth;
let mensaje;

if (anchoPantalla > 1300) {
    mensaje = "Me estás viendo desde el monitor";
}
else if (anchoPantalla <1300 && anchoPantalla > 700) {
    mensaje = "Me estás viendo desde el portatil";
}
else {
    mensaje = "Me estás viendo desde el móvil";
}

document.getElementById("tipopantalla").innerHTML = mensaje;

let mes = new Date().getMonth();
let periodo;

switch (mes) {
    case 0:
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
    case 8:
    case 9:
    case 10:
    case 11:
        periodo = "No es verano actualmente";
        break;
    default:
        periodo = "¡Sí! Es verano actualmente";
}

document.getElementById("estacion").innerHTML = periodo;

</script>

<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/footer.php';
?>
<!-- script src="/scripts/pruebas.js"></-script> (tiene un error y hace que se rompa todo. no recuerdo qué hace) -->