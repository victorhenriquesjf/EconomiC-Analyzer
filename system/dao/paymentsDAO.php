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
                                                      tb_source_id_source=:tb_source_id_source, tb_files_id_file=:tb_files_id_file,int_month,:int_month, int_year:int_year, db_value=:db_value WHERE id_payment = :id;");
                $statement->bindValue(":id", $payment->getIdPayment());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_payments (tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction, tb_program_id_program, tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, int_month, int_year, db_value) 
                                                      VALUES (:tb_city_id_city, :tb_functions_id_function, :tb_subfunctions_id_subfunction, :tb_program_id_program, :tb_action_id_action, :tb_beneficiaries_id_beneficiaries, :tb_source_id_source, :tb_files_id_file, :int_month, :int_year, :db_value)");
            }
            $statement->bindValue(":tb_city_id_city",$payment->getTbCityIdCity());
            $statement->bindValue(":tb_functions_id_function",$payment->getTbFunctionsIdFunction());
            $statement->bindValue(":tb_subfunctions_id_subfunction",$payment->getTbSubfunctionsIdSubfunction());
            $statement->bindValue(":tb_program_id_program",$payment->getTbProgramIdProgram());
            $statement->bindValue(":tb_action_id_action",$payment->getTbActionIdAction());
            $statement->bindValue(":tb_beneficiaries_id_beneficiaries",$payment->getTbBeneficiariesIdBeneficiaries());
            $statement->bindValue(":tb_source_id_source",$payment->getTbSourceIdSource());
            $statement->bindValue(":tb_files_id_file",$payment->getTbFilesIdFile());
            $statement->bindValue(":int_month",$payment->getIntMonth());
            $statement->bindValue(":int_year",$payment->getIntYear());
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
                                                  tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file,getIntMonth,getIntYear, db_value 
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
                $payment->setDbValue($rs->getIntMonth);
                $payment->setDbValue($rs->getIntYear);
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
                $statement = $pdo->prepare("SELECT str_name_city FROM tb_city WHERE id_city = :id");
                $statement->bindValue(":id", $paym->tb_city_id_city);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $str_name_city = $rs->str_name_city;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_name_function FROM tb_functions WHERE id_function = :id");
                $statement->bindValue(":id", $paym->tb_functions_id_function);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_functions_id_function = $rs->str_name_function;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_name_subfunction FROM tb_subfunctions WHERE id_subfunction = :id");
                $statement->bindValue(":id", $paym->tb_subfunctions_id_subfunction);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_subfunctions_id_subfunction = $rs->str_name_subfunction;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_name_program FROM tb_program WHERE id_program = :id");
                $statement->bindValue(":id", $paym->tb_program_id_program);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_program_id_program = $rs->str_name_program;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_name_action FROM tb_action WHERE id_action = :id");
                $statement->bindValue(":id", $paym->tb_action_id_action);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_action_id_action = $rs->str_name_action;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_name_person FROM tb_beneficiaries WHERE id_beneficiaries = :id");
                $statement->bindValue(":id", $paym->tb_beneficiaries_id_beneficiaries);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_beneficiaries_id_beneficiaries = $rs->str_name_person;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_goal FROM tb_source WHERE id_source = :id");
                $statement->bindValue(":id", $paym->tb_source_id_source);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_source_id_source = $rs->str_goal;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                $statement = $pdo->prepare("SELECT str_name_file FROM tb_files WHERE id_file = :id");
                $statement->bindValue(":id", $paym->tb_files_id_file);
                if ($statement->execute()) {
                    $rs = $statement->fetch(PDO::FETCH_OBJ);
                    $tb_files_id_file = $rs->str_name_file;
                } else {
                    throw new PDOException("Erro na declaração SQL !");
                }

                echo "<tr>
                <td style='text-align: center'>$paym->id_payment</td>
                <td style='text-align: center'>$str_name_city</td>
                <td style='text-align: center'>$tb_functions_id_function</td>
                <td style='text-align: center'>$tb_subfunctions_id_subfunction</td>
                <td style='text-align: center'>$tb_program_id_program</td>
                <td style='text-align: center'>$tb_action_id_action</td>
                <td style='text-align: center'>$tb_beneficiaries_id_beneficiaries</td>
                <td style='text-align: center'>$tb_source_id_source</td>
                <td style='text-align: center'>$tb_files_id_file</td>
                <td style='text-align: center'>$paym->db_value</td>
                <td style='text-align: center'><a href='?act=upd&id_payment=$paym->id_payment' title='Alterar'><i class='ti-reload'></i></a></td>
                <td style='text-align: center'><a href='?act=del&id_payment=$paym->id_payment' title='Remover'><i class='ti-close'></i></a></td>
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

    public function payLastMonth()
    {
        global $pdo;
        try {
            $sql = 'SELECT COUNT(id_payment) qnt, 
                    SUM(db_value) paySum, db_value
                    FROM tb_payments 
                    GROUP BY int_month, int_year 
                    ORDER BY int_year DESC, int_month DESC LIMIT 1;';
            $statement = $pdo->prepare($sql);
            if ($statement->execute()) {
                $st = $statement->fetchAll(PDO::FETCH_OBJ);
                $payLastMonth = array(
                    'qnt' => $st[0]->qnt,
                    'paySum' => $st[0]->paySum,
                    'db_value' => $st[0]->db_value
                );

                return $payLastMonth;

            }else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function sumAllPayments()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM(db_value) payToal FROM tb_payments;');
            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                $sumAllPayments = array(
                    'payToal' => $rs[0]->payToal
                );
                return $sumAllPayments;
            }else {
                throw new PDOException("<script> alert('Erro: Não foi possível executar a declaração sql'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }





}