<?php 
require_once("../conexion.php");
$id_usuario = $_POST["id_usuario"];
$usuario = $_POST["usuario"];
$id_usuario = $_POST["id_usuario"];
$estado = $_POST["estado"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$contrasena = md5($_POST["contrasena"]);
$Usuario_Creacion =  $_COOKIE["alias"];

$query = "
    UPDATE usuario 
    SET 
        login_usuario = '$usuario',
        nombre_usuario = '$nombre',
        correo_usuario = '$correo',
        estado_usuario = '$estado',
        password_usuario = '$contrasena',
        usuario_actualizacion = '$Usuario_Creacion'
    WHERE
        id = '$id_usuario'";

$result = mysqli_query($conn, $query);

if($result) {
    $data = 1;
} else {
    $data = mysqli_error($conn) . "<br />\n";
}

mysqli_close($conn);

echo json_encode($data);
?>
