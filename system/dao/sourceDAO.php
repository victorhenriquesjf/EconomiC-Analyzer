<?php
require_once "db/conexao.php";
require_once "classes/source.php";

class sourceDAO
{
    public function delete($source)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_source WHERE id_source = :id");
            $statement->bindValue(":id", $source->getIdSource());
            if ($statement->execute()) {
                return "<script> alert('Excluído com sucesso !'); </script>";
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function save($source)
    {
        global $pdo;
        try {
            if ($source->getIdSource() != "") {
                $statement = $pdo->prepare("UPDATE tb_source SET str_goal=:str_goal, str_origin=:str_origin, str_periodicity=:str_periodicity WHERE id_source = :id;");
                $statement->bindValue(":id", $source->getIdSource());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_source (str_goal, str_origin, str_periodicity) VALUES (:str_goal, :str_origin, :str_periodicity)");
            }
            $statement->bindValue(":str_goal", $source->getStrGoal());
            $statement->bindValue(":str_origin", $source->getStrOrigin());
            $statement->bindValue(":str_periodicity", $source->getStrPeriodicity());

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

    public function update($source)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_source, str_goal, str_origin, str_periodicity FROM tb_source WHERE id_source = :id");
            $statement->bindValue(":id", $source->getIdSource());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $source->setIdSource($rs->id_source);
                $source->setStrGoal($rs->str_goal);
                $source->setStrOrigin($rs->str_origin);
                $source->setStrPeriodicity($rs->str_periodicity);

                return $source;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function pagedTable()
    {


        global $pdo;


        $endereco = $_SERVER ['PHP_SELF'];


        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);


        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;


        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;


        $sql = "SELECT id_source, str_goal, str_origin, str_periodicity FROM tb_source LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);


        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_source";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);


        $primeira_pagina = 1;


        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);


        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;


        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;


        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;


        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;


        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';


        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
        <th style='text-align: center; font-weight: bolder;'>Code</th>
        <th style='text-align: center; font-weight: bolder;'>Objectives</th>
        <th style='text-align: center; font-weight: bolder;'>Source</th>
        <th style='text-align: center; font-weight: bolder;'>Frequency</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $source):
                echo "<tr>
        <td style='text-align: center'>$source->id_source</td>
        <td style='text-align: center'>$source->str_goal</td>
        <td style='text-align: center'>$source->str_origin</td>
        <td style='text-align: center'>$source->str_periodicity</td>
        <td style='text-align: center'><a href='?act=upd&id=$source->id_source' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$source->id_source' title='Remover'><i class='ti-close'></i></a></td>
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
        $source = new source();
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_source, str_goal, str_origin, str_periodicity FROM tb_source WHERE id_source = $id");
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $source->setIdSource($rs->id_source);
                $source->setStrGoal($rs->str_goal);
                $source->setStrOrigin($rs->str_origin);
                $source->setStrPeriodicity($rs->str_periodicity);

                return $source;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }


}