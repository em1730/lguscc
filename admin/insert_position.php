 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_position'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $department = $_POST['department'];
    $newposition = $_POST['position'];
    $code = $_POST['code'];
    $status = $_POST['status'];

   
    $insert_doctype_sql = "INSERT INTO tbl_position SET 
        department            = :dept,
        objid                  = :code,
        position              = :position,
        status                = :stat";

        
    $doctype_data = $con->prepare($insert_doctype_sql);
    $doctype_data->execute([
        ':dept'       => $department,
        ':code'       => $code,
        ':position'   => $newposition,
        ':stat'       => $status
        
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