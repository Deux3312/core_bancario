<?php 
require_once("../conexion.php");
$sql = "
  SELECT 
    Id,
    Id_Usuario,
    Nombre_Usuario,
    Correo_Usuario,
    Estado_Usuario,
    Ubicacion_Usuario,
    convert(char, Fecha_Creacion,120) as Fecha
  FROM 
    Usuario2";
$data = array();
$n=0;
$result = sqlsrv_query($conn, $sql);
if($result === false) {
    $data = "Problemas en query";
}
else
{ 
  while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {


    $data[$n]["id"] = '<button type="button" class="btn btn-warning me-2" onclick="editar_usuario('.$row["Id"].');"><i class="fas fa-edit"></i></button>';
  $data[$n]["usuario"] = $row["Id_Usuario"];
  $data[$n]["nombre"] = $row["Nombre_Usuario"];
  $data[$n]["correo"] = $row["Correo_Usuario"];
  $estado = $row["Estado_Usuario"];
  if ($estado == 'A') {
    $data[$n]["estado"] = 'ACTIVO';
  }
  else {
    $data[$n]["estado"] = 'INACTIVO';
  }
  $data[$n]["ubicacion"] = $row["Ubicacion_Usuario"];
  $data[$n]["fecha"] = $row["Fecha"];
  
  //s$data[$n] = $row;
  $n++;
    //$data = $row['Nombre_Usuario'].", ".$row['Correo_Usuario']."<br />";
    
}
}

echo json_encode($data,JSON_NUMERIC_CHECK);
sqlsrv_free_stmt( $result);
