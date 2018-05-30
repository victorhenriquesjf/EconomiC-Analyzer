<?php

require_once "classes/template.php";

require_once "dao/actionDAO.php";
require_once "classes/action.php";

$object = new actionDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_cod_action = (isset($_POST["str_cod_action"]) && $_POST["str_cod_action"] != null) ? $_POST["str_cod_action"] : "";
    $str_name_action = (isset($_POST["str_name_action"]) && $_POST["str_name_action"] != null) ? $_POST["str_name_action"] : "";
} else if (!isset($id)) {

    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_cod_action = NULL;
    $str_name_action = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $action = new action($id, '', '');

    $resultado = $object->update($action);
    $str_cod_action = $resultado->getStrCodAction();
    $str_name_action = $resultado->getStrNameAction();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_name_action != "" && $str_cod_action != "") {
    $action = new action($id, $str_cod_action, $str_name_action);

    $msg = $object->save($action);
    $id = null;
    $str_cod_action = null;
    $str_name_action = null;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $action = new action($id, '', '');

    $msg = $object->delete($action);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Action</h4>


                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php

                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Name:
                            <input class="form-control" type="text" size="50" name="str_name_action" value="<?php

                            echo (isset($str_name_action) && ($str_name_action != null || $str_name_action != "")) ? $str_name_action : '';
                            ?>"/>
                            <br/>
                            Code Action:
                            <input class="form-control" type="text" size="10" name="str_cod_action" value="<?php

                            echo (isset($str_cod_action) && ($str_cod_action != null || $str_cod_action != "")) ? $str_cod_action : '';
                            ?>"/>
                            <br/>
                            <input class="btn btn-success" type="submit" value="REGISTER">
                            <hr>
                        </form>


                        <?php

                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';


                        $object->pagedTable();

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
