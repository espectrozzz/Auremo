<?php
    echo json_encode(array("abc"=>"prueba"));
    //ini_set( 'display_errors', 1 ); # REMOVE // FOR DEBUG
    //error_reporting( E_ALL ); # REMOVE // FOR DEBUG
    $from = ""; // Email con el dominio del Hosting para evitar SPAM
    $fromName = "Ruleta Auremo"; // Nombre que saldrá en el email recibido
    $to = "alfaro9619@hotmail.com"; // Dirección donde se enviará el formulario
    $subject = "Nuevo Cliente Auremo"; // Asunto del Formulario

    /* Componemos el mensaje */
    $fullMessage = "Hola! " . $to . "\r\n";
    $fullMessage .= $_POST['inputName'] . " " . $_POST['inputName'] . " te ha enviado un mensaje:\r\n";
    $fullMessage .= "\r\n";
    $fullMessage .= "Nombre: " . $_POST['inputName'] . "\r\n";
    $fullMessage .= "E-Mail: " . $_POST['inputEmail'] . "\r\n";
    $fullMessage .= "Modelo de Vehiculo: " . $_POST['inputCar'] . "\r\n";
    $fullMessage .= "Año: " . $_POST['inputYear'] . "\r\n";
    $fullMessage .= "Celular: " . $_POST['inputPhone'] . "\r\n";
    $fullMessage .= "Dirección: " . $_POST['inputAddress'] . "\r\n";
    $fullMessage .= "\r\n";
    $fullMessage .= "Saludos!\r\n";

    /* Creamos las cabeceras del Email */
    $headers = "Organization: RPF WEB\r\n";
    $headers .= "From: " . $fromName . "<" . $from . ">\r\n";
    $headers .= "Reply-To: " . $_POST['validarEmail'] . "\r\n";
    $headers .= "Return-Path: " . $to . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    /* Enviamos el Formulario*/
    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "<center><h2>El E-Mail se ha enviado correctamente!</h2></center>";
    } else {
        echo "<center><h2>Ops ! El E-Mail ha fallado!</h2></center>S";
    }

?>