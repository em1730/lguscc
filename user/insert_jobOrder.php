 <?php

include ('../config/db_config.php');
//include('import_pdf.php');


$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_jobOrder'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    // $idnumber = $_POST['idnumber'];
    $control = $_POST['controlNumber'];
    $fname = $_POST['firstname'];
    $middle = $_POST['middlename'];
    $last = $_POST['lastname'];
    $department = $_POST['department'];
    $status = $_POST['status'];
    $rate = $_POST['rate'];
    $myID = uniqid('jo',true);
   
    $insert_doctype_sql = "INSERT INTO tbl_joborder SET 
        objid               = :id,
        -- joId             = :joid,
        firstname           = :fname,
        middlename          = :mname,
        lastname            = :lname,
        controlNo           = :controlno,
        rate                = :rate,
        department          = :dept,
        status              = :status";
        
    $doctype_data = $con->prepare($insert_doctype_sql);
    $doctype_data->execute([
         ':id'             => $myID,
        // ':joid'           => $idnumber,
        ':fname'          => $fname,
        ':mname'          => $middle, 
        ':lname'          => $last,
        ':controlno'      => $control,
        ':rate'           => $rate,
        ':dept'           => $department,
        ':status'         => $status


        
        ]);

    $alert_msg .= ' 
          <div class="new-alert new-alert-success alert-dismissible">
              <i class="icon fa fa-success"></i>
              Data Inserted
          </div>     
      ';
    
    $btnStatus = 'disabled';
    $btnNew = 'enabled';
    }


?>