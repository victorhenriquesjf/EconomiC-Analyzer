<?php

require_once "classes/template.php";

require_once "dao/filesDAO.php";
require_once "classes/files.php";


$object = new filesDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_name_file = (isset($_POST["str_name_file"]) && $_POST["str_name_file"] != null) ? $_POST["str_name_file"] : "";
    $str_month = (isset($_POST["str_month"]) && $_POST["str_month"] != null) ? $_POST["str_month"] : "";
    $str_year = (isset($_POST["str_year"]) && $_POST["str_year"] != null) ? $_POST["str_year"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_name_file = NULL;
    $str_month = NULL;
    $str_year = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $files = new files($id, '', '', '');

    $resultado = $object->update($files);
    $str_name_file = $resultado->getStrNameFile();
    $str_month = $resultado->getStrMonth();
    $str_year = $resultado->getStrYear();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_name_file != "" && $str_month!= "") {
    $files = new files($id, $str_name_file, $str_month, $str_year);
    $msg = $object->save($files);
    $id = null;
    $str_name_file = null;
    $str_month = null;
    $str_year = null;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $files = new files($id, '', '', '');
    $msg = $object->delete($files);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Files</h4>


                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php

                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Name:
                            <input class="form-control" type="text" name="str_name_file" value="<?php

                            echo (isset($str_name_file) && ($str_name_file != null || $str_name_file != "")) ? $str_name_file : '';
                            ?>"/>
                            <br/>
                            Month:
                            <input class="form-control" type="text" maxlength="2" name="str_month" value="<?php

                            echo (isset($str_month) && ($str_month != null || $str_month != "")) ? $str_month : '';
                            ?>"/>
                            <br/>
                            Year:
                            <input class="form-control" type="text" maxlength="4" name="str_year" value="<?php

                            echo (isset($str_year) && ($str_year != null || $str_year != "")) ? $str_year : '';
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
