<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 30/04/2018
 * Time: 13:33
 */
require_once "classes/template.php";

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h1 class='title' style="text-align: center">Sistema de EconomiC Analyzer</h1>
                        <p class='category'></p>
                    </div>
                    <div class='content table-responsive'>
                        <h3 class="title" style="text-align: center">Bem-vindo ao sistema,
                            <!-- <b style="color: #337ab7;"> <?= $logado; ?> </b> </h3> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
