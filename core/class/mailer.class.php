<?php
  namespace ParkingManager;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  class Mailer
  {
    function SendActivation($Too)
    {
      global $_CONFIG;
      $mail = new PHPMailer();

      $mail->IsSMTP();
      $mail->Host = "us2.smtp.mailhostbox.com";
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'rp@roadkingtruckstop.co.uk';              // SMTP username
      $mail->Password   = 'tlyyIiS4';                          // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 25;

      //Set who the message is to be sent from
      $mail->setFrom('rp@roadkingtruckstop.co.uk', 'Roadking Portal');
      //Set who the message is to be sent to
      $mail->addAddress($Too);
      //Set the subject line
      $mail->Subject = 'Activate Your Roadking Portal Account';
      //Read an HTML message body from an external file, convert referenced images to embedded,
      $mail->Body = file_get_contents('../../email_templates/activation.html', __DIR__);
      $mail->Body .= '<a style="display: block;width: 300px;height: 40px;background: #114408;text-align: center;text-decoration: none;line-style: none;color: #fff;line-height: 40px;font-size: 30px;margin: 0 auto;border-radius: 10px 10px 10px 10px;" href="'.$_CONFIG['site']['url'].'/activate.php?email='.$Too.'">ACTIVATE NOW</a>';
      $mail->Body .= '<br><hr><br><p style="font-size: 14px;color: #0f0f0f;text-align:center;">or follow this link; '.$_CONFIG['site']['url'].'/activate.php?email='.$Too.'</p>';
      $mail->Body .= '<br><hr><br><p style="font-size: 10px;color: #0f0f0f;text-align:center;">THIS MAILBOX IS NOT MONITORED, DO NOT REPLY.<br><br></p>';
      //Replace the plain text body with one created manually
      $mail->AltBody = 'You\'re nearly there, just activate your account by simply clicking the link below.';
      $mail->AltBody .= $_CONFIG['site']['url'].'/activate.php?email='.$Too;
      //send the message, check for errors
      if (!$mail->send()) {
        return "0";
      } else {
          return "1";
      }
    }
  }
?>
