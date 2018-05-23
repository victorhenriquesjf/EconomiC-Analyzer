<?php
//So funciona se desativar os erros!
ini_set('display_errors', 1);

//include("../libs/mpdf/mpdf.php");
require_once "../libs/mpdf/mpdf.php";
require_once "../dao/beneficiariesDAO.php";
require_once "../db/conexao.php";

$beneficiDAO = new beneficiariesDAO();

$listObjs = $beneficiDAO->findAll();

$html= '<b>Relatório de Beneficiários</b>';

$html .= '<table border="1" cellspacing="3" cellpadding="4" >
    <tr>
        <th align="right">NIS</th>
        <th align="left">Nome</th>
    </tr>';
    foreach ($listObjs as $var):
$html .= '<tr>
        <td>'.$var->str_nis.'</td>
        <td>'.$var->str_name_person.'</td>
    </tr>';
    endforeach;
$html .= '</table>';

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

