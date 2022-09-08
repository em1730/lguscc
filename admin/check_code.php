<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['doc_code'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";


$doc_code = $_POST['doc_code'];

$check_doc_code_sql = "SELECT * FROM document_type where objid = :doc_code";
        
$check_doc_code_data = $con->prepare($check_doc_code_sql);
$check_doc_code_data ->execute([
  ':doc_code' => $doc_code
]);

if ($check_doc_code_data->rowCount() > 0){

  echo '<div style="color: red;"> <b>'.$doc_code.'</b> is already in use! </div>';
  }else{
  echo '<div style="color: green;"> <b>'.$doc_code.'</b> is avaialable! </div>';
  }

die();

}


