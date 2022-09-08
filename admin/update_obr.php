<?php

// session_start();

include('../config/db_config.php');

if (isset($_POST['obr'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$obr = $_POST['obr'];




// //count no. of incoming
// $get_count_sql = "SELECT COUNT(docno) as totalcount from tbl_ledger where docno = :docno and destination = :destination and status = 'RECEIVED'";
// $get_count_data = $con->prepare($get_count_sql);
// $get_count_data->execute([':docno'=> $docno, ':destination' => $department]);  
// while ($result = $get_count_data->fetch(PDO::FETCH_ASSOC)) {
//  $count =  $result['totalcount'];
//  }


       //update settings
        $update_obr_sql = "UPDATE tbl_settings set obrno = :obr";
                  
        $update_data = $con->prepare($update_obr_sql);
        $update_data->execute([
            ':obr'            => $obr
           
        ]);
  
echo "Updated";
        }




?>