<?php

require_once "classes/template.php";

require_once "dao/fishermanInsuranceDao.php";
require_once "classes/fishermanInsurance.php";

$object = new actionDAO();

$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $str_month = (isset($_POST["str_month"]) && $_POST["str_month"] != null) ? $_POST["str_month"] : "";
    $str_year = (isset($_POST["str_year"]) && $_POST["str_year"] != null) ? $_POST["str_year"] : "";
    $str_month = (isset($_POST["db_value"]) && $_POST["db_value"] != null) ? $_POST["db_value"] : "";
    $str_year = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
    $str_month = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";

} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $str_month = NULL;
    $str_year = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $action = new action($id, '', '');

    $resultado = $object->atualizar($action);
    $str_month = $resultado->getStrMonth();
    $str_year = $resultado->getStrYear();
    $db_value = $resultado->getDbValue();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $tb_city_id_city = $resultado->getTbCityIdCity();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_year != "" && $str_month != "" && $db_value!="" && $tb_beneficiaries_id_beneficiaries!="" && $tb_city_id_city!="") {
    $action = new action($id, $str_month, $str_year,$db_value,$tb_beneficiaries_id_beneficiaries,$tb_city_id_city);

    $msg = $object->salvar($action);
    $id = null;
    $str_month = null;
    $str_year = null;
    $db_value = null;
    $tb_beneficiaries_id_beneficiaries=null;
    $tb_city_id_city=null;

}

if (isset($_REQUEST["fish"]) && $_REQUEST["fish"] == "del" && $id != "") {
    $fish = new fishermanInsurance($id, '', '','','','');

    $msg = $object->remover($afish);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Action</h4>
                        <p class='category'>List of system actions</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Year:
                            <input class="form-control" type="text" size="50" name="str_year" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year) && ($str_year != null || $str_year != "")) ? $str_year : '';
                            ?>"/>
                            <br/>
                            Month:
                            <input class="form-control" type="text" size="10" name="str_month" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($str_month) && ($str_month != null || $str_month != "")) ? $str_month : '';
                            ?>"/>
                            Value:
                            <input class="form-control" type="text" size="10" name="db_value" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($db_value) && ($db_value != null || $db_value != "")) ? $db_value : '';
                            ?>"/>
                            Beneficiaries:
                            <input class="form-control" type="text" size="10" name="tb_beneficiaries_id_beneficiaries" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($tb_beneficiaries_id_beneficiaries) && ($tb_beneficiaries_id_beneficiaries != null || $tb_beneficiaries_id_beneficiaries != "")) ? $tb_beneficiaries_id_beneficiaries : '';
                            ?>"/>
                            City:
                            <input class="form-control" type="text" size="10" name="tb_city_id_city" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($tb_city_id_city) && ($tb_city_id_city != null || $tb_city_id_city != "")) ? $tb_city_id_city : '';
                            ?>"/>
                            <br/>
                            <input class="btn btn-success" type="submit" value="REGISTER">
                            <hr>
                        </form>


                        <?php

                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';

                        //chamada a paginação
                        $object->tabelapaginada();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
