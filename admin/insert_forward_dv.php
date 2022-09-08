<?php

include ('../config/db_config.php');
//include('import_pdf.php');
date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_forward'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
$docno = $_POST['doc_no'];
$date = date('Y-m-d', strtotime($_POST['date']));
$time =  date('H:i:s');
$type = $_POST['type'];
$obr_no = $_POST['obr_number'];
$pr_no = $_POST['pr_number'];
$po_no = $_POST['po_number'];
$account = $_POST['account'];
$dv_no = $_POST['dv_number'];
$cheque_no = $_POST['cheque_number'];
$acct_no = $_POST['acct_number'];
$amount =$_POST['amount'];
$payee= $_POST['payee'];
$particulars = $_POST['particulars'];
//$origin = $_POST['origin'];
$department = $_POST['department'];
$destination = $_POST['receiver'];
// $amount = $_POST['amount'];
$status = 'FORWARDED';
$remarks = $_POST['remarks'];
$user_name = $_POST['username'];
//$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$finalparticulars = 
$obr_no.'
'.$pr_no.'
'.$po_no.'
'.$dv_no.'
'.$acct_no.'
'.$cheque_no.'
'.$payee." ". $etal.'
'.$particulars.'
'.$amount;

    
$update_dv1_sql = "UPDATE tbl_documents SET 
date = :date,
type = :type,
obrno           = :obrno,
prno            = :prno,
pono            = :pono,
acctype         = :acctype,
dvno            = :dvno,
acctno          = :acctno,
chequeno        = :chequeno,
payee           = :payee,
particulars     = :particulars,
amount          = :amount,
status          = :stat, 
origin          = :orig,
destination     = :dest,     
remarks         = :rem
where docno     = :code";
        
$update_dv1_data = $con->prepare($update_dv1_sql);
$update_dv1_data->execute([
    ':date'             =>$date,
    ':type'             =>$type,
    ':obrno'            =>$obr_no,
    ':prno'             =>$pr_no,
    ':pono'             =>$po_no,
    ':acctype'          =>$account,
    ':dvno'             =>$dv_no,
    ':acctno'           =>$acct_no,
    ':chequeno'         =>$cheque_no,
    ':payee'            =>$payee,
    ':particulars'      =>$particulars,
    ':amount'           =>str_replace(',','',$amount),
    ':stat'             =>$status,
    ':orig'             =>$department,
    ':dest'             =>$destination,
    ':rem'              =>$remarks,
    ':code'             =>$docno
 
   
    ]);

    $insert_ledger_sql = "INSERT INTO tbl_ledger SET 
        docno              = :code,
        txndate            = :datecreated,
        time                =:time,
        type               = :type,
        particulars        = :particular,
        origin             = :orig,
        destination        = :destination,
        -- amount             = :amount,
        status             = :stat,
        remarks            = :rem,
        receiver           = :username";
        //machineid          = :host";
    
    $ledger_data = $con->prepare($insert_ledger_sql);
    $ledger_data->execute([
        ':code'             => $docno, 
        ':datecreated'      => $date,
        ':time'             => $time,
        ':type'             => $type,
        ':particular'       => $finalparticulars,
        ':orig'             => $department,
        ':destination'       => $destination,
        // ':amount'           => $amount,
        ':stat'             => $status,
        ':rem'              => $remarks,
        ':username'         => $user_name
        

        ]);
        
        header('location: list_received.php');
    
   
    }


?>