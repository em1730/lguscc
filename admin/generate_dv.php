<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['account'])) {

//        echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

 $office = $_POST['office'];
 $dv_no = $_POST['dv'];
 $type = $_POST['type'];
 $user = $_POST['user'];



//select dv settings
$get_dvno_sql = "SELECT `dvno` FROM `tbl_settings`";
$get_dvno_data = $con->prepare($get_dvno_sql);
$get_dvno_data->execute();  
 while ($result = $get_dvno_data->fetch(PDO::FETCH_ASSOC)) {
 $dvno =  $result['dvno'];
 }

if($office=="ACCTG" && ($type=="DV" || $type=="OBR" || $type=="DWP" || $type == "PYL" || $type == "LR" || $type == "RIS" || $type == "PO") && ($user == "rodney") && $dv_no== ""  ){ //|| $user == "ian" || $user == "renbert"
$account = $_POST['account'];

$totaldv = $dvno + 1;
$formatdv = str_pad($totaldv, 5, '0', STR_PAD_LEFT);
$dv = $account.'-'.substr(date('Y'),-2).date('m').'-'.$formatdv;
//}
echo $dv;
 }else{
    echo $dv_no;
 }
die();

}


