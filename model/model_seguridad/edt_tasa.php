<?php 
require_once("../conexion.php");
$tipo_prestamo = $_POST["tipo_prestamo"];
$tasa = $_POST["tasa"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_fin = $_POST["fecha_fin"];
$id = $_POST["id"];
$Usuario_Creacion =  $_COOKIE["alias"];

$query = "
    UPDATE tasa_prestamo 
    SET 
        tipo_prestamo = '$tipo_prestamo',
        tasa = '$tasa',
        fecha_inicio = '$fecha_inicio',
        fecha_fin = '$fecha_fin',
        usuario_actualizacion = '$Usuario_Creacion'
    WHERE
        id = '$id'";

$result = mysqli_query($conn, $query);

if($result) {
    $data = 1;
} else {
    $data = mysqli_error($conn) . "<br />\n";
}

mysqli_close($conn);

echo json_encode($data);
?>
