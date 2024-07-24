<?php 
require_once("../conexion.php");
$tipo_prestamo = $_POST["tipo_prestamo"];
$tasa = $_POST["tasa"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_fin = $_POST["fecha_fin"];
$Usuario_Creacion =  $_COOKIE["alias"];

$query = "INSERT INTO tasa_prestamo (tipo_prestamo, tasa, fecha_inicio, fecha_fin, Usuario_Creacion)
          VALUES ('$tipo_prestamo', '$tasa', '$fecha_inicio', '$fecha_fin', '$Usuario_Creacion')";

$result = mysqli_query($conn, $query);

if ($result) {
    $data = 1;
} else {
    $data = mysqli_error($conn) . "<br />\n";
}

mysqli_close($conn);

echo json_encode($data);
?>
