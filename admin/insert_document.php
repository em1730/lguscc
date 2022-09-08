 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_document'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $objid = $_POST['doc_code'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $status = $_POST['status'];
   
    $insert_doctype_sql = "INSERT INTO document_type SET 
        objid               = :code,
        type                = :type,
        description         = :desc,
        status              = :status";
        
    $doctype_data = $con->prepare($insert_doctype_sql);
    $doctype_data->execute([
        ':code'             => $objid, 
        ':type'             => $type,
        ':desc'             => $description,
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