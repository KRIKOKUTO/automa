<?php
// verificar_contrasena.php

// Incluye el archivo que contiene la función para verificar la contraseña
require_once 'pass.php';

// Recupera la contraseña y la contraseña encriptada de la solicitud POST
$contrasena = $_POST['contrasena'];
$contrasenaEncriptada = $_POST['contrasenaEncriptada'];

// Llama a la función para verificar la contraseña
if (verificarContrasena($contrasena, $contrasenaEncriptada)) {
    echo 'correcta';
} else {
    echo 'incorrecta';
}
?>
