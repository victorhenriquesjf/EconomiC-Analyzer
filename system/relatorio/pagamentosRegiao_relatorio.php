<?php
ini_set('display_errors', 0);

require_once "../vendor/mpdf/mpdf.php";
require_once "../dao/reportDAO.php";
require_once "../db/conexao.php";

$reportDAO = new reportDAO();
$listObjs = $reportDAO->findAllPaymentsRegion();

date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
echo $date;

$html= '<b>Report of amounts paid to each region</b><br/>'.'<b>DATE AND TIME:  </b>'.$date;
$html .= "<table border='1' cellspacing='0' cellpadding='2' bordercolor='666633'>";
$html .= "<tr>
            <th colspan='3' align='center'>TOTAL PAYMENTS BY REGION</th>
        </tr>";
$html .= "<tr>
            <th>TOTAL PAID</th>
            <th>REGION</th>
        </tr>";
foreach ($listObjs as $key):
    $html.= "<tr>
                <td>$key->valuesSum</td>
                <td>$key->str_name_region</td>
            </tr>";
endforeach;
$html .= "</table>";

$mpdf = new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Victor/Adilson');
$mpdf->SetTitle('TOTAL PAYMENTS BY REGION');
$mpdf->SetSubject('TOTAL PAYMENTS BY REGION');
$mpdf->SetKeywords('TCPDF, PDF, beneficiarios');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Exemplo.pdf', 'I');

exit;