<?php
require_once("../conexion.php");
$Usuario = $_POST["Usuario"];
$Contra = $_POST["Contra"];
$Usuario = strtoupper($Usuario);
$Contra = md5($Contra);
$data = array();
$n=0;
$query = "
    SELECT
        id,
        login_usuario,
        nombre_usuario
    FROM 
        usuario
    WHERE
        login_usuario = '$Usuario'
            AND
        password_usuario = '$Contra'
            AND
        estado_usuario = 'A'";
           
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows != 0) {
        $data = 1;   
    } else {
        $data = 0;
    }
} else {
    $data = $conn->error . "<br />\n";
}
$conn->close();


echo json_encode($data,JSON_NUMERIC_CHECK);
