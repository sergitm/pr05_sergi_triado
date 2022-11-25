<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../public/lib/PHPMailer/src/Exception.php';
require '../../../public/lib/PHPMailer/src/PHPMailer.php';
require '../../../public/lib/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Mailer = "smtp";
    $mail->Port = 465;
    $mail->Username = ""; // Posa el teu correu, Xavi
    $mail->Password = ""; // Posa la teva contrasenya, Xavi 
                                //i recorda posar permetre accés d'aplicacions menys segures: https://myaccount.google.com/lesssecureapps
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    //Destinataris
    $mail->setFrom('', 'admin'); // Posa el teu correu al primer parametre
    $mail->addAddress($email, $username);

    ////Content
    $mail->isHTML(true);
    $mail->Subject = "Recuperació de contrasenya per " . $username;
    $mail->Body    = "Entra al següent enllaç per canviar la teva contrasenya <a href='" .$environment->protocol . $environment->baseUrl . $environment->dir->templates->pwd_recover . "?validation=" . session_id() ."'>" . $environment->protocol . $environment->baseUrl . $environment->dir->templates->pwd_recover . "</b>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if ($mail->send()) {
        // print '<small style=\'color:green\'>Correu enviat correctament!</small>';
    } else {
        // print '<small style=\'color:red\'>Correu no enviat</small>';
    }
} catch (\Throwable $th) {
    throw $th;
    // print '<small style=\'color:red\'>Hi ha hagut un error.</small>';
}
?>