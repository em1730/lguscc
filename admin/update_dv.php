<?php

// session_start();

include('../config/db_config.php');

if (isset($_POST['dv'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$dv = $_POST['dv'];




// //count no. of incoming
// $get_count_sql = "SELECT COUNT(docno) as totalcount from tbl_ledger where docno = :docno and destination = :destination and status = 'RECEIVED'";
// $get_count_data = $con->prepare($get_count_sql);
// $get_count_data->execute([':docno'=> $docno, ':destination' => $department]);  
// while ($result = $get_count_data->fetch(PDO::FETCH_ASSOC)) {
//  $count =  $result['totalcount'];
//  }


       //update settings
        $update_dv_sql = "UPDATE tbl_settings set dvno = :dv";
                  
        $update_data = $con->prepare($update_dv_sql);
        $update_data->execute([
            ':dv'            => $dv
           
        ]);
  
echo "Updated";
        }




?>