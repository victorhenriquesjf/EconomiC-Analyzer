<?php

require_once "classes/template.php";

require_once "dao/paymentsDAO.php";
require_once "classes/payments.php";

$object = new paymentsDAO();

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
                        <h4 class='title'>Payments</h4>


                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php

                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            City:
                            <select class="form-control" name="tb_city_id_city">
                                <?php
                                $query = "SELECT * FROM tb_city order by str_name_city;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_city == $tb_city_id_city) {
                                            echo "<option value='$rs->id_city' selected>$rs->str_name_city</option>";
                                        } else {
                                            echo "<option value='$rs->id_city'>$rs->str_name_city</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Function:
                            <select class="form-control" name="tb_functions_id_function">
                                <?php
                                $query = "SELECT * FROM tb_functions order by str_name_function;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_function == $tb_functions_id_function) {
                                            echo "<option value='$rs->id_function' selected>$rs->str_name_function</option>";
                                        } else {
                                            echo "<option value='$rs->id_function'>$rs->str_name_function</option>";
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

                        <div  style="display: inline-block; width: 100%" >
                            <table style="border: 0px; -webkit-border-horizontal-spacing: 150px; border-collapse: separate; text-align: center"  >
                                <tr>
                                    <td>
                                        <form action="relatorio/pagamentos_relatorio.php">
                                            <input class="btn btn-success" type="submit" value="Report of all paymants">
                                            <p><br/></p>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="relatorio/pagamentosCidade_relatorio.php">
                                            <input class="btn btn-success" type="submit" value="Report value paid by city">
                                            <p><br/></p>
                                        </form>
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <form action="relatorio/pagamentosRegiao_relatorio.php">
                                            <input class="btn btn-success" type="submit" value="Report value paid by region">
                                            <p><br/></p>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="relatorio/pagamentosEstado_relatorio.php">
                                            <input class="btn btn-success" type="submit" value="Report value paid by state">
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
