<?php

ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/Proyecto-UNEXCA/css/main.css">
    <title>Document</title>
</head>
<body>
    <?php
    require "conexion.php";
    session_start();
    ?> 
    <center><h1>REPORTE DE CENSO</h1></center>
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
                    </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
</body>
</html>
<?php
$html=ob_get_clean();
//echo $html;

require_once './libreria/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml("$html");

$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("reporte.pdf", array("Attachment" => false));
?>