<!--En un archivo separado que guardarás con extensión .php y el cual se debe llamar enviar.php, pega el siguiente código:
 


<?php
$codigo = $_POST['codigo'];
$name = $_POST['name'];
$mail = $_POST['vehiculo'];
$phone = $_POST['year'];
$phone = $_POST['phone'];
$direccion = $_POST['adress'];
$email = $_POST['email'];

$header = 'From: ' . $mail . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$message = "Este mensaje fue enviado por: " . $name . " \r\n";
$message .= "Su e-mail es: " . $email . " \r\n";
$message .= "Teléfono de contacto: " . $phone . " \r\n";
$message .= "Modelo del Vehiculo: " . $vehiculo . " \r\n";
$message .= "Año: " . $year. " \r\n";
$message .= "Dirección: " . $adress. " \r\n";
$message .= "Email: " . $email. " \r\n";


$message .= "Enviado el: " . date('d/m/Y', time());

$para = 'jairo.guillen86@gmail.com';
$asunto = 'Mensaje de... (Escribe como quieres que se vea el remitente de tu correo)';

mail($para, $asunto, utf8_decode($message), $header);

header("Location:index.html");
?>
-->