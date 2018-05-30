<?php


require_once "classes/template.php";

require_once "dao/programsDAO.php";
require_once "classes/programs.php";


$object = new programsDAO();



$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_cod_program = (isset($_POST["str_cod_program"]) && $_POST["str_cod_program"] != null) ? $_POST["str_cod_program"] : "";
    $str_name_program = (isset($_POST["str_name_program"]) && $_POST["str_name_program"] != null) ? $_POST["str_name_program"] : "";
} else if (!isset($id)) {

    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_cod_program = NULL;
    $str_name_program = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $programs = new programs($id, '', '');

    $resultado = $object->update($programs);
    $str_cod_program = $resultado->getStrCodProgram();
    $str_name_program = $resultado->getStrNameProgram();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_name_program != "" && $str_cod_program!= "") {
    $programs = new programs($id, $str_cod_program, $str_name_program);
    $msg = $object->save($programs);
    $id = null;
    $str_cod_program = null;
    $str_name_program = null;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $programs = new programs($id, '', '');
    $msg = $object->delete($programs);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Programs</h4>


                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php

                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Name:
                            <input class="form-control" type="text" name="str_name_program" value="<?php

                            echo (isset($str_name_program) && ($str_name_program != null || $str_name_program != "")) ? $str_name_program : '';
                            ?>"/>
                            <br/>
                            Code Program:
                            <input class="form-control" type="text" name="str_cod_program" value="<?php

                            echo (isset($str_cod_program) && ($str_cod_program != null || $str_cod_program != "")) ? $str_cod_program : '';
                            ?>"/>
                            <br/>
                            <input class="btn btn-success" type="submit" value="Register">
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
