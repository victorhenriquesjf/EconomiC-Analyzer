<?php

require_once "../../vendor/davefx/phplot/phplot/phplot.php";
require_once "../db/conexao.php";

#Instancia o objeto e setando o tamanho do grafico na tela
$grafico = new PHPlot(600 ,600);

$grafico->SetFileFormat("png");

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
$grafico->SetTitle("");
$grafico->SetXTitle("ano");
$grafico->SetYTitle("total");


//$id = $_GET['id'];
//$id = '1';
$query = "SELECT f.str_year ano, count(b.id_beneficiaries) valor
FROM tb_beneficiaries b 
inner join tb_payments p 
inner join tb_files f 
where b.id_beneficiaries = p.tb_beneficiaries_id_beneficiaries and p.tb_files_id_file = f.id_file
group by f.str_year; ";

/*$query = "SELECT COUNT(id_beneficiaries) total
FROM tb_beneficiaries b
inner join tb_payments p
inner join tb_program program
where b.id_beneficiaries = p.tb_beneficiaries_id_beneficiaries and p.tb_program_id_program = program.id_program
;";*/

$statement = $pdo->prepare($query);
//$statement->bindValue(":id", $id);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$data = array();

if(isset($resultado)) {
    foreach ($resultado as $r){
        $data[] = [$r['ano'], $r['valor']];
    }
} else {
    $data[]=[null,null];
}

//$grafico->SetDefaultTTFont('assets/fonts/Timeless.ttf');

$grafico->SetDataValues($data);

#Neste caso, usariamos o gráfico em barras
$grafico->SetPlotType("bars");

#Exibimos o gráfico
$grafico->DrawGraph();
