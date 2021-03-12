<?php
include_once "entidades/usuario.php";



$entidadUsusario = new Usuario();
$entidadUsusario->cargarFormulario($_POST);





$title = "guardar";
?>
<?php include_once "head.php"?>
<h1>Usuario Guardado</h1>

