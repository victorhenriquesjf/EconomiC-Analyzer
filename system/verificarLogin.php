<?php

require_once "db/conexao.php";

session_start();
$loginInserido = $_POST['login'];
$passwordInserido = $_POST['password'];
$id_user = null;
$name_user = null;
$login = null;
$password = null;
$status = null;
$email_user= null;

try {
    $statement = $pdo->prepare("SELECT id_user, name_user, login, password, status, email_user  FROM tb_user WHERE login = :login and password = :password; ");
    $statement->bindValue(":login", $loginInserido);
    $statement->bindValue(":password", $passwordInserido);
    /*$statement->bindValue(":password", sha1($passwordInserido));*/
    if ($statement->execute()) {
        $rs = $statement->fetch(PDO::FETCH_OBJ);

        $id_user = $rs->id_user;
        $name_user = $rs->name_user;
        $login = $rs->login;
        $password = $rs->password;
        $status = $rs->status;
        $email_user =$rs->email_user;

        if( $loginInserido != null and $passwordInserido != null and $loginInserido == $login and $passwordInserido == $password )
        {
            $_SESSION['id_user'] = $id_user;
            $_SESSION['name_user'] = $name_user;
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['status'] = $status;
            $_SESSION['email_user'] = $email_user;
            header('location:index.php');
        } else{
            unset ($_SESSION['id_user']);
            unset ($_SESSION['name_user']);
            unset ($_SESSION['login']);
            unset ($_SESSION['password']);
            unset ($_SESSION['status']);
            unset ($_SESSION['email_user']);
            echo "<script> alert('Usuario ou Senha incorretos !'); </script>";

            header('location:login.php');
        }
    } else {
        throw new PDOException("Erro: Não foi possível executar a declaração sql");
    }
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

?>