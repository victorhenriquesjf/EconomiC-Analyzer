<?php

require_once "classes/template.php";
require_once "dao/beneficiariesDAO.php";
require_once "dao/paymentsDAO.php";

$template = new Template();
$beneficiariesDAO = new beneficiariesDAO();
$paymentsDAO = new paymentsDAO();

$result = $paymentsDAO->payLastMonth()["paySum"]  /  $paymentsDAO->payLastMonth()["qnt"];

$template->header();
$template->sidebar();
$template->mainpanel();

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <i class="ti-server"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Payments</p>
                                    <p style="font-size: 60%"><?php echo '<br/>R$'. number_format($paymentsDAO->sumAllPayments()['payToal'], 2, ',', ' '); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-info"></i> Total sum
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-success text-center">
                                    <i class="ti-wallet"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Payments</p>
                                    <p style="font-size: 60%"><?php echo '<br/>R$'. number_format($paymentsDAO->payLastMonth()["db_value"], 2, ',', ' '); ?></p >
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-calendar"></i> Last Month
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-pulse"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Average</p>
                                    <p style="font-size: 60%"><?php echo '<br/>R$'. number_format($result, 2, ',', ' '); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-timer"></i> In the last month
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-info text-center">
                                    <i class="ti-user"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Beneficiaries</p>
                                    <p style="font-size: 60%"><?php echo '<br/>'.$beneficiariesDAO->countAll();?></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-info"></i> Total
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Monthly beneficiaries</h4>
                        <p class="category">Every year</p>
                    </div>
                    <div class="content">
                        <div id="chartHours" >
                            <img alt="" src="graficos/beneficiarioMesAno_grafico-IMAGEM.php" title="">
                        </div>
                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <a href="graficos/beneficiarioMesAno_grafico.php" target="_blank">  Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Beneficiaries by state</h4>
                        <p class="category">Monthly update</p>
                    </div>
                    <div class="content">
                        <div id="chartPreferences">
                            <img alt="" src="graficos/beneficiarioMesEstado_grafico-IMAGEM.php" title="">
                        </div>

                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <a href="graficos/beneficiarioMesEstado_grafico.php" target="_blank"> Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card ">
                    <div class="header">
                        <h4 class="title">Values per state</h4>
                        <p class="category">Monthly update</p>
                    </div>
                    <div class="content">
                        <div id="chartActivity">
                            <img alt="" src="graficos/valoreMesEstado_grafico-IMAGEM.php" title="">
                        </div>

                        <div class="footer">
                            <div class="stats">
                                <a href="graficos/valoreMesEstado_grafico.php" target="_blank"> Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$template->footer();

?>
