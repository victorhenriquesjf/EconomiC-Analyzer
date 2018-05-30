<?php
require_once "classes/template.php";
require_once "db/conexao.php";
require_once "dao/userDao.php";
require_once "classes/user.php";
session_start();


$object = new userDao();

$template = new Template();
$template->header();
$template->sidebar();
$template->mainpanel();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = (isset($_POST["id_user"]) && $_POST["id_user"] != null) ? $_POST["id_user"] : "";
    $name_user = (isset($_POST["name_user"]) && $_POST["name_user"] != null) ? $_POST["name_user"] : "";
    $login = (isset($_POST["login"]) && $_POST["login"] != null) ? $_POST["login"] : "";
    $password = (isset($_POST["password"]) && $_POST["password"] != null) ? $_POST["password"] : "";
    $status = (isset($_POST["status"]) && $_POST["status"] != null) ? $_POST["status"] : "";
    $email_user = (isset($_POST["email_user"]) && $_POST["email_user"] != null) ? $_POST["email_user"] : "";
} else if (!isset($id_user)) {
    $id_user = (isset($_GET["id_user"]) && $_GET["id_user"] != null) ? $_GET["id_user"] : "";
    $name_user = NULL;
    $login = NULL;
    $password = NULL;
    $status = NULL;
    $email_user = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_user != "") {
    $user = new user($id_user,"","","","","");
    $resultado = $object->update($user);

    $name_user =  $resultado->getNameUser();
    $login =$resultado->getLogin();
    $password = $resultado->getPassword();
    $status = $resultado->getStatus();
    $email_user = $resultado->getEmailUser();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $name_user != "" && $login != "" && $password != "" && $status != "" && $email_user != "") {
    $user = new user($id_user, $name_user, $login, $password, $status, $email_user);
    $msg = $object->save($user);

    $id_user = NULL;
    $name_user = NULL;
    $login = NULL;
    $password = NULL;
    $status = NULL;
    $email_user = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_user != "") {
    $user = new user($id_user, '', '', '','','');
    $msg = $object->delete($user);
    $id_user = null;
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
                        <div id="results" <?php if ($_SESSION['status'] == 0){?>style="display:none"<?php } ?>>
                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id_user" value="<?php
                            echo (isset($id_user) && ($id_user != null || $id_user != "")) ? $id_user : '';
                            ?>"/>

                            Nome:
                            <input class="form-control" size="50" name="name_user" value="<?php
                            echo (isset($name_user) && ($name_user != null || $name_user != "")) ? $name_user : '';
                            ?>"/>
                            <br/>

                            Login:
                            <input class="form-control" size="10" name="login" value="<?php
                            echo (isset($login) && ($login != null || $login != "")) ? $login : '';
                            ?>"/>
                            <br/>

                            Senha:
                            <input class="form-control"  size="50" name="password" value="<?php
                            echo (isset($password) && ($password != null || $password != "")) ? $password : '';
                            ?>"/>
                            <br/>

                            Email:
                            <input class="form-control" size="50" name="email_user" value="<?php
                            echo (isset($email_user) && ($email_user != null || $email_user != "")) ? $email_user : '';
                            ?>"/>
                            <br/>

                            Status:
                            <select class="form-control" name="status">
                                <option value="1" <?php if(isset($status) && $status=="1") echo 'selected'?>>Administrador</option>
                                <option value="0" <?php if(isset($status) && $status=="0") echo 'selected'?>>Usuario</option>
                            </select>

                            <input class="btn btn-success" type="submit" value="CADASTRAR" >
                            <hr>
                        </form>
                        </div>

                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        if($_SESSION['status'] == 0){
                            $object->pagedTableUser();
                        }
                        else if($_SESSION['status'] == 1){
                            $object->pagedTable();
                        }
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
