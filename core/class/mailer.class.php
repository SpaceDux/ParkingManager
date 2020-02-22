<?php
  namespace ParkingManager;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  class Mailer
  {
    function SendMail($Too, $Body)
    {
      $mail = new PHPMailer();

      $mail->IsSMTP();
      $mail->Host = "us2.smtp.mailhostbox.com";
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'ryan@roadkingcafe.co.uk';              // SMTP username
      $mail->Password   = 'Qdc61abc123';                          // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 25;

      //Set who the message is to be sent from
      $mail->setFrom('ryan@roadkingcafe.co.uk', 'Roadking Portal');
      //Set who the message is to be sent to
      $mail->addAddress($Too);
      //Set the subject line
      $mail->Subject = 'Activate Your Roadking Portal Account';
      //Read an HTML message body from an external file, convert referenced images to embedded,
      $mail->Body = file_get_contents('html_mail.html', __DIR__);
      //Replace the plain text body with one created manually
      $mail->AltBody = 'You\'re nearly there, just activate your account by simply clicking the link below.';
      $mail->AltBody .= 'http://192.168.0.5/ParkingManager/activate/userref';
      //send the message, check for errors
      if (!$mail->send()) {
          echo 'Mailer Error: '. $mail->ErrorInfo;
      } else {
          echo 'Message sent!';
      }
    }
  }
?>
