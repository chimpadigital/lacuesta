<?php

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
//header('Content-type: application/json');
date_default_timezone_set('America/Argentina/Buenos_Aires');



// Enter your email address. If you need multiple email recipes simply add a comma: info@ideesturismo.com.ar, email2@domain.com
$to = "sprados@chimpancedigital.com.ar";
// $subject = "Consulta campaña asesoría (larga)";

// Form Fields
$name = isset($_POST["name"]) ? $_POST["name"] : null;
$phone = isset($_POST["subject"]) ? $_POST["subject"] : null;
$subject = 'Consulta La Cuesta';
$message = isset($_POST["message"]) ? $_POST["message"] : null;


//$recaptcha = $_POST['g-recaptcha-response'];

//inicio script grabar datos en csv
        $fichero = 'estacion.csv';//nombre archivo ya creado
        //crear linea de datos separado por coma
        $fecha=date("dd-mm-yyy H:i:s");
        $linea = $fecha.";".$name.";".$phone.";".$message."\n";
        // Escribir la linea en el fichero
        file_put_contents($fichero, $linea, FILE_APPEND | LOCK_EX);
        //fin grabar datos

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = isset($name) ? "Nombre: $name<br><br>" : '';
    $phone = isset($phone) ? "Teléfono: $phone<br><br>" : '';
    $message = isset($message) ? "Mensaje: $message<br><br>" : '';
    $body=$name . $phone . $message . '<br><br><br>enviado desde: ' . $_SERVER['HTTP_REFERER'];
    
 if($name != '') {

        require 'php-mailer/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->SMTPDebug = 2;
        $mail->debugoutput = 'html';                              // Enable verbose debug output
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'sprados@chimpancedigital.com.ar';
        $mail->Password = 'Chimpance951#$';
        // $mail->SMTPSecure = false;
        // $mail->SMTPAutoTLS = false;
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->IsHTML(true);                                    // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('sprados@chimpancedigital.com.ar', 'grupomiterra');
        $mail->addAddress('sprados@chimpancedigital.com.ar', 'grupomiterra');     // Add a recipient
        $mail->addReplyTo('sprados@chimpancedigital.com.ar', 'Information');
        
        $mail->Subject = $subject;
        $mail->Body    = $body;

        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            header("Location: /gracias.html"); 
        }
                        
       }        
}
?>