<?php
require_once "db/conexao.php";
require_once "classes/files.php";

class filesDAO
{
    public function delete($files)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_files WHERE id_file = :id");
            $statement->bindValue(":id", $files->getIdFile());
            if ($statement->execute()) {
                return "<script> alert('Excluído com sucesso !'); </script>";
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function save($files)
    {
        global $pdo;
        try {
            if ($files->getIdFile() != "") {
                $statement = $pdo->prepare("UPDATE tb_files SET str_name_file=:str_name_file, str_month=:str_month, str_year=:str_year WHERE id_file = :id;");
                $statement->bindValue(":id", $files->getIdFile());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_files (str_name_file, str_month, str_year) VALUES (:str_name_file, :str_month, :str_year)");
            }
            $statement->bindValue(":str_name_file", $files->getStrNameFile());
            $statement->bindValue(":str_month", $files->getStrMonth());
            $statement->bindValue(":str_year", $files->getStrYear());

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

    public function update($files)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_file, str_name_file, str_month, str_year FROM tb_files WHERE id_file = :id");
            $statement->bindValue(":id", $files->getIdFile());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $files->setIdFile($rs->id_file);
                $files->setStrNameFile($rs->str_name_file);
                $files->setStrMonth($rs->str_month);
                $files->setStrYear($rs->str_year);

                return $files;
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


        $sql = "SELECT id_file, str_name_file, str_month, str_year FROM tb_files LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);


        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_files";
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
        <th style='text-align: center; font-weight: bolder;'>Name</th>
        <th style='text-align: center; font-weight: bolder;'>Month</th>
        <th style='text-align: center; font-weight: bolder;'>Year</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $file):
                echo "<tr>
        <td style='text-align: center'>$file->id_file</td>
        <td style='text-align: center'>$file->str_name_file</td>
        <td style='text-align: center'>$file->str_month</td>
        <td style='text-align: center'>$file->str_year</td>
        <td style='text-align: center'><a href='?act=upd&id=$file->id_file' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$file->id_file' title='Remover'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

     <div class='box-paginacao' style='text-align: center'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'> PRIMEIRA  |</a>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'> ANTERIOR  |</a>
";

            /* Loop para montar a páginação central com os números */
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
        $files = new files();
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_file, str_name_file, str_month, str_year FROM tb_files WHERE id_file = $id");
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $files->setIdFile($rs->id_file);
                $files->setStrNameFile($rs->str_name_file);
                $files->setStrMonth($rs->str_month);
                $files->setStrYear($rs->str_year);

                return $files;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

}