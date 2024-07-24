<?php
require_once("../conexion.php");
$sql = "
  SELECT
    id,
    tipo_prestamo,
    tasa,
    fecha_inicio,
    fecha_fin,
    fecha_creacion,
    usuario_creacion
  FROM
    tasa_prestamo";
$data = array();
$n = 0;
$result = mysqli_query($conn, $sql);
if ($result === false) {
  echo (mysqli_error($conn) . "<br />\n");
} else {
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[$n]["id"] = '<button type="button" class="btn btn-warning me-2" onclick="editar_tasa('.$row["id"].',\''.$row["tipo_prestamo"].'\','.$row["tasa"].',\''.date("Y-m-d", strtotime($row["fecha_inicio"])).'\',\''.date("Y-m-d", strtotime($row["fecha_fin"])).'\');"><i class="fas fa-edit"></i></button>';
    $data[$n]["tipo_prestamo"] = $row["tipo_prestamo"];
    $data[$n]["tasa"] = $row["tasa"];
    $data[$n]["fecha_inicio"] = date("Y-m-d", strtotime($row["fecha_inicio"]));
    $data[$n]["fecha_fin"] = date("Y-m-d", strtotime($row["fecha_fin"]));
    $data[$n]["fecha_creacion"] = $row["fecha_creacion"];
    $data[$n]["usuario_creacion"] = $row["usuario_creacion"];
    $n++;
}

}

echo json_encode($data, JSON_NUMERIC_CHECK);
?>
