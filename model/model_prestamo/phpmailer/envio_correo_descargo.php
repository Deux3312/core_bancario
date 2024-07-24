<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './src/PHPMailer.php';
require './src/SMTP.php';
require './src/Exception.php';
require_once("../../conexion.php");
$mail = new PHPMailer(true);
$descargoNo = $_POST["descargoNo"];
$descargoId = $_POST["descargoId"];
$Usuario = strtoupper($_COOKIE["alias"]);
/*Validaciones de Cada Campo*/
if(!$_POST) exit;

// Verificación del Correo (No tocar)
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$nya    = $_POST['nya'];
$email    = $_POST['email'];
$adjunto_correo = $_FILES['adjunto_correo'];
$mensaje    = $_POST['mensaje'];


if(trim($nya) == '') {
  $a = 0;
  $b = '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor, ingresa tus Nombres y Apellidos.</div>';

  $dab = array(
    "a" => $a,
    "b" => $b
  );

  echo (json_encode($dab));
	exit();

} else if(trim($email) == '') {
  $a = 0;
  $b = '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor, ingresa tu Email.</div>';

  $dab = array(
    "a" => $a,
    "b" => $b
  );

  echo (json_encode($dab));
	exit();

} /*else if($_FILES['adjunto_correo']['size'] == 0) {
  $a = 0;
  $b = '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor, sube una imagen en Formato JPG, PNG o GIF.</div>';

  $dab = array(
    "a" => $a,
    "b" => $b
  );

  echo (json_encode($dab));
	exit();

}  */else if(trim($mensaje) == '') {
  $a = 0;
  $b = '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor, ingresa tu Mensaje.</div>';

  $dab = array(
    "a" => $a,
    "b" => $b
  );

  echo (json_encode($dab));
  exit();

}

// Subir Archivo
@mkdir("../../../views/view_descargo/adjuntos_correo/".$descargoNo."", 0700);
  $file_name =  $_FILES['adjunto_correo']['name']; //getting file name
  $tmp_name = $_FILES['adjunto_correo']['tmp_name']; //getting temp_name of file
  $file_up_name = time().$file_name; //making file name dynamic by adding time before file name

$directorio_destino = "../../../views/view_descargo/adjuntos_correo/".$descargoNo."/";
$archivo_destino = $directorio_destino . basename($_FILES["adjunto_correo"]["name"]);
$uploadOk = 1;
$formatoImagen = strtolower(pathinfo($archivo_destino,PATHINFO_EXTENSION));
// Verificamos si la imagen es falsa o no
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["adjunto_correo"]["tmp_name"]);
    if($check !== false) {
        // echo "Mensaje";
        $uploadOk = 1;
    } else {
        // echo "Mensaje";
        $uploadOk = 0;
    }
}
// Verificamos el tamaño de la imagen
if (round($_FILES['adjunto_correo']["size"] / 1024) > 8192) {

    $uploadOk = 0;

    $a = 0;
    $b = '<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>El archivo no debe pesar más de 8 MB.</div>';

    $dab = array(
      "a" => $a,
      "b" => $b
    );

    echo (json_encode($dab));
    exit();
}
// Permitimos solo ciertos formatos de imagen
/*if($formatoImagen != "jpg" && $formatoImagen != "png" && $formatoImagen != "gif") {
    $uploadOk = 0;

    $a = 0;
    $b = '<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor, sube una imagen en formato JGP, PNG o GIF</div>';

    $dab = array(
      "a" => $a,
      "b" => $b
    );

    echo (json_encode($dab));
    exit();
}*/
// Si la imagen no se puede cargar, mostramos un mensaje
if ($uploadOk == 0) {

    $a = 0;
    $b = '<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Tu imagen no puede ser cargada.</div>';

    $dab = array(
      "a" => $a,
      "b" => $b
    );

    echo (json_encode($dab));
    exit();
// Subimos la imagen
} else {

    $tmp = explode(".", $_FILES["adjunto_correo"]["name"]);
    $nuevonombreimagen = round(microtime(true)) . '.' . end($tmp);
    move_uploaded_file($tmp_name, "../../../views/view_descargo/adjuntos_correo/".$descargoNo."/".$file_name);
}



/* Configuración para el envio del Correo */

//Correo a donde caeran los mensajes del formulario
$correo = "brayan.medina@grupolaeisz.com"; //


// Asunto
$e_asunto= 'Mensaje de Contacto';


// Aca subo la imagen a mi servidor (Sera enviada como adjunto)
$archivo = '../../../views/view_descargo/adjuntos_correo/'.$descargoNo.'/'.$file_name;

// Preparamos el encabezado del correo
$e_bodya = "<b>Nombres y Apellidos:</b> $nya <br>" . PHP_EOL . PHP_EOL;
//$e_bodyb = "Imagen: $archivo" . PHP_EOL . PHP_EOL;
$e_reply = "<br> <b>Email:</b> $email " . PHP_EOL . PHP_EOL;
$e_bodyc = "<br> <b>Mensaje:</b> $mensaje" . PHP_EOL . PHP_EOL;
$e_bodyt = "<br> <br><br> <b><h3>Este es un correo generado por el sistema por favor no contestar</h3></b>" . PHP_EOL . PHP_EOL;

$msg = wordwrap( $e_bodya /*. $e_bodyb */. $e_bodyc.$e_bodyt  /*. $e_reply*/, 80 );

// Creamos el encabezado del correo
$headers = "From: ".$nya." <".$email.">" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;


/*Intentando enviar el correo */
try {
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $destinatarios = explode(",", $email);
    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='solicitud.notificaciones@gmail.com';
    $mail->Password='kjzbtmjtsobfrgje';
    $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port=587;
    $mail->setFrom('solicitud.notificaciones@gmail.com', 'Informacion Laeisz');
    foreach($destinatarios as $destino)
    {
        $mail->addAddress($destino);
    }
    //$mail->addCC($correo);
    $tamano =0;
    $adjuntado =0;
    if($_FILES['adjunto_correo']['size'] != 0) {
        $mail->addAttachment($archivo);
        $tamano = $_FILES['adjunto_correo']['size'];
        $adjuntado =1;
        $archivo = "";
    }
    $mail->isHTML(true);
    $mail->Subject='Correo Seguimiento Descargo No.'.$descargoNo.'';
    $mail->Body=utf8_decode($msg);
    $mail->send();
    /*Realizando la insercion del correo*/
    $query = "
    insert
	into
	public.correo_mensajeria_solicitud_compra
    (id_solicitud,
        mensaje,
        usuario_emisor,
        usuario_receptor,
        file_size,
        archivo_bytea,
        archivo_oid,
        envia_adjunto,
        usuario_creacion,
        fecha_creacion,
        modulo)
    values(
    '$descargoId',
    '$msg',
    '$Usuario',
    '$email',
    $tamano,
    '$archivo',
    0,
    '$adjuntado',
    '$Usuario',
    CURRENT_TIMESTAMP,
    'DES')
    ";

    $result = pg_query($conn,$query);
    if($result)
    {
        $a = 1;
        $b = "<div class='alert alert-success'>Tu Mensaje ha sido enviado Correctamente !</div>";

        $dab = array(
        "a" => $a,
        "b" => $b
        );
        echo (json_encode($dab));
    }


    // Si el correo es enviado correctamente, mostramos un mensaje




} catch (Exception $e) {
    echo "Error". $mail->ErrorInfo;
}
