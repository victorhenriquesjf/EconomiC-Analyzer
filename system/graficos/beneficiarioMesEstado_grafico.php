<?php
require_once "../../vendor/davefx/phplot/phplot/phplot.php";
require_once "../db/conexao.php";
require_once "../graficos/mem_image.php";

#Instancia o objeto e setando o tamanho do grafico na tela
$grafico = new PHPlot(900 ,800);

$grafico->SetFileFormat("png");

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
$grafico->SetTitle("");
$grafico->SetXTitle("Estado");
$grafico->SetYTitle("Valor");

//$id = $_GET['id'];
//$id = '1';
$query = "SELECT s.str_name state, count(b.id_beneficiaries) valor
FROM tb_beneficiaries b 
inner join tb_payments p 
inner join tb_city c
inner join tb_state s 
where  b.id_beneficiaries = p.tb_beneficiaries_id_beneficiaries and p.tb_city_id_city = c.id_city and c.tb_state_id_state = s.id_state
group by s.id_state ;";





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
        $data[] = [$r['state'], $r['valor']];
    }
} else {
    $data[]=[null,null];
}

//$grafico->SetDefaultTTFont('assets/fonts/Timeless.ttf');

$grafico->SetDataValues($data);
$grafico->SetXLabelAngle(90);
#Neste caso, usariamos o gráfico em barras
$grafico->SetPlotType("bars");

$grafico->SetYTickLabelPos('none');
$grafico->SetYTickPos('none');

# Format the Y Data Labels as numbers with 1 decimal place.
# Note that this automatically calls SetYLabelType('data').
$grafico->SetPrecisionY(1);

//Disable image output
$grafico->SetPrintImage(false);
//Draw the graph
$grafico->DrawGraph();

$pdf = new PDF_MemImage();
$pdf->AddPage();
$pdf->GDImage($grafico->img,30,20,140);
$pdf->Output();
return $grafico->EncodeImage('base64');

