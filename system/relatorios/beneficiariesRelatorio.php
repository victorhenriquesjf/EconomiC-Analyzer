<?php
//So funciona se desativar os erros!
ini_set('display_errors', 1);

//include("../libs/mpdf/mpdf.php");
require_once "../libs/mpdf/mpdf.php";
require_once "../db/alunoDAO.php";

$alunoDAO = new alunoDAO();

$listObjs = $alunoDAO->findAll();

foreach ($listObjs as $var):
    $html.=$var->Nome.='<br>';
endforeach;

$mpdf=new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Tassio Sirqueira');
$mpdf->SetTitle('TCPDF Exemplo');
$mpdf->SetSubject('TCPDF Aula');
$mpdf->SetKeywords('TCPDF, PDF, exemplo');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Exemplo.pdf','I');

exit;