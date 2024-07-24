<?php
require_once("../conexion.php");
require '../../plugins/PDFS/vendor/autoload.php';
require_once '../../plugins/PDFS/vendor/dompdf/dompdf/autoload.inc.php';
$requisa = $_GET["requisa"];
/*$logo = "http://".$_SERVER["HTTP_HOST"]. $_SERVER["PHP_SELF"];
$logo = str_replace("imprimir_requisa.php", "../../plugins/images/logo_clh.png", $logo);
$logo = "data:image/png;base64," . base64_encode(file_get_contents($logo));*/
$sql="select
a.com_no_solicitud no_solicitud,
(
select
    b.descripcion
from
    empresa b
where
    a.com_empresa = b.id)empresa,

    to_char(a.com_fecha, 'DD-MM-YYYY')fecha_creacion,
(
    select
        e.nombre_usuario
    from
        usuario e
    where
        a.com_usr_creador = e.id_usuario) Usuario,
(
select
    c.descripcion
from
    departamento c
where
    a.com_centro_costo = c.id
    and a.com_empresa = c.empresa) centro_costo,

(
select
    d.descripcion
from
    tipo_solicitud d
where
    a.com_tipo_solicitud = d.id)tipo_solicitud,
    a.com_estatus  estado_solicitud,
    a.com_tipo_solicitud as t_soli,
a.com_observacion observacion ,
(
    select
        e.nombre_usuario
    from
        usuario e
    where
        a.com_usr_autoriza = e.id_usuario) usuario_aprobo,
to_char(a.com_fec_autoriza , 'DD/MM/YYYY') as fecha_aprobaciones,
(select to_char(current_timestamp, 'DD-MM-YYYY HH24:MI ')
 from com_solicitud_compra limit 1)fecha_sistema,
 (
    select
        b.logo
    from
        empresa b
    where
        a.com_empresa = b.id)logo_empresa,
        a.com_dirigido_a as proveedor,
        a.com_fec_vencimiento as fecha_vencimiento,
        a.com_fec_pendiente_apr as fecha_aprobacion,
        a.monto_factura,
        (
            select
                e.nombre_usuario
            from
                usuario e
            where
                a.usr_apr_pendiente_revision = e.id_usuario) as usr_apr_pendiente_revision,
                to_char(a.fec_apr_pendiente_revision, 'DD-MM-YYYY') fecha_autorizar,
                a.com_centro_costo,
                a.com_solicitud_justificacion
