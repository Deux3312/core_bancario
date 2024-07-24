<?php 
require_once("../conexion.php");
$nombre = $_POST["nombre"];
$monto = str_replace(',', '', $_POST["monto"]);
$plazo_meses = $_POST["plazo"];
$interes = $_POST["interes"];
$detalle_solicitud = $_POST["detalle_solicitud"];
$data =array();
$query = "INSERT INTO solicitud_prestamo (solicitante, monto, plazo_meses, tasa_interes)
          VALUES ('$nombre', '$monto', '$plazo_meses', '$interes')";

$result = mysqli_query($conn, $query);

if ($result) {
    // Obtener el ID de la fila insertada
    $id_insertado = mysqli_insert_id($conn);
    foreach ($detalle_solicitud as $pagos) {
        $numero_pago = $pagos["pago"];
        $fecha_pago = $pagos["fecha_pago"];
        $fecha_pago_mysql = date('Y-m-d', strtotime($fecha_pago)); 
        $cuota_mensual_raw = $pagos["cuota_mensual"];
        $cuota_mensual_cleaned = preg_replace('/[^0-9.,]/', '', $cuota_mensual_raw);
        $cuota_mensual_decimal = str_replace(',', '.', $cuota_mensual_cleaned);
        $query_detalle = "INSERT INTO detalle_pago (id_credito, numero_pago, fecha_pago, monto, Usuario_Creacion)
                          VALUES ('$id_insertado', '$numero_pago', '$fecha_pago_mysql', '$cuota_mensual_cleaned', '$nombre')";
    
        $result_detalle = mysqli_query($conn, $query_detalle);
    
        if ($result_detalle) {
            $data = 1;
        } else {
            $data = mysqli_error($conn) . "<br />\n";
        }
    }
    
    
} else {
    $data = mysqli_error($conn) . "<br />\n";
}

mysqli_close($conn);

echo json_encode($data);
?>
