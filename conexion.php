<?php

$mysqli = new mysqli("localhost", "root", "", "registro");

if ($mysqli->connect_error){

    die ('Error en la Conexion' . $mysqli->connect_error); 
} 
mysqli_set_charset($mysqli, "utf8");

?>