<?php
require_once "../vendor/davefx/phplot/phplot/phplot.php";
require_once "../db/conexao.php";


$grafico = new PHPlot(900 ,800);

$grafico->SetFileFormat("png");

$grafico->SetTitle("");
$grafico->SetXTitle("Estado");
$grafico->SetYTitle("Valor");


$query = "SELECT s.str_name state, sum(p.db_value) valor 
FROM tb_payments p 
inner join tb_city c 
inner join tb_state s 
where p.tb_city_id_city = c.id_city and c.tb_state_id_state = s.id_state
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

$grafico = new \PHPlot(800,600);
$grafico->SetImageBorderType('plain');

$grafico->SetPlotType('pie');
$grafico->SetDataType('text-data-single');
$grafico->SetDataValues($data);


$grafico->SetDataColors(
    array(
        '#F0F8FF', '#FAEBD7', '#7FFFD4', '#D2691E',
        '#FF7F50', '#6495ED', '#FFF8DC', '#DC143C',
        '#00FFFF', '#00008B', '#F0F8FF', '#FAEBD7',
        '#008B8B', '#B8860B', '#A9A9A9', '#006400',
        '#BDB76B', '#8B008B', '#556B2F', '#FF8C00',
        '#9932CC', '#8B0000', '#E9967A', '#8FBC8F',
        '#483D8B')
);

$grafico->SetTitle("Values per state");


foreach ($data as $row)
    $grafico->SetLegend(utf8_decode(implode(': ', $row)));

$grafico->SetLegendPixels(5, 5);


$grafico->SetDataValues($data);
$grafico->SetXLabelAngle(90);


$grafico->DrawGraph();