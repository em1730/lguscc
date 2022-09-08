<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['office'])) {

 $office = $_POST['office'];
 $type = $_POST['type'];
 $obr = $_POST['obr'];

 //select all data type
$get_all_type_sql = "SELECT `objid` FROM `document_type` WHERE objid = :type";
$get_all_type_data = $con->prepare($get_all_type_sql);
$get_all_type_data->execute([':type'=> $type]);  
 while ($result = $get_all_type_data->fetch(PDO::FETCH_ASSOC)) {
 $finaltype =  $result['objid'];
 }


//select dv settings
$get_dvno_sql = "SELECT `obrno` FROM `tbl_settings`";
$get_dvno_data = $con->prepare($get_dvno_sql);
$get_dvno_data->execute();  
 while ($result = $get_dvno_data->fetch(PDO::FETCH_ASSOC)) {
 $obrno =  $result['obrno'];
 }

//generate obr no
if($office=="CBO" && ($type=="DV" || $type=="DWP") && $obr==""  ){
  $totalobr = $obrno + 1;
  $finalobr = date('Y').'-'.date('m').'-'.$totalobr;
  echo $finalobr;
}else{
  echo $obr;
}


die();

}


