<?php
ini_set('display_errors', 0);

require_once "../vendor/mpdf/mpdf.php";
require_once "../dao/reportDAO.php";
require_once "../db/conexao.php";

$reportDAO = new reportDAO();
$listObjs = $reportDAO->findAllBeneficiariesCity();

date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
echo $date;

$html= '<b>Beneficiary Report by City</b><br/>'.'<b>DATE AND TIME:  </b>'.$date;
$html .= "<table border='1' cellspacing='0' cellpadding='2' bordercolor='666633'>";
$html .= "<tr>
            <th colspan='3' align='center'>BENEFICIARIES BY CITY</th>
        </tr>";
$html .= "<tr>
            <th>CODE</th>
            <th>NAME</th>
            <th>NIS</th>
            <th>CODE CITY</th>
            <th>CITY</th>
            <th>SIAFI CODE</th>
            <th>STATE CODE</th>
        </tr>";
foreach ($listObjs as $key):
    $html.= "<tr>
                <td>$key->id_beneficiaries</td>
                <td>$key->str_name_person</td>
                <td>$key->str_nis</td>
                <td>$key->id_city</td>
                <td>$key->str_name_city</td>
                <td>$key->str_cod_siafi_city</td>
                <td>$key->tb_state_id_state</td>
          </tr>";
endforeach;
$html .= "</table>";

$mpdf = new mPDF();
$mpdf->SetCreator(PDF_CREATOR);
$mpdf->SetAuthor('Victor/Adilson');
$mpdf->SetTitle('BENEFICIARIES BY CITY');
$mpdf->SetSubject('BENEFICIARIES BY CITY');
$mpdf->SetKeywords('TCPDF, PDF, beneficiarios');
$mpdf->SetDisplayMode('fullpage');
$mpdf->nbpgPrefix = ' de ';
$mpdf->setFooter('Página {PAGENO}{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Exemplo.pdf', 'I');

exit;