from
com_solicitud_compra a
where
a.com_solicitud ='$requisa'
";
$result = pg_query($conn,$sql);
$solicitud_no =0;
$empresa = "";
$fecha_creacion="";
$usuario_creador="";
$centro_costo="";
$tipo_solicitud="";
$estado="";
$observacion="";
$usuario_aprobo="";
$fecha_aprobacion="";
$proveedor="";
$fecha_vencimiento ="";
$data_aprobacion = "";
$justificacion ="";
$tipo_soli = "";
if ($result)
{
    while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
        $solicitud_no =$row["no_solicitud"];
        $empresa = $row["empresa"];
        setlocale(LC_ALL,"spanish");
        $newDate = date("d-m-Y", strtotime($row["fecha_creacion"]));
        $fecha_creacion = strftime("%d/%m/%Y", strtotime($newDate));
        $fecha_sistema = strftime("%d/%m/%Y %H:%M", strtotime(date("d-m-Y h:m", strtotime($row["fecha_sistema"]))));
        $usuario_creador=$row["usuario"];
        $centro_costo=$row["centro_costo"];
        $tipo_solicitud=$row["tipo_solicitud"];
        $logo_empresa=$row["logo_empresa"];
        $estado=$row["estado_solicitud"];
        if ($estado == 'C') {
            $estado = 'CREADA';
          }
          else if($estado == 'CA'){
            $estado = 'CANCELADA';
          }
          else if($estado == 'R'){
            $estado = 'RECHAZADA';
          }
          else if($estado == 'D'){
            $estado = 'DENEGADA';
          }
          else if($estado == 'A'){
            $estado = 'APROBADA';
          }
          else if($estado == 'CT'){
            $estado = 'EN PROCESO';
          }
          else if($estado == 'F'){
            $estado = 'EMITIDA';
          }
          else if($estado == 'PA'){
            $estado = 'PENDIENTE AUTORIZAR';
          }
          else if($estado == 'AU'){
            $estado = 'AUTORIZADO';
          }else if($estado == 'VF'){
       			$estado = 'VISTO BUENO TECNICO';
       		}else if($estado == 'V'){
       		 $estado = 'VISTO BUENO TECNICO VERIFICADO ';
       	 }
         else if($estado == 'OC')
         {
           $estado = 'ORDEN DE COMPRAS ';
         }
         /*else if($estado == 'OC'){
          $data[$n]["estado"] = 'ORDEN DE COMPRAS';
        }*/
        $observacion=$row["observacion"];
        $justi = $row["com_solicitud_justificacion"];
        $proveedor=$row["proveedor"];
        $date = new DateTime($row["fecha_vencimiento"]);
	       $fecha_vencimiento = $date->format('Y-m-d');
         if($row["estado_solicitud"]=='C')
         {
           $usuario_aprobo="";
         }
         else
         {
           $usuario_aprobo=$row["usuario_aprobo"];
         }

        $fecha_aprobacion=$row["fecha_aprobaciones"];
        $detalle_proveedor = "";
        if($row["t_soli"]  == 6)
        {
          $detalle_proveedor = '<h4 class="titulo" style="margin-top:10px;"><b>Dirigido a:</b> '.$proveedor.'</h>
          <h4 class="titulo" style="margin-top:10px;"><b>Fecha Vencimiento:</b> '.$fecha_vencimiento.'</h4>';
          $tipo_soli = "SOLICITUD DE PAGOS DIRECTOS";
        }
        elseif ($row["t_soli"]  == 7)
        {
          $detalle_proveedor = '<h4 class="titulo" style="margin-top:10px;"><b>Dirigido a:</b> '.$proveedor.'</h>';
          $tipo_soli = "SOLICITUD DE CAJA CHICA";
        }
        else
        {
          $detalle_proveedor = "";
          $tipo_soli = "SOLICITUD DE REQUISICIONES";
        }
        if($row["fecha_aprobacion"])
        {
            $data_aprobacion = '
            <br>
            <br>
            <div style="position:absolute;
            margin:0;
            padding:0;
            margin-top:1px; ">

                <h4 class="titulo"><b>Autorizador:</b> '.$row["usr_apr_pendiente_revision"].'</h4>
            </div>

            <div style="position:absolute;>
            margin:0;
            padding:0;
            margin-top:1px;">
               <h4 class="titulo" style=" margin-left: 355px;"><b>Monto Autorizado:</b> '.number_format($row["monto_factura"],2,".",",").'</h4>
            </div>
            <br>
            <br>
              <div style="position:absolute;>
                margin:0;
                padding:0;
                margin-top:1px;">
                  <h4 class="titulo"><b>Fecha Autorizado:</b> '.$row["fecha_autorizar"].'</h4>
                </div>'
            ;
        }
        //realizando la validacion para imprimir la justificacion
        if($row["com_centro_costo"] ==  3 || $row["com_centro_costo"]  == 9 || $row["com_centro_costo"]  == 10 || $row["com_centro_costo"]  ==12 || $row["com_centro_costo"]  ==28 || $row["com_centro_costo"] ==48|| $row["com_centro_costo"] ==49|| $row["com_centro_costo"] ==50)
        {
            if($row["tipo_solicitud"]!=7)
            {
            $justificacion='<h4 class="titulo" ><b>Justificación:</b> '.$justi.'</h4>';
            }
            else
            {
            $justificacion="";
            }
        }
        else
        {
            $justificacion="";
        }
        if($row["com_centro_costo"] ==  16 || $row["com_centro_costo"]  == 35)
        {
            $justificacion='<h4 class="titulo" ><b>Justificación:</b> '.$justi.'</h4>';

        }
        else
        {
            $justificacion="";
        }
    }
}
else
{
    $data = pg_result_error($result) . "<br />\n";
}

$query="select
b.com_det_cantidad cantidad,

(
select
    d.des_unidad_medida
from
    com_unidad_medida d
where
    b.com_det_unidad = d.id )unidad,
b.com_det_articulo articulo,
b.com_bodega bodega
from
com_solicitud_compra_detalle b
where
b.com_det_solicitud ='$requisa'";
$productos="";
$resulta = pg_query($conn,$query);
if ($resulta)
{
    $x=1;
    while( $row = pg_fetch_array($resulta, NULL, PGSQL_ASSOC) ) {
        $productos .= "
        <tr>
            <td class='final' style='border-right: 1px none #8C8C8C; height: 17px;'>
                <span class='Money'>".$x."&nbsp;</span>
            </td>
            <td class='final' style='border-right: 1px none #8C8C8C; height: 17px;'>
                <span class='Money'>".$row["articulo"]."&nbsp;</span>
            </td>
            <td  style='border-right: 1px none #8C8C8C; height: 17px;'>
                &nbsp;".number_format($row["cantidad"],2,".",",")."
            </td>
            <td style='border-right: 1px none #8C8C8C; height: 17px;'>
                &nbsp;".$row["unidad"]."
            </td'>
            <td class='final'>
                <span class='Money'>".$row["bodega"]."&nbsp;</span>
            </td>
        </tr>
    ";
    $x++;
    }
}
else
{
    $data = pg_result_error($result) . "<br />\n";
}

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  user-scalable=0, minimal-ui">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>
/*visualización en navegador*/
#detalle_solicitud {
    padding: 3 10 3 10px;
    text-align: center;
    clear: both;
}

/*Visualización de impresión de la página*/

BODY {
    font: 10pt Verdana, Geneva, Arial, Helvetica, sans-serif;
    margin: 10 0 10 0px;
    text-align: center;
    background-color: #ffffff;
}
#contenedor {
    text-align: left;
    width: 600px;
    margin: auto;
}

