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
    $docno = $_POST['doc_number'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];
    $particulars = $_POST['particulars'];
    $department = $_POST['department'];
    $destination = $_POST['receiver'];
    // $amount = $_POST['amount'];
    $status = 'FORWARDED';
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   
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
        receiver           = :username,
        machineid          = :host";
    
    $ledger_data = $con->prepare($insert_ledger_sql);
    $ledger_data->execute([
        ':code'             => $docno, 
        ':datecreated'      => $date,
        ':time'             => $time,
        ':type'             => $type,
        ':particular'       => $particulars,
        ':orig'             => $department,
        ':destination'       => $destination,
        // ':amount'           => $amount,
        ':stat'             => $status,
        ':rem'              => $remarks,
        ':username'         => $user_name,
        ':host'             => $host_name

        ]);
        
        header('location: list_received.php');
    
   
    }


?>