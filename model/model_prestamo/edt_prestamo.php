<?php
require_once("../conexion.php");
$tipo_solicitud = $_POST["tipo_solicitud"];
$estado = $_POST["estado"];
$fecha = $_POST["fecha"];
$descripcion = $_POST["descripcion"];
$departamento = $_POST["departamento"];
$solicitante =  $_POST["solicitado_por"];
$id_requisa = $_POST["id_solicitud"];
$empresa = $_POST["empresa"];
$internacional = $_POST["internacional"];
$Usuario_Creacion =  $_COOKIE["alias"];
pg_set_client_encoding($conn, "UTF-8");
date_default_timezone_set("America/Tegucigalpa");
$fecha_actual = date("Y-m-d H:i:s");
$aprobadores=$_POST["aprobador"];
//nuevo
$dirigido=$_POST["dirigido"];
$justificacion = $_POST["justificacion"];
$fecha_vencimiento_pago=$_POST["fecha_vencimiento_pago"];
$data =0;
//verificando los arrays que no vengan vacios
if(empty( $_POST["detalle_requisa"]))
{
    $detalle_solicitud = array();
}
else
{
    $detalle_solicitud = $_POST["detalle_requisa"];
}
//validando si no vienen departamentos nuevos para el usuario
if(empty($_POST["detalle_requisa_antiguo"]))
{
    $detalle_solicitud_antiguo = array();
    /* Realizando el borrado del detalle de la solicitud*/
    $query="
    DELETE FROM
        com_solicitud_compra_detalle
    where
        com_det_solicitud = '$id_requisa'";
    $result = pg_query($conn,$query);
    if($result)
    {
        $data .= 1;
    }
    else
    {
        $data = pg_result_error($result) . "<br />\n";
    }
}
else
{
    $detalle_solicitud_antiguo = $_POST["detalle_requisa_antiguo"];
}
//Realizando la verificacion para las actualizaciones
$query="
update
	com_solicitud_compra
set
	com_empresa = '$empresa',
	com_tipo_solicitud = '$tipo_solicitud',
	com_centro_costo = '$departamento',
	com_estatus = '$estado',
	com_observacion = '$descripcion',
	tipo_compra = '$internacional',
	com_usr_modificador = '$Usuario_Creacion',
	com_fec_modificacion = '$fecha_actual',
    com_usr_autoriza = '$aprobadores',
	com_dirigido_a= '$dirigido',
    com_solicitud_justificacion = '$justificacion',
    com_fec_vencimiento = '$fecha_vencimiento_pago'
where
	com_solicitud = '$id_requisa'";
$result = pg_query($conn,$query);
if($result)
{

    //realizando la actualizacion del detalle anterior
    foreach($detalle_solicitud_antiguo as $detalle)
    {
        
        $producto = html_entity_decode($detalle["producto"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $cantidad = floatval(str_replace(",","",$detalle["cantidad"]));
        $unidad = $detalle["unidad"];
        if(empty($detalle["id_producto_gp"]))
        {
            $producto_gp =  "";
        }
        else
        {
            $producto_gp = $detalle["id_producto_gp"];
        }
        $tipo_inventario = $detalle["inventariado"];
        if(empty($detalle["bodega"]))
        {
            $bodega = "";
        }
        else
        {
            $bodega = $detalle["bodega"];
        }

        $id_registro=$detalle["id_registro"];
        $query = "
        update
        com_solicitud_compra_detalle
    set
        com_bodega = '$bodega',
        com_det_articulo = '$producto',
        com_det_cantidad = '$cantidad',
        com_det_unidad = '$unidad',
        com_usr_modificador = '$Usuario_Creacion',
        com_fec_modificacion = '$fecha_actual',
        com_tipo_inv = '$tipo_inventario',
        com_id_prod_gp = '$producto_gp'
    WHERE
        com_id= ' $id_registro'";

        $result = pg_query($conn,$query);
        if($result)
        {
            $data .= 1;
        }
        else
        {
            $data = pg_result_error($result) . "<br />\n";
        }
    }
    //realizando la insercion del nuevo detalle
    foreach($detalle_solicitud as $detalle)
    {
        //$producto= strtoupper($detalle["producto"]);
        $producto = html_entity_decode($detalle["producto"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $cantidad = floatval(str_replace(",","",$detalle["cantidad"]));
        $unidad = $detalle["unidad"];
        //$producto_gp = $detalle["id_producto_gp"];
        $tipo_inventario = $detalle["inventariado"];
        if(empty($detalle["id_producto_gp"]))
        {
            $producto_gp = "";
        }
        else
        {
            $producto_gp = $detalle["id_producto_gp"];
        }
        if(empty($detalle["bodega"]))
        {
            $bodega = "";
        }
        else
        {
            $bodega = $detalle["bodega"];
        }
        //$bodega = explode( '-',$bodega);
        //$bodega_n=$bodega[0];
        //realizando la verificacion de la data que ya existe
        $query = "
        SELECT
            com_id
        FROM
            com_solicitud_compra_detalle
        WHERE
        com_det_solicitud = '$id_requisa' AND
        com_bodega = '$bodega' AND
        com_det_articulo = '$producto' AND
        com_det_cantidad = '$cantidad' AND
        com_det_unidad = '$unidad'";
       // echo $query;

        $result = pg_query($conn, $query);
        if (pg_num_rows($result) == 0 )
        {
            $query = "
            INSERT INTO com_solicitud_compra_detalle
                (
                com_det_solicitud,
                com_bodega,
                com_det_articulo,
                com_det_cantidad,
                com_det_unidad,
                com_usr_creador,
                com_fec_creacion,
                com_id_prod_gp,
                com_tipo_inv)
            VALUES(
                '$id_requisa',
                '$bodega',
                '$producto',
                '$cantidad',
                '$unidad',
                '$Usuario_Creacion',
                '$fecha_actual',
                '$producto_gp',
                '$tipo_inventario')";

            $result = pg_query($conn,$query);
            if($result)
            {
                $data .= 1;
            }
            else
            {
                $data = pg_result_error($result) . "<br />\n";
            }
        }

    }
}
else
{
    $data = pg_result_error($result) . "<br />\n";
}
pg_close($conn);

echo json_encode($data);
