<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['type'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$finalcount = null;
$finalcount1 = null;
$finaltype = null;
$type = $_POST['type'];
$office = $_POST['office'];
$user_id = $_SESSION['id'];


//select all data type
$get_all_type_sql = "SELECT `objid` FROM `document_type` WHERE objid = :type";
$get_all_type_data = $con->prepare($get_all_type_sql);
$get_all_type_data->execute([':type'=> $type]);  
 while ($result = $get_all_type_data->fetch(PDO::FETCH_ASSOC)) {
 $finaltype =  $result['objid'];
 }

//select office
$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$get_user_data = $con->prepare($get_user_sql);
$get_user_data->execute([':id'=>$user_id]);
while ($result2 = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

  $user_name = $result2['username'];
  $department = $result2['department'];
}

//count no. of documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE docno LIKE '".$type."%' and YEAR(date) = YEAR(CURDATE())";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $finalcount =  $result1['total'];
}


  $finalcount1 = $finalcount + 1;


if ($office){
  //$docno = date('Y').'-'.$finalcount1.'-'.$office.'-'.$finaltype;
  $docno =$finaltype.'-'.$office.'-'.date('Y').'-'.$finalcount1;
  
}else{
 // $docno = date('Y').'-'.$finalcount1.'-'.$department.'-'.$finaltype;
$docno =$finaltype.'-'.$department.'-'.date('Y').'-'.$finalcount1;
}
echo $docno;
die();

}
?>