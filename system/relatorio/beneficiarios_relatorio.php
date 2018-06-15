<?php
ini_set('display_errors', 0);

require_once "../vendor/mpdf/mpdf.php";
require_once "../dao/reportDAO.php";
require_once "../db/conexao.php";

$reportDAO = new reportDAO();
$listObjs = $reportDAO->findAllBeneficiaries();

date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
echo $date;

$html= '<b>Beneficiary Report</b><br/>'.'<b>DATE AND TIME:  </b>'.$date;
$html .= "<table border='1' cellspacing='0' cellpadding='2' bordercolor='666633'>";
$html .= "<tr>
            <th colspan='3' align='center'>BENEFICIARIES</th>
        </tr>";
$html .= "<tr>
            <th>CODE</th>
            <th>NIS</th>
            <th>NAME</th>
        </tr>";
foreach ($listObjs as $key):
    $html.= "<tr>
                <td>$key->id_beneficiaries</td>
                <td>$key->str_nis</td>
                <td>$key->str_name_person</td>
          </tr>";
endforeach;
$html .= "</table>";

$mpdf = new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Victor/Adilson');
$mpdf->SetTitle('Beneficiaries');
$mpdf->SetSubject('Beneficiaries');
$mpdf->SetKeywords('TCPDF, PDF, beneficiarios');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Exemplo.pdf', 'I');

exit;