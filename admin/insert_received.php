 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_received'])){

//         echo "<pre>";
//         print_r($_POST);
//     echo "</pre>";


// if ($type!="DV"){
    $docno = $_POST['doc_no'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];
    $particulars = $_POST['particulars'];
    $origin = $_POST['origin'];
    $department = $_POST['department'];
    // $amount = $_POST['amount'];
    $status = 'RECEIVED';
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    $host_name = "scc";
    //$end_time = $date .' ' . $time;

    $check_start_sql = "select end_time from tbl_ledger where docno = :docno and end_time < now() ORDER BY end_time DESC limit 1";
    $check_start_data = $con->prepare($check_start_sql);
    $check_start_data ->execute([
    ':docno' => $docno
    ]);
    while ($result = $check_start_data->fetch(PDO::FETCH_ASSOC)) {
        $start_time = $result['end_time'];
    }

    $check_now_sql =  "select now() as time";
    $check_now_data = $con->prepare($check_now_sql);
    $check_now_data ->execute([]);
    while ($result = $check_now_data->fetch(PDO::FETCH_ASSOC)) {
        $now_time = $result['time'];
    }

    $insert_ledger_sql = "INSERT INTO tbl_ledger SET 
        docno              = :code,
        txndate            = :txndate,
        time                =:time,
        type               = :type,
        particulars        = :particular,
        origin             = :orig,
        destination        = :destination,
        status             = :stat,
        remarks            = :rem,
        receiver           = :username,
        machineid          = :host,
        start_time         = :start_time,
        end_time           = :end_time";
    
    
    $insert_ledger_data = $con->prepare($insert_ledger_sql);
    $insert_ledger_data->execute([
        ':code'             => $docno, 
        'txndate'           => $date,
        ':time'             => $time,
        ':type'             => $type,
        ':particular'       => $particulars,
        ':orig'             => $origin,
        ':destination'      => $department,
        ':stat'             => $status,
        ':rem'              => $remarks,
        ':username'         => $user_name,
        ':host'             => $host_name,
        ':start_time'       => $start_time,
        ':end_time'         => $now_time
        ]);

//     }elseif ($type=="DV"){
//         $docno = $_POST['doc_no'];
//         $date = date('Y-m-d', strtotime($_POST['date']));
//         $time =  date('H:i:s');
//         $type = $_POST['type'];
//         $obr_no = $_POST['obr_number'];
//         $account = $_POST['account'];
//         $dv_no = $_POST['dv_number'];
//         $cheque_no = $_POST['cheque_number'];
//         $acct_no = $_POST['acct_number'];
//         $amount =$_POST['amount'];
//         $payee= $_POST['payee'];
//         $particulars = $_POST['particulars'];
//         $origin = $_POST['origin'];
//         $department = $_POST['department'];
//         // $amount = $_POST['amount'];
//         $status = 'RECEIVED';
//         $remarks = $_POST['remarks'];
//         $user_name = $_POST['username'];
//         $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
       
// $finalparticulars = 
// $obr_no.'
// '.$dv_no.'
// '.$acct_no.'
// '.$cheque_no.'
// '.$payee.'
// '.$particulars.'
// '.$amount;

//         $insert_ledgerdv_sql = "INSERT INTO tbl_ledger SET 
//             docno              = :code,
//             txndate            = :txndate,
//             time                =:time,
//             type               = :type,
//             particulars        = :particular,
//             origin             = :orig,
//             destination        = :destination,
//             status             = :stat,
//             remarks            = :rem,
//             receiver           = :username,
//             machineid          = :host";
            
    
    
        
//         $insert_ledgerdv_data = $con->prepare($insert_ledgerdv_sql);
//         $insert_ledgerdv_data->execute([
//             ':code'             => $docno, 
//             'txndate'           => $date,
//             ':time'             => $time,
//             ':type'             => $type,
//             ':particular'       => $finalparticulars,
//             ':orig'             => $origin,
//             ':destination'      => $department,
//             ':stat'             => $status,
//             ':rem'              => $remarks,
//             ':username'         => $user_name,
//             ':host'             => $host_name
//             ]);


//         }

    $alert_msg .= ' 
          <div class="new-alert new-alert-success alert-dismissible">
              <i class="icon fa fa-success"></i>
              Document Received!
          </div>     
      ';
    
    $btnStatus = 'disabled';
    $btnNew = 'enabled';
    $btnPrint = 'enabled';

    header('location: list_incoming.php');


}
?>