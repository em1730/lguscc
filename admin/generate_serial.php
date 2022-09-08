<?php

session_start();

include('../config/db_config.php');

if (isset($_POST['type'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";



function generate_serial(){
  global $docno;

$template = '9999999999';
$k = strlen($template);
$sernum ='';
for ($i=0; $i<$k; $i++)
  {
    switch($template[$i])
    {
      case 'X': $sernum .= chr(rand(65,90)); break;
      case '9': $sernum .= rand(0,9); break;
      case '-': $sernum .= '-'; break;
    }
  }
     $docno = $sernum;
     

     check_serial();

}

function check_serial(){
  global $con;
  global $docno;
 // echo $docno;

  $check_docno_sql = "SELECT docno FROM tbl_documents USE INDEX (index_docno) where docno = :docno";
      
  $check_docno_data = $con->prepare($check_docno_sql);
  $check_docno_data ->execute([
      ':docno' => $docno
]);
 $serial_count = $check_docno_data->rowCount();

  if ($serial_count == 0){
   // echo "serial count is";
   echo $docno;
 //
}else{
  generate_serial();
}
}

    generate_serial();
    die();

}


