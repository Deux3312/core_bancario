<?php 
require_once("../conexion.php");
$usuario = $_POST["usuario"];
$estado = $_POST["estado"];
$nombre = $_POST["nombre"];
$contrasena = $_POST["contrasena"];
$Contrasenia_Usuario = md5($contrasena); // Corregido el nombre de la variable
$correo = $_POST["correo"];
$fecha_actual = date("Y-m-d H:i:s");
$query = "INSERT INTO usuario(login_usuario,nombre_usuario,correo_usuario,estado_usuario,password_usuario)
VALUES('$usuario','$nombre','$correo','$estado','$Contrasenia_Usuario')";

$result = mysqli_query($conn, $query);

if($result)
{
    $data = 1;
}
else
{
    $data = mysqli_error($conn) . "<br />\n";
}

mysqli_close($conn);

echo json_encode($data);
?>
