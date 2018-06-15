<?php
ini_set('display_errors', 0);

require_once "../vendor/mpdf/mpdf.php";
require_once "../dao/reportDAO.php";
require_once "../db/conexao.php";

$reportDAO = new reportDAO();
$listObjs = $reportDAO->sumBeneficiariesHelp();

date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
echo $date;

$html= '<b>Beneficiaries help</b><br/>'.'<b>DATE AND TIME:  </b>'.$date;
$html .= "<table border='1' cellspacing='0' cellpadding='2' bordercolor='666633'>";
$html .= "<tr>
            <th colspan='5' align='center'>TOTAL PAYMENTS PER BENEFICIARY</th>
        </tr>";
$html .= "<tr>
            <th>NAME</th>
            <th>QUANTITY OF PAYMENTS</th>
            <th>TOTAL PAID</th>
            <th>MONTH</th>
            <th>YEAR</th>
        </tr>";
foreach ($listObjs as $key):
    $html.= "<tr>
                <td>$key->tb_beneficiaries</td>
                <td>$key->qnt</td>
                <td>$key->valuesSum</td>
                <td>$key->int_month</td>
                <td>$key->int_year</td>
          </tr>";
endforeach;
$html .= "</table>";

$mpdf = new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Victor/Adilson');
$mpdf->SetTitle('TOTAL PAYMENTS PER BENEFICIARY');
$mpdf->SetSubject('TOTAL PAYMENTS PER BENEFICIARY');
$mpdf->SetKeywords('TCPDF, PDF, beneficiarios');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Exemplo.pdf', 'I');

exit;