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
      
      //Set who the message is to be sent from
      $mail->setFrom('noreply@roadkingcafe.co.uk', 'Roadking Portal');
      //Set who the message is to be sent to
      $mail->addAddress($Too);
      //Set the subject line
      $mail->Subject = 'PHPMailer mail() test';
      //Read an HTML message body from an external file, convert referenced images to embedded,
      $mail->Body = 'This is the HTML message body <b>in bold!</b>';
      //Replace the plain text body with one created manually
      $mail->AltBody = 'This is a plain-text message body';
      //send the message, check for errors
      if (!$mail->send()) {
          echo 'Mailer Error: '. $mail->ErrorInfo;
      } else {
          echo 'Message sent!';
      }
    }
  }
?>
