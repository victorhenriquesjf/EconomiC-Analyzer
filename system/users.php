<?php
/**
 * Description of subfunctionsDAO
 *
 * @author wtx
 */
require_once "classes/template.php";

require_once "dao/userDAO.php";
require_once "classes/user.php";

$object = new userDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();



if ($_SESSION['perfil'] == 0) {
// Verificar se foi enviando dados via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
        $login = (isset($_POST["login"]) && $_POST["login"] != null) ? $_POST["login"] : "";
        $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : "";
        $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
        $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
        $resetar = (isset($_POST["resetar"]) && $_POST["resetar"] != null) ? $_POST["resetar"] : "";
        $perfil = (isset($_POST["perfil"]) && $_POST["perfil"] != null) ? $_POST["perfil"] : "";
    } else if (!isset($id)) {
        // Se não se não foi setado nenhum valor para variável $id
        $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
        $login = NULL;
        $senha = NULL;
        $nome = NULL;
        $email = NULL;
        $resetar = NULL;
        $perfil = NULL;
    }

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

        $user = new user($id, "", "", "", "", "", "");

        $resultado = $object->atualizar($user);
        $login = $resultado->getLogin();
        $senha = $resultado->getSenha();
        $nome = $resultado->getNome();
        $email = $resultado->getEmail();
        $resetar = $resultado->getResetar();
        $perfil = $resultado->getPerfil();
    }

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" &&
            $login != "" && $senha != "" && $nome != "" &&
            $email != "" && $resetar != "" && $perfil != ""
    ) {
        $user = new user($id, $login, $senha, $nome, $email, $resetar, $perfil);

        $msg = $object->salvar($user);
        $id = null;
        $login = NULL;
        $senha = NULL;
        $nome = NULL;
        $email = NULL;
        $resetar = NULL;
        $perfil = NULL;
    }

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
        $user = new user($id, "", "", "", "", "", "");

        $msg = $object->remover($user);
        $id = null;
    }
} else {
    header('location:index.php');
    echo "<script> alert('O seu usuário não tem permissão para executar está operação!'); </script>";
    
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Usuários</h4>
                        <p class='category'>Lista de Usuários do sistema</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
// Preenche o id no campo id com um valor "value"
echo (isset($id) && ($id != null || $id != "")) ? $id : '';
?>"/>
                            Login:
                            <input class="form-control" type="text" size="50" name="login" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($login) && ($login != null || $login != "")) ? $login : '';
                            ?>"/>
                            <br/>
                            Senha:
                            <input class="form-control" type="text" size="10" name="senha" value="<?php
                                   // Preenche o sigla no campo sigla com um valor "value"
                                   echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';
                                   ?>"/>
                            <br/>

                            Nome:
                            <input class="form-control" type="text" size="50" name="nome" value="<?php
                                   // Preenche o nome no campo nome com um valor "value"
                                   echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                                   ?>"/>
                            <br/>

                            Email:
                            <input class="form-control" type="email" size="50" name="email" value="<?php
                                   // Preenche o nome no campo nome com um valor "value"
                                   echo (isset($email) && ($email != null || $email != "")) ? $email : '';
                                   ?>"/>
                            <br/>

                            Resetar:
                            <input class="form-control" type="text" size="50" name="resetar" value="<?php
                                   // Preenche o nome no campo nome com um valor "value"
                                   echo (isset($resetar) && ($resetar != null || $resetar != "")) ? $resetar : '';
                                   ?>"/>
                            <br/>

                            Perfil:
                            <input class="form-control" type="text" size="50" name="perfil" value="<?php
                                   // Preenche o nome no campo nome com um valor "value"
                                   echo (isset($perfil) && ($perfil != null || $perfil != "")) ? $perfil : '';
                                   ?>"/>
                            <br/>

                            <input class="btn btn-success" type="submit" value="CADASTRAR">
                                <hr>
                                    </form>


<?php
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';

//chamada a paginação
$object->tabelapaginada();
?>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>

<?php
$template->footer();
?>
