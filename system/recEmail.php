<?php
/**
 * Description of subfunctionsDAO
 *
 * @author wtx
 */

set_time_limit(60);

require "lib/PHPMailer/src/PHPMailer.php";
require "lib/PHPMailer/src/SMTP.php";
require "lib/PHPMailer/src/Exception.php";
require_once 'db/userDAO.php';

use PHPMailer\PHPMailer\PHPMailer;

$object = new userDAO();
$mail = new PHPMailer;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = (isset($_POST["login"]) && $_POST["login"] != null) ? $_POST["login"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";

    if($object->recuperaSenha($login, $email)) {


        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;

        $mail->Username = "victor.henriques@viannasempre.com.br'";
        $mail->Password = "slash130266";


        $mail->setFrom('vitinhoalmeidajf@gmail.com', 'Victor Almeida');

        //$mail->addReplyTo('tassio@tassio.eti.br', 'Tassio Sirqueira');

        $mail->addAddress($email, $login);

        $mail->Subject = 'Recuperação de login SGA';

        $mail->msgHTML("Sua senha temporária é 123456 <br> Não perca novamente!");

        //$mail->addAttachment('phpmailer.png');

        if (!$mail->send()) {
            echo "Erro ao enviar o E-mail: " . $mail->ErrorInfo;
        } else {
            echo "E-mail enviado com sucesso!";
        }
        header('Location: login.php');
    }else {
        echo 'Logim ou senha não encontrados!';
        var_dump($login);
        var_dump($email);
        //header('Location: recuperar.php');
    }
} else {
    echo 'Dados não preenchidos';
    header('Location: recuperar.php');
}
