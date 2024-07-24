<?php
require_once("../conexion.php");
$Usuario =  strtoupper($_COOKIE["alias"]);
$Usuario_Actualizacion =  strtoupper($_COOKIE["alias"]);
$contrasena_anterior=$_POST["contrasena_anterior"];
$contrasena_anterior=md5($contrasena_anterior);
$contrasena_nueva=$_POST["contrasena_nueva"];
$contrasena_nueva=md5($contrasena_nueva);
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
            password_usuario = '$contrasena_anterior'
                AND
            estado_usuario = 'A'";
           
$result = mysqli_query($conn, $query);

if ($result) 
{
    if (mysqli_num_rows($result) !=0) 
    {
        while ($row = mysqli_fetch_row($result)) {
            //Si el usuario y la contraseña es correcta realizamos la actualizacion
            $query = "
            UPDATE 
                usuario
            SET 
                password_usuario='$contrasena_nueva'
            WHERE 
                id='$row[0]'";
            //echo $query;
            $result_update = mysqli_query($conn, $query);
            if ($result_update) {
                $data=1;
            }
            else
            {
                $data = mysqli_error($conn) . "<br />\n";
            }
        }
        

    }
    else 
    {
        
        $data ="Usuario no encontrado";
    }
}
else 
    {
        
        $data ="Usuario no encontrado";
    }
mysqli_close($conn);

echo json_encode($data,JSON_NUMERIC_CHECK);
?>
