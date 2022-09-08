<?php
    include('../config/db_config.php');


  $alert_msg = '';
  
    if (isset($_POST['update_jobOrder'])){
         //to check if data are passed
    $objid = $_POST['objid'];
    $control = $_POST['controlNumber'];
    $fname = $_POST['firstname'];
    $middle = $_POST['middlename'];
    $last = $_POST['lastname'];
    $rate = $_POST['rate'];
    $department = $_POST['department'];
    $status = $_POST['status'];
   // $account_type = $_POST['account_type'];

   
            //update tbl users do not include password
            $update_joborder_sql = "UPDATE tbl_joborder SET 
                controlno     = :controlNo,
                firstname     = :fname,
                middlename    = :mname,
                lastname      = :lname,
                rate          = :rate,
                department    = :department,
                status        = :status
            
                -- account_type   => :account_type 
                WHERE objid  = :id";
    
          $update_data = $con->prepare($update_joborder_sql);
          $update_data->execute([
                ':controlNo'      => $control,
                ':fname'          => $fname,
                ':mname'          => $middle,
                ':lname'          => $last,
                ':rate'           => $rate,
             
                ':department'     => $department,
                ':status'         => $status,
                // ': account_type'   => $account_type, 
                ':id'             => $objid
          ]);
     
     

    
            $alert_msg .= ' 
              <div class="new-alert new-alert-success alert-dismissible">
                  <i class="icon fa fa-success"></i>
                  Data Updated.
              </div>     
            ';


    }
?>