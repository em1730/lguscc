<?php

// session_start();

include('../config/db_config.php');

if (isset($_POST['docno'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$docno = $_POST['docno'];
$type =  $_POST['type'];


// //count no. of incoming
// $get_count_sql = "SELECT COUNT(docno) as totalcount from tbl_ledger where docno = :docno and destination = :destination and status = 'RECEIVED'";
// $get_count_data = $con->prepare($get_count_sql);
// $get_count_data->execute([':docno'=> $docno, ':destination' => $department]);  
// while ($result = $get_count_data->fetch(PDO::FETCH_ASSOC)) {
//  $count =  $result['totalcount'];
//  }


       //update settings
        $update_obr_sql = "UPDATE tbl_documents set type = :type where docno = :docno";
                  
        $update_data = $con->prepare($update_obr_sql);
        $update_data->execute([
            ':type'            => $type,
            ':docno'           => $docno
           
        ]);
  
echo "Updated";
        }




?>