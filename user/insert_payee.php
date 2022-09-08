 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_position'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $address = $_POST['address'];
    $payee= $_POST['payee'];
    $code = $_POST['code'];
    $status = $_POST['status'];

   
    $insert_payee_sql = "INSERT INTO tbl_payee SET 
        address               = :address,
        objid                 = :code,
        payee                 = :payee,
        status                = :stat";

        
    $payee_data = $con->prepare($insert_payee_sql);
    $payee_data->execute([
        ':address'   => $address,
        ':code'      => $code,
        ':payee'     => $payee,
        ':stat'      => $status
        
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