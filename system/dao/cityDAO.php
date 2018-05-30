<?php
require_once "db/conexao.php";
require_once "classes/city.php";

class cityDAO
{
    public function delete($city)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_city WHERE id_city = :id");
            $statement->bindValue(":id", $city->getIdCity());
            if ($statement->execute()) {
                return "<script> alert('Excluído com sucesso !'); </script>";
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function save($city)
    {
        global $pdo;
        try {
            if ($city->getIdCity() != "") {
                $statement = $pdo->prepare("UPDATE tb_city SET str_name_city=:str_name_city, str_cod_siafi_city=:str_cod_siafi_city, tb_state_id_state=:tb_state_id_state WHERE id_city = :id;");
                $statement->bindValue(":id", $city->getIdCity());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_city (str_name_city, str_cod_siafi_city, tb_state_id_state) VALUES (:str_name_city, :str_cod_siafi_city, :tb_state_id_state)");
            }
            $statement->bindValue(":str_name_city",$city->getStrNameCity());
            $statement->bindValue(":str_cod_siafi_city",$city->getStrCodSiafiCity());
            $statement->bindValue(":tb_state_id_state",$city->getTbStateIdState());

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

    public function update($city){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_city, str_name_city, str_cod_siafi_city, tb_state_id_state FROM tb_city WHERE id_city = :id");
            $statement->bindValue(":id", $city->getIdCity());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $city->setIdCity($rs->id_city);
                $city->setStrNameCity($rs->str_name_city);
                $city->setStrCodSiafiCity($rs->str_cod_siafi_city);
                $city->setTbStateIdState($rs->tb_state_id_state);
                return $city;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function pagedTable() {


        global $pdo;


        $endereco = $_SERVER ['PHP_SELF'];


        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);


        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;


        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;


        $sql = "SELECT C.id_city, S.str_uf as tb_state, C.str_name_city, C.str_cod_siafi_city FROM tb_city C INNER JOIN tb_state S ON S.id_state = C.tb_state_id_state LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);


        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_city";
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
        <th style='text-align: center; font-weight: bolder;'>Name</th>
        <th style='text-align: center; font-weight: bolder;'>Code City</th>
        <th style='text-align: center; font-weight: bolder;'>State</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $city):
                echo "<tr>
        <td style='text-align: center'>$city->id_city</td>
        <td style='text-align: center'>$city->str_name_city</td>
        <td style='text-align: center'>$city->str_cod_siafi_city</td>
        <td style='text-align: center'>$city->tb_state</td>
        <td style='text-align: center'><a href='?act=upd&id=$city->id_city' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$city->id_city' title='Remover'><i class='ti-close'></i></a></td>
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

    public function findId($id)
    {
        $city= new city();
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_city, str_name_city, str_cod_siafi_city, tb_state_id_state FROM tb_city WHERE id_city = $id");
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $city->setIdCity($rs->id_city);
                $city->setStrNameCity($rs->str_name_city);
                $city->setStrCodSiafiCity($rs->str_cod_siafi_city);
                $city->setTbStateIdState($rs->tb_state_id_state);
                
                return $city;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

}