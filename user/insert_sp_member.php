 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_spmember'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $empID= $_POST['idno'];
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $committee = $_POST['committee'];
  
   
    $insert_committee_sql = "INSERT INTO sp_members SET 
        objid               = :code,
        fullname            = :fullname,
        contactno           = :contactno,
        email               = :email,
        committee           = :committee";

    $committee_data = $con->prepare($insert_committee_sql);
    $committee_data->execute([
        ':code'             => $empID, 
        ':fullname'         => $fullName,
        ':contactno'        => $contact_number,
        ':email'            => $email,
        ':committee'        => $committee
        
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