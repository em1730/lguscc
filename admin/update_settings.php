<?php

// session_start();

include('../config/db_config.php');

if (isset($_POST['insert_received'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$department = $_POST['department'];
$docno = $_POST['doc_no'];
$users = $_POST['username'];
$type = $_POST['type'];




// //count no. of incoming
// $get_count_sql = "SELECT COUNT(docno) as totalcount from tbl_ledger where docno = :docno and destination = :destination and status = 'RECEIVED'";
// $get_count_data = $con->prepare($get_count_sql);
// $get_count_data->execute([':docno'=> $docno, ':destination' => $department]);  
// while ($result = $get_count_data->fetch(PDO::FETCH_ASSOC)) {
//  $count =  $result['totalcount'];
//  }


 if(empty($_POST['prev_year'])){
    if($department=="CBO" && ($type=="DV" || $type=="OBR" || $type=="DWP" || $type == "PYL" || $type == "LR" || $type == "RIS" || $type == "PO") && ($users == "jen")){
        //select obr settings
        $get_obrno_sql = "SELECT `obrno` FROM `tbl_settings`";
        $get_obrno_data = $con->prepare($get_obrno_sql);
        $get_obrno_data->execute();  
         while ($result = $get_obrno_data->fetch(PDO::FETCH_ASSOC)) {
         $obrno =  $result['obrno'];
         }
        
        $totalobr = $obrno + 1;
        
        //update settings
        $update_obr_sql = "UPDATE tbl_settings set obrno = :obr";
                  
        $update_data = $con->prepare($update_obr_sql);
        $update_data->execute([
            ':obr'            => $totalobr
           
        ]);
        }
        
        if($department=="ACCTG" && ($type=="DV" || $type=="OBR" || $type=="DWP" || $type == "PYL" || $type == "LR" || $type == "RIS" || $type == "PO") && ($users == "rodney")){
            //select obr settings
            $get_dvno_sql = "SELECT `dvno` FROM `tbl_settings`";
            $get_dvno_data = $con->prepare($get_dvno_sql);
            $get_dvno_data->execute();  
             while ($result = $get_dvno_data->fetch(PDO::FETCH_ASSOC)) {
             $dvno =  $result['dvno'];
             }
            
            $totaldv = $dvno + 1;
            
            //update settings
            $update_dvno_sql = "UPDATE tbl_settings set dvno = :dv";
                      
            $update_data = $con->prepare($update_dvno_sql);
            $update_data->execute([
                ':dv'            => $totaldv
               
            ]);
            } 
    }else{            
        if($department=="CBO" && ($type=="DV" || $type=="OBR" || $type=="DWP" || $type == "PYL" || $type == "LR" || $type == "RIS" || $type == "PO") && ($users == "jen")){
            //select obr settings
            $get_obrno_sql = "SELECT `prevobrno` FROM `tbl_settings`";
            $get_obrno_data = $con->prepare($get_obrno_sql);
            $get_obrno_data->execute();  
             while ($result = $get_obrno_data->fetch(PDO::FETCH_ASSOC)) {
             $obrno =  $result['prevobrno'];
             }
            
            $totalobr = $obrno + 1;
            
            //update settings
            $update_obr_sql = "UPDATE tbl_settings set prevobrno = :obr";
                      
            $update_data = $con->prepare($update_obr_sql);
            $update_data->execute([
                ':obr'            => $totalobr
               
            ]);
            }
            
            if($department=="ACCTG" && ($type=="DV" || $type=="OBR" || $type=="DWP" || $type == "PYL" || $type == "LR" || $type == "RIS" || $type == "PO") && ($users == "rodney")){
                //select obr settings
                $get_dvno_sql = "SELECT `prevdvno` FROM `tbl_settings`";
                $get_dvno_data = $con->prepare($get_dvno_sql);
                $get_dvno_data->execute();  
                 while ($result = $get_dvno_data->fetch(PDO::FETCH_ASSOC)) {
                 $dvno =  $result['prevdvno'];
                 }
                
                $totaldv = $dvno + 1;
                
                //update settings
                $update_dvno_sql = "UPDATE tbl_settings set prevdvno = :dv";
                          
                $update_data = $con->prepare($update_dvno_sql);
                $update_data->execute([
                    ':dv'            => $totaldv
                   
                ]);
                }
            
            
            }
    };




?>