<?php

require_once "classes/template.php";

require_once "dao/stateDAO.php";
require_once "classes/state.php";

$object = new stateDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_state = (isset($_POST["id_state"]) && $_POST["id_state"] != null) ? $_POST["id_state"] : "";
    $str_uf = (isset($_POST["str_uf"]) && $_POST["str_uf"] != null) ? $_POST["str_uf"] : "";
    $str_name = (isset($_POST["str_name"]) && $_POST["str_name"] != null) ? $_POST["str_name"] : "";
    $tb_region_id_region = (isset($_POST["tb_region_id_region"]) && $_POST["tb_region_id_region"] != null) ? $_POST["tb_region_id_region"] : "";
} else if (!isset($id_state)) {
    // Se não se não foi setado nenhum valor para variável $id_state
    $id_state = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_uf = NULL;
    $str_name = NULL;
    $tb_region_id_region = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_state != "") {

    $state = new state($id_state, '', '', '');

    $resultado = $object->update($state);
    $str_uf = $resultado->getStrUf();
    $str_name = $resultado->getStrName();
    $tb_region_id_region = $resultado->getTbRegionIdRegion();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_name != "" && $str_uf != "") {
    $state = new state($id_state, $str_uf, $str_name, $tb_region_id_region);
    $msg = $object->save($state);
    $id_state = null;
    $str_uf = null;
    $str_name = null;
    $tb_region_id_region = null;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_state != "") {
    $state = new state($id_state, '', '', '');
    $msg = $object->delete($state);
    $id_state = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>States</h4>


                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php

                            echo (isset($id_state) && ($id_state != null || $id_state != "")) ? $id_state : '';
                            ?>"/>
                            UF:
                            <input class="form-control" type="text" name="str_uf" value="<?php

                            echo (isset($str_uf) && ($str_uf != null || $str_uf != "")) ? $str_uf : '';
                            ?>"/>
                            <br/>
                            Name:
                            <input class="form-control" type="text" name="str_name" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_name) && ($str_name != null || $str_name != "")) ? $str_name : '';
                            ?>"/>
                            <br/>
                            Region:
                            <select class="form-control" name="tb_state_id_state">
                                <?php
                                $query = "SELECT * FROM tb_region order by str_name_region;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_region == $tb_region_id_region) {
                                            echo "<option value='$rs->id_region' selected>$rs->str_name_region</option>";
                                        } else {
                                            echo "<option value='$rs->id_region'>$rs->str_name_region</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
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
