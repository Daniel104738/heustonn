<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validar los campos del formulario
  if (empty($_POST['name'])) {
    echo "El nombre es obligatorio.";
    exit();
  }

  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "El correo electrónico no es válido.";
    exit();
  }

  if (empty($_POST['subject'])) {
    echo "El asunto es obligatorio.";
    exit();
  }

  if (empty($_POST['msg'])) {
    echo "El mensaje es obligatorio.";
    exit();
  }

  $mail = new PHPMailer(true);

  $Email = $_POST['email'];
  $nombre = $_POST['name'];
  $subject = $_POST['subject'];
  $message = $_POST['msg'];

  try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2; // Habilitar modo depuración
    $mail->isSMTP();

    // **Configuración SMTP para Hostinger:**
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cafecito@pinedodaniel.shop'; // Reemplaza con tu nombre de usuario
    $mail->Password = 'jaziulxd'; // Reemplaza con tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Opcional: relajar la verificación de certificados (no recomendado para entornos de producción)
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
      )
    );

    $mail->setFrom('cafecito@pinedodaniel.shop', 'Daniel');
    $mail->addAddress('cafecito@pinedodaniel.shop'); // Reemplaza con la dirección de destino

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    try {
      // Enviar correo
      $mail->send();

      echo "Mensaje enviado correctamente";
    } catch (Exception $e) {
      echo "Error al enviar el mensaje";
      exit();
    }
  } catch (Exception $e) {
    echo "Error al enviar el mensaje";
    exit();
  }
} else {
  // Redirigir a la página de contacto
  header('Location: contact.html');
  exit();
}
?>
