<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['office'])) {
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

 $office = $_POST['office'];
 $type = $_POST['type'];
 $obr = $_POST['obr'];
//  $docno = $_POST['docno'];
 


 //select all data type
$get_all_type_sql = "SELECT `objid` FROM `document_type` WHERE objid = :type";
$get_all_type_data = $con->prepare($get_all_type_sql);
$get_all_type_data->execute([':type'=> $type]);  
 while ($result = $get_all_type_data->fetch(PDO::FETCH_ASSOC)) {
 $finaltype =  $result['objid'];
 }


//select dv settings
$get_dvno_sql = "SELECT * FROM `tbl_settings`";
$get_dvno_data = $con->prepare($get_dvno_sql);
$get_dvno_data->execute();  
 while ($result = $get_dvno_data->fetch(PDO::FETCH_ASSOC)) {
 $prevobrno = $result['prevobrno'];
 $obrno =  $result['obrno'];
 }

//  //select prevyear

//  //select all incoming documents
//  $get_all_incoming_sql = "SELECT * FROM tbl_documents where docno = :doc";// and destination = '$department'";
//  $get_all_incoming_data = $con->prepare($get_all_incoming_sql);
//  $get_all_incoming_data->execute([':doc' => $docno]);  
//  while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
//    $prevyear = $result['prevyear'];
  
//  }

//generate obr no
if($office=="CBO" && ($type=="DV" || $type=="OBR" || $type=="DWP" || $type == "PYL" || $type == "LR" || $type == "RIS" || $type == "PO")){
  
  $totalobr = $obrno + 1;
  $formatobr = str_pad($totalobr, 5, '0', STR_PAD_LEFT);
  $finalobr = date('Y').'-'.date('m').'-'.$formatobr;
  

  // $formatobr = str_pad($totalobr, 5, '0', STR_PAD_LEFT);
  // $finalobr = date('Y').'-'.date('m').'-'.$formatobr;
  echo $finalobr;
}else{
  echo $obr;
}


die();

}


