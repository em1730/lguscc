<?php

include('../config/db_config.php');
//include('import_pdf.php');
date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
session_start();


if (isset($_POST['update_revertdocu_dv'])) {

    //        echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $docno = $_POST['doc_no'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];

    if (empty($_POST['obr_number'])) {
        $obr_no = '';
    } else {
        $obr_no = $_POST['obr_number'];
    }

    if (empty($_POST['pr_number'])) {
        $pr_no = '';
    } else {
        $pr_no = $_POST['pr_number'];
    }

    if (empty($_POST['po_number'])) {
        $po_no = '';
    } else {
        $po_no = $_POST['po_number'];
    }

    if (empty($_POST['account'])) {
        $account = '';
    } else {
        $account = $_POST['account'];
    }

    if (empty($_POST['dv_number'])) {
        $dv_no = '';
    } else {
        $dv_no = $_POST['dv_number'];
    }

    if (empty($_POST['cheque_number'])) {
        $cheque_no = '';
    } else {
        $cheque_no = $_POST['cheque_number'];
    }

    if (empty($_POST['acct_number'])) {
        $acct_no = '';
    } else {
        $acct_no = $_POST['acct_number'];
    }


    $amount = doubleval($_POST['amount']);
    $payee = $_POST['payee'];
    $particulars = $_POST['particulars'];
    // $origin = $_POST['origin'];
    $creator = $_POST['department'];
    $department = $_POST['department'];
    $amount = $_POST['amount'];
    $destination = $_POST['receiver'];
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    //$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $status = 'CREATED';
    $host_name = "";
    $print = 0;

    if (empty($_POST['etc'])) {
        $etal = 0;
    } else {
        $etal = 1;
    };

    if (empty($_POST['prev_year'])) {
        $prevyear = 0;
    } else {
        $prevyear = 1;
    };




    $finalparticulars =
        $obr_no . '
    ' . $pr_no . '
    ' . $po_no . '
    ' . $dv_no . '
    ' . $acct_no . '
    ' . $cheque_no . '
    ' . $payee . " " . $etal . '
    ' . $particulars . '
    ' . $amount;

    $check_start_sql = "select end_time from tbl_ledger where docno = :docno and end_time < now() ORDER BY end_time DESC limit 1";
    $check_start_data = $con->prepare($check_start_sql);
    $check_start_data->execute([
        ':docno' => $docno
    ]);
    while ($result = $check_start_data->fetch(PDO::FETCH_ASSOC)) {
        $start_time = $result['end_time'];
    }

    $check_now_sql =  "select now() as time";
    $check_now_data = $con->prepare($check_now_sql);
    $check_now_data->execute([]);
    while ($result = $check_now_data->fetch(PDO::FETCH_ASSOC)) {
        $now_time = $result['time'];
    }




    $insert_dv_sql = "UPDATE tbl_documents SET 

    date               = :date,
    type               = :type,
    date_time          = :timeey,
    prevyear           = :prevyear,
    obrno              = :obrno,
    prno               = :prno,
    pono               = :pono,
    acctype            = :acctype,
    dvno               = :dvno,
    acctno             = :acctno,
    chequeno           = :chequeno,
    payee              = :payee,
    etal               = :etal,
    particulars        = :particulars,
    amount             = :amount,
    status             = :stat, 
    creator            = :creator,
    origin             = :orig,
    destination        = :dest,     
    remarks            = :rem
    WHEre docno             = :code";

    $insert_dv_data = $con->prepare($insert_dv_sql);
    $insert_dv_data->execute([
        ':code'             => $docno,
        ':date'             => $date,
        ':timeey'           => $date . ' ' . $time,
        ':type'             => $type,
        ':prevyear'         => $prevyear,
        ':obrno'            => $obr_no,
        ':prno'             => $pr_no,
        ':pono'             => $po_no,
        ':acctype'          => $account,
        ':dvno'             => $dv_no,
        ':acctno'           => $acct_no,
        ':chequeno'         => $cheque_no,
        ':payee'            => $payee,
        ':etal'             => $etal,
        ':particulars'      => $particulars,
        ':amount'           => $amount,
        ':stat'             => $status,
        ':creator'          => $creator,
        ':orig'             => $department,
        ':dest'             => $destination,
        ':rem'              => $remarks

    ]);

    $insert_ledgerdv_sql = "UPDATE tbl_ledger SET 
     
        -- txndate            = :txndate,
        -- time                =:time,
        type               = :type,
        particulars        = :particular,
        origin             = :orig,
        destination        = :destination,
        status             = :stat,
        remarks            = :rem,
        receiver           = :username,
        machineid          = :host
        -- start_time         = :start_time,
        -- end_time           = :end_time
        WHERE    docno     = :code";





    $insert_ledgerdv_data = $con->prepare($insert_ledgerdv_sql);
    $insert_ledgerdv_data->execute([
        ':code'             => $docno,
        // 'txndate'           => $date,
        // ':time'             => $time,
        ':type'             => $type,
        ':particular'       => $particulars,
        ':orig'             => $department,
        ':destination'      => $destination,
        ':stat'             => $status,
        ':rem'              => $remarks,
        ':username'         => $user_name,
        ':host'             => $host_name
        // ':start_time'       => $now_time,
        // ':end_time'         => $now_time
    ]);







    $tnxhistory_sql = "INSERT INTO tbl_tnxhistory SET 
            ref        = :ref ,
            date        = :date ,
            docno        = :docno ,
        
            username     = :username,
            activity     = :activity


    ";


    $tnxhistory_data = $con->prepare($tnxhistory_sql);
    $tnxhistory_data->execute([

        ':ref'                    => "ref:" . $docno,
        ':date'                   => $date . ' - ' . $time,
        ':docno'              => $docno,

        ':username'               => $user_name,
        ':activity'               => "UPDATE THE DOCUMENT" 



    ]);






    if ($insert_ledgerdv_data && $insert_dv_data && $tnxhistory_data ) {

        $_SESSION['status'] = "Update Document Succesfully!";
        $_SESSION['status_code'] = "success";

        header('location: list_outgoing.php');
    } else {
        $_SESSION['status'] = "Update Document Unsuccessful!!";
        $_SESSION['status_code'] = "error";

        header('location: list_outgoing.php');
    }
}
