<?php
require "conexion.php";
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtiene el ID desde la URL
    $sql = "DELETE FROM censo WHERE id='$id'";
    if (mysqli_query($mysqli, $sql)) {
        // Redirige al usuario a la página de éxito o vuelve a la lista
        header("Location: main.php");
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($mysqli);
    }
} else {
    echo "No se proporcionó un ID válido.";
}
?>