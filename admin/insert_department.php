 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_department'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $objid = $_POST['code'];
    $department = $_POST['department'];
    $status = $_POST['status'];
   
    $insert_doctype_sql = "INSERT INTO tbl_department SET 
        objid               = :code,
        department          = :dept,
        status              = :status";
        
    $doctype_data = $con->prepare($insert_doctype_sql);
    $doctype_data->execute([
        ':code'             => $objid, 
        ':dept'             => $department,
        ':status'           => $status
        
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