<?php

require "conexion.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:index.php");
}

$id = $_SESSION['id'];
$usuario = $_SESSION['usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Censo de Controles de Estacionamiento</title>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <header>
        <nav>
            <a href="#" class="menu-toggle"><img src="./img/menu.svg" alt="Menu" width="30" height="30"></a>
            <ul class="menu">
                <li><a href="#Inicio">Inicio</a></li>
                <li><a href="#footer">Contacto</a></li>
                <li><a href="./salir.php">Salir</a></li>
            </ul>
        </nav>
    </header>
    <main id="Inicio" class="body">
        <section class="form-section">
        <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM censo WHERE id='$id'";
                $resultados = mysqli_query($mysqli, $sql);
                if (mysqli_num_rows($resultados) >  0) {
                    $filas = mysqli_fetch_assoc($resultados);
                    // Establece los valores predeterminados para los campos de entrada
                    $nombre = $filas['nombre'];
                    $apellido = $filas['apellido'];
                    $correo = $filas['correo'];
                    $telefono = $filas['telefono'];
                    $controles = $filas['controles'];
                    $estatus = $filas['estatus'];
                    ?>
                    <h1>Registrar Datos</h1>
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required>
                    <input type="text" name="apellido" placeholder="Apellido" value="<?php echo isset($apellido) ? $apellido : ''; ?>" required>
                    <input type="mail" name="correo" placeholder="Correo" value="<?php echo isset($correo) ? $correo : ''; ?>" required>
                    <input type="text" name="telefono" placeholder="Telefono" value="<?php echo isset($telefono) ? $telefono : ''; ?>" required>
                    <input type="number" name="controles" placeholder="Controles de Estacionamiento" value="<?php echo isset($controles) ? $controles : ''; ?>" required>
                    <select name="estatus" id="" required>
                        <option selected disabled>Seleccionar Estatus</option>
                        <option value="Solvente" <?php echo isset($estatus) && $estatus == 'Solvente' ? 'selected' : ''; ?>>Solvente</option>
                        <option value="Por Validar" <?php echo isset($estatus) && $estatus == 'Por Validar' ? 'selected' : ''; ?>>Por Validar</option>
                        <option value="Moroso" <?php echo isset($estatus) && $estatus == 'Moroso' ? 'selected' : ''; ?>>Moroso</option>
                    </select>
                    <?php
                }
            }else {
                ?>
                    <h1>Registrar Datos</h1>
                    <input type="hidden" name="id" value="">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                    <input type="mail" name="correo" placeholder="Correo" required>
                    <input type="text" name="telefono" placeholder="Telefono" required>
                    <input type="number" name="controles" placeholder="Controles de Estacionamiento" required>
                    <select name="estatus" id="" required>
                        <option selected disabled>Seleccionar Estatus</option>
                        <option value="Solvente">Solvente</option>
                        <option value="Por Validar">Por Validar</option>
                        <option value="Moroso">Moroso</option>
                    </select>
                <?php
            }
                    ?>
                    <button type="submit" name="registrar">Registrar</button>
                    <?php
                    if (isset($_POST["registrar"])) {
                        $id = $_POST['id'];
                        $nombre = $_POST['nombre'];
                        $apellido = $_POST['apellido'];
                        $correo = $_POST['correo'];
                        $telefono = $_POST['telefono'];
                        $controles = $_POST['controles'];
                        $estatus = $_POST['estatus'];
                        if (!empty($_POST['id'])) {
                            $id = $_POST['id'];
                            $sql = "UPDATE censo SET nombre='$nombre', apellido='$apellido', correo='$correo', telefono='$telefono', controles=$controles, estatus='$estatus' WHERE id='$id'";
                            ?>
                            <div class="text"><p><b>Datos actualizados con éxito.</b></p></div>
                            <?php
                        } else {
                            $sql = "INSERT INTO censo (nombre, apellido, correo, telefono, controles, estatus) VALUES('$nombre', '$apellido', '$correo', '$telefono', $controles, '$estatus')";
                            $resultado = mysqli_query($mysqli, $sql) or trigger_error("Query failed! SQL - error: " . mysqli_error($mysqli), E_USER_ERROR);
                            ?>
                            <div class="text"><p><b>Datos insertados con éxito.</b></p></div>
                            <?php
                        }
                    }
                    ?>
                    <hr/>
                    <div class="report">
                        <a href="./reporte.php" target="_blank"><img src="./img/report.svg" alt="Reporte" width="20" height="20"> Ver Reporte</a>
                    </div>
                </form>
        </section>
        <section class="table-section">
            <table>
            <?php
                $sql = "SELECT id, nombre, apellido, correo, telefono, controles, estatus FROM censo";
                $resultado = mysqli_query($mysqli, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                ?>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Controles de Est.</th>
                        <th>Estatus</th>
                        <th><img src="./img/list.svg" alt="Lista" width="20" height="20"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                ?>
                    <tr>
                        <th><?php echo $fila['nombre']; ?></th>
                        <th><?php echo $fila['apellido']; ?></th>
                        <th><?php echo $fila['correo']; ?></th>
                        <th><?php echo $fila['telefono']; ?></th>
                        <th><?php echo $fila['controles']; ?></th>
                        <th><?php echo $fila['estatus']; ?></th>
                        <th>
                            <a href="?id=<?php echo $fila['id']; ?>" class="update"><img src="./img/update.svg" alt="actualizar" width="20" height="20" class="update"></a>
                            <a href="eliminar.php?id=<?php echo $fila['id']; ?>" class="delete"><img src="./img/delete.svg" alt="borrar" width="20" height="20" class="delete"></a>
                        </th>
                    </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer id="footer">
        <p> Hecho por: Jean Vergara - Jesus Castillo // Sección: ALIN30231 // &copy; 2024 - All right reserved.</p>
    </footer>
    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.menu').classList.toggle('show');
        });
    </script>
</body>
</html>
