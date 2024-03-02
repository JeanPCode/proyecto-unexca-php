<?php

require "conexion.php";
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>

    <main class="container">
        <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="title-form">
                <h2>Iniciar Sesión</h2>
            </div>
            <div class="form">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Acceder</button>
            </div>
            <div class="mesaje">
        <?php
            if ($_POST) {
                $usuario = $_POST['usuario'];
                $password = $_POST['password'];

                $sql = "SELECT id,  usuario, password, tipo_usuario FROM usuarios WHERE usuario='$usuario'";
                $resultado = $mysqli->query($sql);
                $num = $resultado->num_rows;

                if ($num > 0) {
                    $row = $resultado->fetch_assoc();
                    $password_bd = $row['password'];
                    if ($password_bd == $password) {
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['usuario'] = $row['usuario'];
                        $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
                        header("Location:main.php");
                    } else {
                    ?>
                    <p><b>Usuario o Contraseña no son correctos</b></p>
                    <?php
                    }
                } else {
                ?>
                <p><b>No existe usuario</b></p>
                <?php
                }
            }
            ?>
        </div>
        </form>
    </main>

    <footer>
        <div class="descrition-footer">
            <p> Hecho por: Jean Vergara - Jesus Castillo // Sección: ALIN30231 // &copy; 2024 - All right reserved.</p>
        </div>

    </footer>
</body>
</html>