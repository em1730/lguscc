<?php
    include('../config/db_config.php');


  $alert_msg = '';
  
    if (isset($_POST['update_suppliers'])){
         //to check if data are passed
    $objid = $_POST['objid'];
    $code = $_POST['code'];
    $name_supplier = $_POST['name_supplier'];
    $owner = $_POST['owner'];
    $product_lines = $_POST['product_line'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_person'];
    $contact_person = $_POST['contact_no'];
    $telephone_no = $_POST['telephone_no'];
    $fax_no =  $_POST['fax_no'];
    $others =  $_POST['others'];
   // $account_type = $_POST['account_type'];

   
            //update tbl users do not include password
            $update_supplier_sql = "UPDATE tbl_suppliers SET 
                code              = :code,
                name_supplier     = :supplier,
                owner             = :owner,
                product_lines     = :product_lines,
                address           = :address,
                contact_no        = :contact_no,
                contact_person    = :contact_person,
                tel_no            = :tel_no,
                fax_no            = :fax_no,
                others            = :others
            
                -- account_type   => :account_type 
                WHERE objid  = :id";
    
          $update_data = $con->prepare($update_supplier_sql);
          $update_data->execute([
                ':code'           => $code,
                ':supplier'       => $name_supplier,
                ':owner'          => $owner,
                ':product_lines'  => $product_lines,
                ':address'        => $address,
                ':contact_no'     => $contact_no,
                ':contact_person' => $contact_person,
                ':tel_no'         => $telephone_no,
                ':fax_no'         => $fax_no,
                ':others'         => $others,
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