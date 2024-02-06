<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validar los campos del formulario
  if (empty($_POST['name']) || empty($_POST['msg']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || empty($_POST['subject'])) {
    http_response_code(500);
    exit();
  }

  $email = $_POST['email'];
  $nombre = $_POST['name'];
  $subject = $_POST['subject'];
  $mensaje = $_POST['msg'];

  try {
    $mail = new PHPMailer(true);
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
    $mail->addAddress('cafecito@pinedodaniel.shop');

    $mail->isHTML(true);
    $mail->Subject = 'hola';
    $mail->Body = 'has recibido un nuevo mensaje ';


    try {
      // Enviar correo a Zoho
      $mail->send();

      // Enviar correo de agradecimiento al usuario
      $mail->clearAddresses();
      $mail->addAddress($email);
      $mail->Subject = "Gracias por ponerte en contacto";
      $mail->Body ="holaaa";

      $mail->send();

      echo "Mensaje enviado correctamente";
    } catch (Exception $e) {
      http_response_code(500);
      echo "Error al enviar el mensaje";
      exit();
    }
  } catch (Exception $e) {
    echo "Error al enviar el mensaje: " . $e->getMessage();
  }
} else {
  // Redirigir si no es una solicitud POST
  header("Location: contact.html");
  exit();
}
?>
