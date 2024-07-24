<?php
require_once("../conexion.php");
$estado  = $_POST["Estado"];
if(isset($_COOKIE["alias"]))
{

	$Usuario_Creacion =  $_COOKIE["alias"];
}
else
{
	
}
//estado para mostrar la data
if($estado == 0)
{

	$sql = "
	SELECT
	  id,
	  solicitante,
	  monto,
	  plazo_meses,
	  tasa_interes,
	  estado,
	  fecha_solicitud
	FROM
	solicitud_prestamo
	ORDER BY
	  CASE estado
		  WHEN 'Pendiente' THEN 0
		  ELSE 1
	  END,
	  fecha_solicitud DESC";
  $data = array();
  $n = 0;
  $result = mysqli_query($conn, $sql);
  if ($result === false) {
	echo (mysqli_error($conn) . "<br />\n");
  } else {
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	  $data[$n]["id"] = '
	  <button type="button" class="btn btn-warning me-2" onclick="editar_prestamo('.$row["id"].',\''.$row["solicitante"].'\','.$row["monto"].','.$row["plazo_meses"].','.$row["tasa_interes"].',\''.$row["estado"].'\',\''.date("Y-m-d", strtotime($row["fecha_solicitud"])).'\');" title="Editar prestamo"><i class="fas fa-edit"></i></button>
	  <button type="button" class="btn btn-success me-2" onclick="aprobar_prestamo('.$row["id"].')" title="Aprobar prestamo"><i class="fas fa-check"></i></button>
	  <button type="button" class="btn btn-danger me-2" onclick="rechazar_prestamo('.$row["id"].')" title="Rechazar prestamo"><i class="fas fa-window-close"></i></button>';
  
	  $data[$n]["solicitante"] = $row["solicitante"];
	  $data[$n]["monto"] = number_format($row["monto"],2,'.',',');
	  $data[$n]["plazo_meses"] = $row["plazo_meses"];
	  $data[$n]["tasa_interes"] = $row["tasa_interes"];
	  $data[$n]["estado"] = $row["estado"];
	  $data[$n]["fecha_solicitud"] = date("Y-m-d", strtotime($row["fecha_solicitud"]));
	  $n++;
  }
  
  }
}
//aprobar solicitud de prestamo
else if($estado == 1)
{
	$id = $_POST["id"];
	$query = "
    UPDATE solicitud_prestamo 
    SET 
		estado = 'Aprobado',
        usuario_actualizacion = '$Usuario_Creacion'
    WHERE
        id = '$id'";
	$result = mysqli_query($conn, $query);
	if($result) {
		$data = 1;
	} else {
		$data = mysqli_error($conn) . "<br />\n";
	}
}
//rechazar solicitud de prestamo
else if($estado == 2)
{
	$id = $_POST["id"];
	$query = "
    UPDATE solicitud_prestamo 
    SET 
		estado = 'Rechazado',
        usuario_actualizacion = '$Usuario_Creacion'
    WHERE
        id = '$id'";
	$result = mysqli_query($conn, $query);
	if($result) {
		$data = 1;
	} else {
		$data = mysqli_error($conn) . "<br />\n";
	}
}
//si solicita los tipos de tasa de interes
elseif ($estado == 3) {
	$sql = "
	SELECT
	  id,
	  tipo_prestamo,
	  tasa
	FROM
	  tasa_prestamo";
  $data = array();
  $n = 0;
  $result = mysqli_query($conn, $sql);
  if ($result === false) {
	echo (mysqli_error($conn) . "<br />\n");
  } else {
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	  $data[$n]["tipo_prestamo"] = $row["tipo_prestamo"];
	  $data[$n]["tasa"] = $row["tasa"];
	  $n++;
  }
  
  }
}

echo json_encode($data, JSON_NUMERIC_CHECK);
?>
