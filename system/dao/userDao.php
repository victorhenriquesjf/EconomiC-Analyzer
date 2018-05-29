<?php
require_once "../db/conexao.php";
require_once "../classes/user.php";

class userDao
{
    public function delete($user)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_user WHERE id_user = :id");
            $statement->bindValue(":id", $user->getIdUser());
            if ($statement->execute()) {
                return "<script> alert('Excluído com sucesso !'); </script>";
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function save($user)
    {
        global $pdo;
        try {
            if ($user->getIdUser() != "") {
                $statement = $pdo->prepare("UPDATE tb_user SET name_user=:name_user, login=:login, password=:password, status=:status  WHERE id_user = :id;");
                $statement->bindValue(":id", $user->getIdUser());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_user (name_user, login, password, status ) VALUES (:name_user, :login, :password, :status)");
            }
            $statement->bindValue(":name_user", $user->getNameUser());
            $statement->bindValue(":login", $user->getLogin());
            $statement->bindValue(":password", $user->getPassword());
            $statement->bindValue(":status", $user->getStatus());

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

    public function update($user)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT name_user, login, password, status FROM tb_user WHERE id_user = :id");
            $statement->bindValue(":id", $user->getIdUser());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $user->setNameUser($rs->name_user);
                $user->setLogin($rs->login);
                $user->setPassword($rs->password);
                $user->setStatus($rs->status);

                return $user;
            } else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function pagedTable()
    {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT id_user, name_user, login, password, status FROM tb_user LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_user";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
        <th style='text-align: center; font-weight: bolder;'>Identificador</th>
        <th style='text-align: center; font-weight: bolder;'>Nome</th>
        <th style='text-align: center; font-weight: bolder;'>Login</th>
        <th style='text-align: center; font-weight: bolder;'>Senha</th>
        <th style='text-align: center; font-weight: bolder;'>Status</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
        <td style='text-align: center'>$acti->id_user</td>
        <td style='text-align: center'>$acti->name_user</td>
        <td style='text-align: center'>$acti->login</td>
        <td style='text-align: center'>$acti->password</td>
        <td style='text-align: center'>$acti->status</td>
        <td style='text-align: center'><a href='?act=upd&id=$acti->id_user' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$acti->id_user' title='Remover'><i class='ti-close'></i></a></td>
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

}