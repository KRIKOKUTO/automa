<?php

function verificarContrasena($contrasena, $contrasenaEncriptada) {
    // Utiliza password_verify para comparar la contraseña proporcionada con la almacenada
    return password_verify($contrasena, $contrasenaEncriptada);
}
?>
