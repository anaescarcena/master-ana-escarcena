<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/header.php';
?>

<p class="ctarepaso">Esto es un botón</p>
     <button type="button"
    onclick='document.getElementsByClassName("ctarepaso")[0].innerHTML = "JS para botón de web básica";'>
    Púlsame
</button>

            <?php reutilizable1();?>


<?php 
include $_SERVER['DOCUMENT_ROOT'].'/assets/footer.php';
?>
<script src="/scripts/pruebas.js"></script>