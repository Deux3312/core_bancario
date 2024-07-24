<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './src/PHPMailer.php';
require './src/SMTP.php';
require './src/Exception.php';
require_once("../../conexion.php");
$detalle= "";
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username='solicitud.notificaciones@gmail.com';
$mail->Password='kjzbtmjtsobfrgje';
$mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port=587;
$mail->setFrom('solicitud.notificaciones@gmail.com', 'Informacion Laeisz');
//$mail->addAddress('juan.hirsch@grupolaeisz.com');
$mail->addAddress('brayan.medina@grupolaeisz.com');
$mail->addAddress('ena.martinez@grupolaeisz.com');
//$mail->addReplyTo('brayan.medina@grupolaeisz.com', 'Brayan Medina');
$mail->isHTML(true);
$mail->Subject = "Recordatorio Requisiciones";
//$mail->addEmbeddedImage('path/to/image_file.jpg', 'image_cid');
/*Realizando las peticiones de los querys*/
$dato = array();
$n=0;
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo =12
and com_empresa=1
limit 10";

$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
    $detalle.='
        <tr colspan="2">
            <td>Proyecto la Ensenada</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//ceiba
$sql1 = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo =10
and com_empresa=1
limit 10";
$result1 = pg_query($conn, $sql1);
if($result1 === false) {
  echo(pg_result_error($result1) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result1, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Proyecto Ceiba Térmica</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//juticalpa
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo =9
and com_empresa=1
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Proyecto Juticalpa</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//faro
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo =28
and com_empresa=2
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Proyecto el Faro</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//cummins
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo =15
and com_empresa=1
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Cummins</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//rentas
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo in (26,27)
and com_empresa=2
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Rentas Américas</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//gtc
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
--and monto_factura >50000
and com_centro_costo =47
and com_empresa=4
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>GTC</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//transpórtes
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
---and monto_factura >50000
and com_centro_costo =37
and com_empresa=3
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Transportes Américas</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//principal
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
and monto_factura >50000
and com_centro_costo in (1, 4, 5, 6, 7, 8, 16, 17, 18, 19, 20, 21, 22, 23
, 24, 25, 29, 30, 31, 32, 33, 34, 35, 36, 38, 39, 40, 41, 42, 43, 45, 46)
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
        $detalle.='
        <tr colspan="2">
            <td>Oficina Central</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}

//sub-estaciones
$sql = "
select
  count (a.com_no_solicitud) as solicitud
from
  com_solicitud_compra a
where
  a.com_estatus in ('PA')
  and monto_factura >50000
  and com_centro_costo =3
  and com_empresa=1
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
        $detalle.='
        <tr colspan="2">
            <td>Sub Estaciones</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//transpórtes Combustibles
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('C')
and com_centro_costo =37
and com_empresa=3
and com_tipo_solicitud=12
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Solicitud Combustible</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}

//proyecto Danli
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
---and monto_factura >50000
and com_centro_costo =48
and com_empresa=1
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Proyecto Danlí</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//proyecto Santa Rosa
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
---and monto_factura >50000
and com_centro_costo =50
and com_empresa=1
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Proyecto Santa Rosa</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}
//proyecto San Isidro
$sql = "
select
count (a.com_no_solicitud) as solicitud
from
com_solicitud_compra a
where
a.com_estatus in ('PA')
---and monto_factura >50000
and com_centro_costo =49
and com_empresa=1
limit 10";
$result = pg_query($conn, $sql);
if($result === false) {
  echo(pg_result_error($result) . "<br />\n");
}
else
{
  while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
    if($row["solicitud"]>0)
    {
            $detalle.='
        <tr colspan="2">
            <td>Proyecto San Isidro</td>
            <td>'.$row["solicitud"].'</td>
        </tr>';
    }
  }
}



/*Fin peticiones querys */
/*
foreach ($data as  $deta) {
    $detalle.='
    <tr colspan="2">
        <td>'.$nombre.'</td>
        <td>'.$conte.'</td>
    </tr>';

    //$detalle.=;
}*/

$mail->Body = utf8_decode('<!DOCTYPE html>
<html lang="en">
<head>
  <title>Correo Seguimiento Requisa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
td {
    margin: 5px;
    padding: 2px;
  }
</style>
<body>

<div class="container">
<div class="row" style="text-align:center;">
  <div class="col-md-1">
  </div>
  <div class="col-md-10">
    <h2>Detalle de Requisiciones</h2>
    <p>A continuación le detallamos las solicitudes pendientes de autorización. :</p>
  </div>
  <div class="col-md-1">
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:150px;">Departamento</th>
        <th style="width:100px;">    Pendientes    </th>
      </tr>
    </thead>
    <tbody style="text-align:center;">
      '.$detalle.'
    </tbody>
  </table>
  </div>
  <div class="row" style="text-align:center;">
  <div class="col-md-1">
  </div>
  <div class="col-md-10">
  <h2>Éste es un correo generado por el sistema, por favor no responder.</h2>
  </div>
  <div class="col-md-1">
  </div>
  </div>
</div>
</body>
</html>');
$mail->AltBody = 'This is the plain text version of the email content';
if($detalle != "")
{
  $fecha = date('Y-m-d'); // Fecha actual
  //$fecha = "2023-04-08"; // Fecha actual
  $diaSemana = date('N'); // Obtener el número de día de la semana
  //$diaSemana = 7; // Obtener el número de día de la semana

  // Verificar si el día es sábado o domingo (no es hábil)
  if ($diaSemana == 6 || $diaSemana == 7) {
      echo 'La fecha ' . $fecha . ' no es un día hábil.';
  }

  else
  {
    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        echo "<script>window.close();</script>";
    }
    else
    {
        echo 'Message has been sent';
        echo "<script>window.close();</script>";
    }
  }


}
else
{
    echo "No Existen Requisas Pendientes de Aprobar";
    echo "<script>window.close();</script>";
}
