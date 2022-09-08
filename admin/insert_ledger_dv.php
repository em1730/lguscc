 <?php

include ('../config/db_config.php');
//include('import_pdf.php');
date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_outgoing'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
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
        // $origin = $_POST['origin'];
        $department = $_POST['department'];
        $destination = $_POST['receiver'];
        $status = 'CREATED';
        $remarks = $_POST['remarks'];
        $user_name = $_POST['username'];
        $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
       
$finalparticulars = 
$obr_no.'
'.$dv_no.'
'.$acct_no.'
'.$cheque_no.'
'.$payee.'
'.$particulars.'
'.$amount;

        $insert_ledgerdv_sql = "INSERT INTO tbl_ledger SET 
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
            machineid          = :host";
            
    
    
        
        $insert_ledgerdv_data = $con->prepare($insert_ledgerdv_sql);
        $insert_ledgerdv_data->execute([
            ':code'             => $docno, 
            'txndate'           => $date,
            ':time'             => $time,
            ':type'             => $type,
            ':particular'       => $finalparticulars,
            ':orig'             => $department,
            ':destination'      => $destination,
            ':stat'             => $status,
            ':rem'              => $remarks,
            ':username'         => $user_name,
            ':host'             => $host_name
            ]);

   
    }


?>