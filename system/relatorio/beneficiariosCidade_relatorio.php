<?php
//So funciona se desativar os erros!
ini_set('display_errors', 1);

//include("../libs/mpdf/mpdf.php");
require_once "../libs/mpdf/mpdf.php";
require_once "../dao/paymentsDAO.php";
require_once "../dao/cityDAO.php";
require_once "../dao/beneficiariesDAO.php";
require_once "../db/conexao.php";

$paymentsDAO = new paymentsDAO();
$cityDAo = new cityDAO();
$beneficiariesDAO = new beneficiariesDAO();

$listObjs = $paymentsDAO->findAllBeneficiariesCity();

$html= '<b>Relatório de Beneficiários e suas Cidades</b>';

$html .= '<table border="1" cellspacing="3" cellpadding="4" >
    <tr>
        <th align="right">Beneficiario</th>
        <th align="left">Cidade</th>
    </tr>';
foreach ($listObjs as $key):
    $ben = $beneficiariesDAO->findId($value->getTbBeneficiariesIdBeneficiaries());
    $cit = $cityDAo ->findId($value->getTbCityIdCity());
    $html .= '<tr>
        <td>'.$ben->getStrNamePerson().'</td>
        <td>'.$cit->getStrNameCity().'</td>
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