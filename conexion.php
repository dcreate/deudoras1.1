<?php
function conectar()
{
    $server = "localhost";
    $user = "*************";
    $pass = "************";
    $bd = "tabla";

    $conexion = mysqli_connect($server, $user, $pass,$bd) or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    mysqli_set_charset($conexion, "utf8");
    return $conexion;
}
function desconectar($conexion){
	mysqli_close($conexion);
}
?>
