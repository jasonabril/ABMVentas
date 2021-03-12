<?php
include_once "config.php";
include_once "entidades/usuario.php";

$usuario = new Usuario();
$usuario->cargarFormulario($_REQUEST);
$usuario->usuario = "jabril";
$usuario->clave = $usuario->encriptarClave("admin123");
$usuario->nombre = "Jason";
$usuario->apellido = "Abril";
$usuario->correo = "jehinsonabril@gmail.com";
$usuario->insertar();



?>