#logo {
    visibility: visible;
    margin-left:3px;
    margin-top:30px;
    float:left;
    clear: left ;
}

#cuerpo {
    margin: 5 0 5 12px;
}

.detalle_solicitud {
    width: 100%;
    /*height: 100%;*/
    justify-content: center;
    column-gap: 2rem;
}

h4{
    font-weight: normal!important;
}


}
.fecha{
    position:absolute;
    bottom:0;
    right:0;
}

</style>
<body style="text-align: left; width: 600px; margin: auto;">
    <!-- Inicio contenedor-->
    <div id="contenedor">

        <!-- Encabezado Titulos-->

            <div id="logo">
              <img src="'.$logo_empresa.'" alt="logo.png" width="140px ">
            </div>
              <div>
                <h1 class="titulo" style=" margin-left: 200px;"><b>'.$empresa.'</b></h1>
                <h3 class="titulo" style=" margin-left: 190px;">'.$tipo_soli.'</h3>
                <h3 class="titulo" style=" margin-left: 250px;">No. Solicitud: <b>'.$solicitud_no.'</b></h3>
                <h4 class="titulo" style="margin-left: 223px;"><b>Fecha Creación: '.$fecha_creacion.'</b></h4>


              </div>

            <!--Fin encabezado Titulos-->

        <!--Encabezado de la solicitud -->
        <div id="cuerpo" style="font-weight: normal!important;" >
           <h4 class="titulo" style="margin-top:20px;"><b>Usuario:</b> '.$usuario_creador.'</h4>
           <h4 class="titulo" style="margin-top:-10px;"><b>Centro de Costo:</b> '.$centro_costo.'</h4>

           <div style="position:absolute;
           margin:0;
           padding:0;
           margin-top:-27px;">
               <h4 class="titulo"><b>Tipo Solicitud:</b> '.$tipo_solicitud.'</h4>
           </div>

           <div style="position:absolute;>
           margin:0;
           padding:0;
           margin-top:-27px;">
            <h4 class="titulo" style=" margin-left: 355px;"><b>Estado Solicitud:</b> '.$estado.'</h4>
           </div>

           <div style="position:absolute;
           margin:0;
           padding:0;
           margin-top:1px; ">

               <h4 class="titulo"><b>Aprobó:</b> '.$usuario_aprobo.'</h4>
           </div>

           <div style="position:absolute;>
           margin:0;
           padding:0;
           margin-top:1px;">
              <h4 class="titulo" style=" margin-left: 355px;"><b>Fecha Aprobó:</b> '.$fecha_aprobacion.'</h4>
           </div>

           '.$data_aprobacion.'

          <h4 class="titulo" style="margin-top:48px;"><b>Observación:</b> '.$observacion.'</h4>
          '.$justificacion.'
          '.$detalle_proveedor.'

        </div>  <!--Fin encabezado de la solicitud -->

        <div id="detalle_solicitud">  <!--Detalle de la solicitud tabla-->
          <hr style="height:0px; background-color:black">
            <table class="detalle_solicitud" >
                <tr style="font: 10pt Verdana, Geneva, Arial, Helvetica, sans-serif">
                    <td><b>No.</b></td>
                    <td><b>ARTICULO</b></td>
                    <td><b>CANTIDAD</b></td>
                    <td><b>UNIDAD</b></td>
                    <td><b >BODEGA</b></td>
                </tr>
                <tbody>
                '.$productos.'
                </tbody>
            </table>
            <hr style="height:0px; background-color:black">
        </div>
        <!--Fin detalle de la solicitud tabla-->
        <br>
        <br>
        <br>
        <div>
            <!--Lineas Horizontales-->
            <center>
            <div style="position:absolute;
                left:3px;
                width:370px;
                margin-top:0px;">
                <h4>'.$usuario_creador.'</h4><hr style="width:60%" , size="3" , color=black>
                <h4>Solicitado por</h4>
            </div>
            <div style="position:absolute;>
               right:2px;
               width:700;
               margin-top:0px;">
               <h4>'.$usuario_aprobo.'</h4><hr style="width:24%" , size="3" , color=black>
               <h4>Aprobado por</h4>
            </div>
         </center>
            <!--Fin lineas Horizontales-->
        </div>
    </div> <!-- Fin contenedor-->


    <div>
    <p class="fecha">'.$fecha_sistema.'</p>
    </div>

    <footer class="footer">
        <center>
            <h5 style=margin-top:150px;>*** Los nombres de usuarios representan las personas que crearon y/o aprobaron en el sistema.</h5>
        </center>
</footer>
</body>

</html>
';


/*
echo $html;
*/

use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('carta', 'portrait');

$dompdf->loadHtml($html);


// Render the HTML as PDF
$dompdf->render();
$dompdf->stream("Factura .pdf", ['Attachment' => false]);
// Output the generated PDF to Browser
//$dompdf->stream();
/**/
