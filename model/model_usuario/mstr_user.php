<?php 
require_once("../conexion.php");
$id_usuario=$_POST["id_usuario"];
$sql = "
  SELECT 
    id,
    login_usuario,
    nombre_usuario,
    correo_usuario,
    estado_usuario,
    Fecha_Creacion as fecha
  FROM 
    usuario
  Where
    id = '$id_usuario'";
$data = array();
$n=0;
$result = mysqli_query($conn, $sql);
if($result === false) {
  echo(mysqli_error($conn) . "<br />\n");
}
else
{ 
  while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
    //print_r($row);
    //se le quitó al .html /?id='.$row["Id"].'
  $data[$n]["id"] = '<button type="button"  class="btn btn-warning me-2" onclick="mandar_solicitud('.$row["id"].')"><i class="fas fa-edit"></i></button>';
  $data[$n]["usuario"] = $row["login_usuario"];
  $data[$n]["nombre"] = $row["nombre_usuario"];
  $data[$n]["correo"] = $row["correo_usuario"];
  $estado = $row["estado_usuario"];
  if ($estado == 'A') {
    $data[$n]["estado"] = 'ACTIVO';
  }
  else {
    $data[$n]["estado"] = 'INACTIVO';
  }
  $date = new DateTime($row["fecha"]);
  $fecha = $date->format('Y-m-d H:i:s');
  $data[$n]["fecha"] =  $fecha;
  
  //s$data[$n] = $row;
  $n++;
    //$data = $row['Nombre_Usuario'].", ".$row['Correo_Usuario']."<br />";
    
}
}

echo json_encode($data,JSON_NUMERIC_CHECK);
?>
