<?php

set_time_limit(60);


require_once 'dao/userDAO.php';
require_once "../system/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once "../system/vendor/phpmailer/phpmailer/src/SMTP.php";
require_once "../system/vendor/phpmailer/phpmailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$object = new userDAO();
$mail = new PHPMailer;
$object = new userDao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = (isset($_POST["login"]) && $_POST["login"] != null) ? $_POST["login"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";

    if($object->recuperaSenha($login, $email)) {

        $object->trocaSenha($login, $email);

        $mail->isSMTP();
        $mail->SMTPDebug = 1;

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;

        $mail->Username = "victor.henriques@viannasempre.com.br";
        $mail->Password = "slash130266";


        $mail->setFrom('victor.henriques@viannasempre.com.br', 'Victor Almeida');

        //$mail->addReplyTo('tassio@tassio.eti.br', 'Tassio Sirqueira');

        $mail->addAddress($email, $login);

        $mail->Subject = 'Recuperacao de login ECA';

        $mail->msgHTML("Sua senha temporária é <strong>123456</strong> <br> Não perca novamente!");

        //$mail->addAttachment('phpmailer.png');

        if (!$mail->send()) {
            echo "Erro ao enviar o E-mail: " . $mail->ErrorInfo;
        } else {
            echo "E-mail enviado com sucesso!";
        }
        header('Location:login.php');
    }else {
        echo 'Login ou senha não encontrados!';
    }
} else {
    echo 'Dados não preenchidos';
    header('location:recuperar.php');
}
