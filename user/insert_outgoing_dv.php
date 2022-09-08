 <?php

include ('../config/db_config.php');
//include('import_pdf.php');
date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_outgoing'])) {

    //        echo "<pre>";
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
    $amount = doubleval($_POST['amount']);
    $payee= $_POST['payee'];
    $particulars = $_POST['particulars'];
   // $origin = $_POST['origin'];
    $creator = $_POST['department'];
    $department = $_POST['department'];
    $amount = $_POST['amount'];
    $destination = $_POST['receiver'];
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $status = 'CREATED';
    $print = 0;
     
$finalparticulars = 
$obr_no.'
'.$dv_no.'
'.$acct_no.'
'.$cheque_no.'
'.$payee.'
'.$particulars.'
'.$amount;
       
       
       
       

        $insert_dv_sql = "INSERT INTO tbl_documents SET 
        docno             = :code,
        date               = :date,
        type               = :type,
        obrno              = :obrno,
        acctype            = :acctype,
        dvno               = :dvno,
        acctno             = :acctno,
        chequeno           = :chequeno,
        payee              = :payee,
        particulars        = :particulars,
        amount             = :amount,
        status             = :stat, 
        creator            = :creator,
        origin             = :orig,
        destination        = :dest,     
        remarks            = :rem";       
                
        $insert_dv_data = $con->prepare($insert_dv_sql);
        $insert_dv_data->execute([
            ':code'             =>$docno,
            ':date'             =>$date,
            ':type'             =>$type,
            ':obrno'            =>$obr_no,
            ':acctype'          =>$account,
            ':dvno'             =>$dv_no,
            ':acctno'           =>$acct_no,
            ':chequeno'         =>$cheque_no,
            ':payee'            =>$payee,
            ':particulars'      =>$particulars,
            ':amount'           =>$amount,
            ':stat'             =>$status,
            ':creator'          =>$creator,
            ':orig'             =>$department,
            ':dest'             =>$destination,
            ':rem'              =>$remarks
         
            ]);

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
           
           
        $alert_msg .= ' 
        <div class="new-alert new-alert-success alert-dismissible">
            <i class="icon fa fa-success"></i>
            Data Inserted
        </div>     
    ';
    


    $btnStatus = 'disabled';
    $btnNew = 'enabled';
    $btnPrint = 'enabled';
    
        }


?>