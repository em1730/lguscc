 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_document'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    $docno = $_POST['doc_no'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];
    $obr_no = $_POST['obr_number'];
    $account = $_POST['account'];
    $dv_no = $_POST['dv_number'];
    $cheque_no = $_POST['cheque_number'];
    $acct_no = $_POST['acct_number'];
    $amount =$_POST['amount'];
    $payee= $_POST['payee'];
    $particulars = $_POST['particulars'];
    $origin = $_POST['origin'];
    $department = $_POST['department'];
    // $amount = $_POST['amount'];
    $status = 'RECEIVED';
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
  
   
    $insert_doctype_sql = "INSERT INTO tbl_dv SET 
            docno              = :code,
            txndate            = :txndate,
            type               = :type,
            obrno              = :obrno,
            acctype            = :acctype,
            dvno               = :dvno,
            acctno             = :acctno,
            chequeno           = :chequeno,
            payee              = :payee,
            particulars        = :particular,
            amount             = :amount,
            origin             = :orig,
            destination        = :destination,
            status             = :stat,
            remarks            = :rem,
            receiver           = :username,
            machineid          = :host";
    $doctype_data = $con->prepare($insert_doctype_sql);
    $doctype_data->execute([
        ':code'             => $objid, 
        ':type'             => $type,
        ':desc'             => $obr_no.' '.$dv_no.' '.$cheque_no.' '.$description.' '.$amount,
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