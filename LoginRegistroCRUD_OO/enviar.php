<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;

        require_once 'phpmailer/src/Exception.php';
        require_once 'phpmailer/src/PHPMailer.php';
        require_once 'phpmailer/src/SMTP.php';
        require_once './GestionDatos.php';
        
        $emailDestino = $_REQUEST['correoDestino'];

        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Host de conexión SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'AuxiliarDAW2@gmail.com';
            $mail->Password = 'Chubaca20';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('AuxiliarDAW2@gmail.com');
            $mail->addAddress($emailDestino);

            $mail->isHTML(true);
            $mail->Subject = 'Recupera tu cuenta';

            $az = rand(1, 99999);

            $mail->Body = 'Nueva contraseña:<b>' . $az . '</b>';
            $mail->AltBody = 'Contraseña olvidada';

            $mail->send();

            if (GestionDatos::setPassword($emailDestino, $az)) {
                $_SESSION['mensaje'] = 'Correo enviado';
            } else {
                $_SESSION['mensaje'] = 'No se ha podido enviar el correo';
            }
            header('Location: index.php');
            
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo 'El mensaje no se ha podido enviar, error: ', $mail->ErrorInfo;
        }
        ?>
    </body>
</html>
