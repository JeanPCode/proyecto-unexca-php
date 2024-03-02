<?php

require "conexion.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}

// Obtener el ID del registro a eliminar de la URL
$id = $_GET["id"];

// Eliminar el registro de la base de datos
$sql = "DELETE FROM accesorio WHERE id = '$id'";
if ($mysqli->query($sql) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error al eliminar el registro: " . $mysqli->error;
}

header("Location: ".$_SERVER["HTTP_REFERER"]);
?>