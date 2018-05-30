<?php
/**
 * Description of subfunctionsDAO
 *
 * @author wtx
 */

require_once "db/conexao.php";

session_start();
$login = $_POST['login'];
$passwd = $_POST['password'];
$iduser = null;
$name = null;
$loginBanco = null;
$senha = null;
$perfil = null;

try {
    $statement = $pdo->prepare("SELECT iduser, login, senha, nome, perfil FROM tb_user WHERE login = :login and senha = :senha; ");
    $statement->bindValue(":login", $login);
    $statement->bindValue(":senha", sha1($passwd));
    if ($statement->execute()) {
        $rs = $statement->fetch(PDO::FETCH_OBJ);
        
        $iduser = $rs->iduser;
        $loginBanco = $rs->login;
        $name = $rs->nome;
        $senha = $rs->senha;
        $perfil = $rs->perfil;
        //echo "<br>";
        //var_dump($rs);
        //echo "<br> $login <br>";
        //echo "$passwd <br>";
        if( $loginBanco!=null and $senha != null)
        {
            $_SESSION['iduser'] = $iduser;
            $_SESSION['login'] = $loginBanco;
            $_SESSION['password'] = $senha;
            $_SESSION['name'] = $name;
            $_SESSION['perfil'] = $perfil;
            
            header('location:index.php');
        }
        else{
            unset ($_SESSION['iduser']);
            unset ($_SESSION['login']);
            unset ($_SESSION['password']);
            unset ($_SESSION['name']);
            unset ($_SESSION['perfil']);
            echo "<script> alert('Usuario ou Senha incorretos !'); </script>";
            
            header('location:index.php');

        }
    } else {
        throw new PDOException("Erro: Não foi possível executar a declaração sql");
    }
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

?>