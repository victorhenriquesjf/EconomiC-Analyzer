<?php

require_once "classes/template.php";

require_once "dao/beneficiariesDAO.php";
require_once "classes/beneficiaries.php";


$object = new beneficiariesDAO();



$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_nis = (isset($_POST["str_nis"]) && $_POST["str_nis"] != null) ? $_POST["str_nis"] : "";
    $str_name_person = (isset($_POST["str_name_person"]) && $_POST["str_name_person"] != null) ? $_POST["str_name_person"] : "";
} else if (!isset($id)) {

    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_nis = NULL;
    $str_name_person = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $beneficiaries = new beneficiaries($id, '', '');

    $resultado = $object->update($beneficiaries);

    $str_nis = $resultado->getStrNis();
    $str_name_person = $resultado->getStrNamePerson();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_name_person != "" && $str_nis!= "") {
    $beneficiaries = new beneficiaries($id, $str_nis, $str_name_person);
    $msg = $object->save($beneficiaries);
    $id = null;
    $str_nis = null;
    $str_name_person = null;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $beneficiaries = new beneficiaries($id, '', '');
    $msg = $object->delete($beneficiaries);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Beneficiaries</h4>
                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php

                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Name:
                            <input class="form-control" type="text" name="str_name_person" value="<?php

                            echo (isset($str_name_person) && ($str_name_person != null || $str_name_person != "")) ? $str_name_person : '';
                            ?>"/>
                            <br/>
                            NIS:
                            <input class="form-control" type="text" maxlength="11" name="str_nis" placeholder="Numbers Only" value="<?php

                            echo (isset($str_nis) && ($str_nis != null || $str_nis != "")) ? $str_nis : '';
                            ?>"/>
                            <br/>
                            <input class="btn btn-success" type="submit" value="Register">
                            <hr>
                        </form>

                        <div  style="display: inline-block; text-align: right; width: 100%">
                            <table style="border: 0px; -webkit-border-horizontal-spacing: 100px; border-collapse: separate; text-align: center"  >
                                <tr>
                                    <td>
                                        <form action="relatorio/beneficiarios_relatorio.php"  target="_blank">
                                            <input class="btn btn-success" type="submit" value="Report of all beneficiaries">
                                            <p><br/></p>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="relatorio/beneficiariosCidade_relatorio.php" target="_blank">
                                            <input class="btn btn-success" type="submit" value="Report of beneficiaries and cities">
                                            <p><br/></p>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="relatorio/totalBeneficiariosAuxilio_relatorio.php" target="_blank">
                                            <input class="btn btn-success" type="submit" value="Beneficiaries help">
                                            <p><br/></p>
                                        </form>
                                    </td>

                                </tr>
                            </table>
                        </div>

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
