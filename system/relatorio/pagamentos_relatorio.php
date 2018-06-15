<?php
ini_set('display_errors', 0);

require_once "../../vendor/mpdf/mpdf.php";
require_once "../dao/reportDAO.php";
require_once "../db/conexao.php";

$reportDAO = new reportDAO();
$listObjs = $reportDAO->findAllPayments();

date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
echo $date;

$html= '<b>Report of all payments</b><br/>'.'<b>DATE AND TIME:  </b>'.$date;
$html .= "<table border='1' cellspacing='0' cellpadding='2' bordercolor='666633'>";
$html .= "<tr>
            <th colspan='9' align='center'>PAYMENTS</th>
        </tr>";
$html .= "<tr>
            <th>PAYMENT CODE</th>
            <th>CITY</th>
            <th>FUNCTION</th>
            <th>SUBFUNCTION</th>
            <th>PROGRAM</th>
            <th>ACTION</th>
            <th>BENEFICIARIES</th>
            <th>NIS</th>
            <th>ARCHIVE</th>
        </tr>";
foreach ($listObjs as $key):
    $html.= "<tr>
                <td>$key->id_payment</td>
                <td>$key->str_name_city</td>
                <td>$key->str_name_function</td>
                <td>$key->str_name_subfunction</td>
                <td>$key->str_name_program</td>
                <td>$key->str_name_action</td>
                <td>$key->str_name_person</td>
                <td>$key->str_goal</td>
                <td>$key->str_name_file</td>
          </tr>";
endforeach;
$html .= "</table>";

$mpdf = new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Victor/Adilson');
$mpdf->SetTitle(' PAYMENTS');
$mpdf->SetSubject(' PAYMENTS');
$mpdf->SetKeywords('TCPDF, PDF, beneficiarios');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Exemplo.pdf', 'I');

exit;