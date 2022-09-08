 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_suppliers'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $code = $_POST['code'];
    $name_supplier = $_POST['name_supplier'];
    $owner = $_POST['owner'];
    $product_lines = $_POST['product_line'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $contact_person = $_POST['contact_person'];
    $telephone_no = $_POST['telephone_no'];
    $fax_no = $_POST['fax_no'];
    $others = $_POST['others'];
 

    
   
    $insert_suppliers_sql   = "INSERT INTO tbl_suppliers SET 
        code                = :code,
        name_supplier       = :name_supplier,
        owner               = :owner,
        product_lines       = :product_lines,
        tel_no              = :telephone,
        address             = :address,
        contact_no          = :contact_no,
        contact_person      = :contact_person,
        fax_no              = :fax_no,
        others              = :others";


        
    $suppliers_data = $con->prepare($insert_suppliers_sql);
    $suppliers_data->execute([
        ':code'             => $code, 
        ':name_supplier'    => $name_supplier,
        ':owner'            => $owner,
        ':product_lines'    => $product_lines,
        ':telephone'        => $telephone_no,
        ':address'          => $address,
        ':contact_no'       => $contact_no,
        ':contact_person'   => $contact_person,
        ':fax_no'           => $fax_no,
        ':others'           => $others
       
        
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