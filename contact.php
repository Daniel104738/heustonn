<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validar los campos del formulario
  if (empty($_POST['name']) || empty($_POST['msg']) || !filter_var($_POST['email'] || empty($_POST['subject']), FILTER_VALIDATE_EMAIL)) {
      http_response_code(500);
      exit();
  }

$mail = new PHPMailer(true);

$Email = $_POST['email'];
$nombre = $_POST['name'];
$subject = $_POST['subject'];
$msg = $_POST['msg'];

try {
  $mail->SMTPDebug = 2; // Habilitar modo depuración
  $mail->isSMTP();
  $mail->Host = 'smtp.zoho.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'cafecito@pinedodaniel.shop';
  $mail->Password = 'jaziulxd';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Probar con TLS directo
  $mail->Port = 587;

  // Opcional: relajar la verificación de certificados (no recomendado para entornos de producción)
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );

  $mail->setFrom('cafecito@pinedodaniel.shop', 'Daniel');
  $mail->addAddress($Email);

  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $msg;

  $mail->send();

  // Redirección con mensaje de éxito
  header('Location: contact.html');
  exit;

} catch (Exception $e) {
  // Redirección con mensaje de error
  header('Location: contact.html');
  exit;
}
}
?>
