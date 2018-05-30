<?php
require_once "db/conexao.php";
require_once "classes/payments.php";

class paymentsDAO
{
    public function delete($payment){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_payments WHERE id_payment = :id");
            $statement->bindValue(":id", $payment->getIdPayment());
            if ($statement->execute()) {
                return "<script> alert('Excluído com sucesso !'); </script>";
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function save($payment)
    {
        global $pdo;
        try {
            if ($payment->getIdPayment() != "") {
                $statement = $pdo->prepare("UPDATE tb_payments SET tb_city_id_city=:tb_city_id_city, tb_functions_id_function=:tb_functions_id_function, tb_subfunctions_id_subfunction=:tb_subfunctions_id_subfunction, 
                                                      tb_program_id_program=:tb_program_id_program, tb_action_id_action=:tb_action_id_action, tb_beneficiaries_id_beneficiaries=:tb_beneficiaries_id_beneficiaries, 
                                                      tb_source_id_source=:tb_source_id_source, tb_files_id_file=:tb_files_id_file, db_value=:db_value WHERE id_payment = :id;");
                $statement->bindValue(":id", $payment->getIdPayment());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_city (tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction, tb_program_id_program, tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, db_value) 
                                                      VALUES (:tb_city_id_city, :tb_functions_id_function, :tb_subfunctions_id_subfunction, :tb_program_id_program, :tb_action_id_action, :tb_beneficiaries_id_beneficiaries, :tb_source_id_source, :tb_files_id_file, :db_value)");
            }
            $statement->bindValue(":tb_city_id_city",$payment->getTbCityIdCity());
            $statement->bindValue(":tb_functions_id_function",$payment->getTbFunctionsIdFunction());
            $statement->bindValue(":tb_subfunctions_id_subfunction",$payment->getTbSubfunctionsIdSubfunction());
            $statement->bindValue(":tb_program_id_program",$payment->getTbProgramIdProgram());
            $statement->bindValue(":tb_action_id_action",$payment->getTbActionIdAction());
            $statement->bindValue(":tb_beneficiaries_id_beneficiaries",$payment->getTbBeneficiariesIdBeneficiaries());
            $statement->bindValue(":tb_source_id_source",$payment->getTbSourceIdSource());
            $statement->bindValue(":tb_files_id_file",$payment->getTbFilesIdFile());
            $statement->bindValue(":db_value",$payment->getDbValue());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> alert('Dados salvos com sucesso !'); </script>";
                } else {
                    return "<script> alert('Erro ao cadastrar !'); </script>";
                }
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function update($payment){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_payment, tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction, tb_program_id_program, 
                                                  tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, db_value 
                                                  FROM tb_payments WHERE id_payment = :id");
            $statement->bindValue(":id", $payment->getIdPayment());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $payment->setIdPayment($rs->id_payment);
                $payment->setTbCityIdCity($rs->tb_city_id_city);
                $payment->setTbFunctionsIdFunction($rs->tb_functions_id_function);
                $payment->setTbSubfunctionsIdSubfunction($rs->tb_subfunctions_id_subfunction);
                $payment->setTbProgramIdProgram($rs->tb_program_id_program);
                $payment->setTbActionIdAction($rs->tb_action_id_action);
                $payment->setTbBeneficiariesIdBeneficiaries($rs->tb_beneficiaries_id_beneficiaries);
                $payment->setTbSourceIdSource($rs->tb_source_id_source);
                $payment->setTbFilesIdFile($rs->tb_files_id_file);
                $payment->setDbValue($rs->db_value);

                return $payment;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function pagedTable() {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT P.id_payment, C.str_name_city as tb_city, P.tb_city_id_city, P.tb_functions_id_function, P.tb_subfunctions_id_subfunction, P.tb_program_id_program, 
                                                  P.tb_action_id_action, P.tb_beneficiaries_id_beneficiaries, P.tb_source_id_source, P.tb_files_id_file, P.db_value 
                                                  FROM tb_payments P INNER JOIN tb_city C ON C.id_city = P.tb_city_id_city LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_payments";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);


        $primeira_pagina = 1;


        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);


        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;


        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;


        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;


        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;


        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';


        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
        <th style='text-align: center; font-weight: bolder;'>Code</th>
        <th style='text-align: center; font-weight: bolder;'>City</th>
        <th style='text-align: center; font-weight: bolder;'>Function</th>
        <th style='text-align: center; font-weight: bolder;'>Sub-Function</th>
        <th style='text-align: center; font-weight: bolder;'>Program</th>
        <th style='text-align: center; font-weight: bolder;'>Action</th>
        <th style='text-align: center; font-weight: bolder;'>Beneficiaries</th>
        <th style='text-align: center; font-weight: bolder;'>Source</th>
        <th style='text-align: center; font-weight: bolder;'>Files</th>
        <th style='text-align: center; font-weight: bolder;'>Value</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $paym):
                echo "<tr>
        <td style='text-align: center'>$paym->id_payment</td>
        <td style='text-align: center'>$paym->tb_city_id_city</td>
        <td style='text-align: center'>$paym->tb_functions_id_function</td>
        <td style='text-align: center'>$paym->tb_subfunctions_id_subfunction</td>
        <td style='text-align: center'>$paym->tb_program_id_program</td>
        <td style='text-align: center'>$paym->tb_action_id_action</td>
        <td style='text-align: center'>$paym->tb_beneficiaries_id_beneficiaries</td>
        <td style='text-align: center'>$paym->tb_source_id_source</td>
        <td style='text-align: center'>$paym->tb_files_id_file</td>
        <td style='text-align: center'>$paym->db_value</td>
        <td style='text-align: center'><a href='?act=upd&id=$paym->id_payment' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$paym->id_payment' title='Remover'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

     <div class='box-paginacao' style='text-align: center'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'> PRIMEIRA  |</a>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'> ANTERIOR  |</a>
";


            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'> ( $i ) </a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>| PRÓXIMA  </a>
                  <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina'  title='Última Página'>| ÚLTIMO  </a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }

    public function findAll()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_payment, tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction, tb_program_id_program, 
                                                  tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, db_value 
                                                  FROM tb_payments");
            if ($statement->execute()) {
                $listaPayment= $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaPayment;
            }else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllBeneficiariesCity()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT id_beneficiaries, str_name_person, str_nis, id_city, str_name_city, str_cod_siafi_city, tb_state_id_state FROM db_eca.tb_payments, db_eca.tb_city, db_eca.tb_beneficiaries WHERE tb_beneficiaries.id_beneficiaries = tb_payments.tb_beneficiaries_id_beneficiaries AND tb_payments.tb_city_id_city = tb_city.id_city ORDER BY tb_city.str_name_city, tb_beneficiaries.str_name_person;');
            if ($statement->execute()) {
                $listaBeneficiariesCity = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaBeneficiariesCity;
            }else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPayments()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT tb_payments.id_payment idPayment, tb_city.str_name_city nameCity, db_eca.tb_functions.str_name_function nameFunction, tb_subfunctions.str_name_subfunction nameSubfunction, tb_program.str_name_program nameProgram, tb_action.str_name_action nameAction, tb_beneficiaries.str_name_person namePerson, tb_source.str_goal Goal, tb_files.str_name_file nameFile
                                                  FROM db_eca.tb_payments, tb_city, db_eca.tb_functions, tb_beneficiaries, tb_action, tb_program, tb_subfunctions, tb_source, tb_files 
                                                  where tb_payments.tb_city_id_city = tb_city.id_city 
                                                  AND tb_payments.tb_beneficiaries_id_beneficiaries = tb_beneficiaries.id_beneficiaries 
                                                  AND tb_payments.tb_action_id_action = tb_action.id_action 
                                                  AND tb_payments.tb_program_id_program = tb_program.id_program 
                                                  AND tb_payments.tb_subfunctions_id_subfunction = tb_subfunctions.id_subfunction 
                                                  AND tb_payments.tb_source_id_source = tb_source.id_source 
                                                  AND tb_payments.tb_functions_id_function = db_eca.tb_functions.id_function 
                                                  AND tb_payments.tb_files_id_file = tb_files.id_file;');
            if ($statement->execute()) {
                $listaPayments = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaPayments;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPaymentsCity()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM (db_value) totalSum, tb_city.str_name_city nameCity, 
                                                  COUNT (DISTINCT db_eca.tb_payments.tb_beneficiaries_id_beneficiaries) counter 
                                                  FROM db_eca.tb_payments, tb_city 
                                                  WHERE tb_payments.id_payment = tb_city.id_city 
                                                  GROUP BY tb_payments.tb_city_id_city 
                                                  ORDER BY SUM (db_value) DESC;');
            if ($statement->execute()) {
                $listaPaymentsCity = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaPaymentsCity;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPaymentsRegion()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM (db_value) totalValue, str_name_region nameRegion 
                                                  FROM db_eca.tb_payments, tb_city, tb_state, tb_region 
                                                  WHERE tb_payments.id_payment = tb_city.id_city 
                                                  AND tb_city.tb_state_id_state = tb_state.id_state 
                                                  AND tb_state.tb_region_id_region = tb_region.id_region 
                                                  GROUP BY tb_region.id_region 
                                                  ORDER BY tb_state.str_name;');
            if ($statement->execute()) {
                $listaPaymentsRegion = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaPaymentsRegion;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPaymentsState()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM (db_value) totalValue, str_name 
                                                  FROM db_eca.tb_payments, tb_city, tb_state 
                                                  WHERE tb_payments.id_payment = tb_city.id_city 
                                                  AND tb_city.tb_state_id_state = tb_state.id_state 
                                                  GROUP BY tb_state.id_state 
                                                  ORDER BY tb_state.str_name;');
            if ($statement->execute()) {
                $listaPaymentsState = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listaPaymentsState;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

}