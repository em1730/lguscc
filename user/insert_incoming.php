 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_received'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $docno = $_POST['doc_no'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];
    $particulars = $_POST['particulars'];
    $department = $_POST['origin'];
    $creator = $_POST['origin'];
    $destination = $_POST['department'];
    // $amount = $_POST['amount'];
    $status = 'RECEIVED';
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   

    $check_docno_sql = "SELECT * FROM tbl_documents where docno = :docno";
        
    $check_docno_data = $con->prepare($check_docno_sql);
    $check_docno_data ->execute([
    ':docno' => $docno
    ]);

    if ($check_docno_data->rowCount() > 0){
     
            $alert_msg2 = ' 
            <div class="alert alert-danger alert-dismissible">
                <i class="icon fa fa-warning"></i>
                Ordinance Number already exist!
            </div>     
        ';
    
        }else{


    $insert_outgoing_sql = "INSERT INTO tbl_documents SET 
        docno              = :code,
        date               = :datecreated,
        type               = :type,
        particulars        = :particular,
        creator            = :creator,
        origin             = :orig,
        destination        = :destination,
        status             = :stat,
        remarks            = :rem";
            
    $outgoing_data = $con->prepare($insert_outgoing_sql);
    $outgoing_data->execute([
        ':code'             => $docno, 
        ':datecreated'      => $date,
        ':type'             => $type,
        ':particular'       => $particulars,
        ':creator'          => $creator,
        ':orig'             => $department,
        ':destination'       => $destination,
        ':stat'             => $status,
        ':rem'              => $remarks
        ]);



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
        machineid          = :host";
    
    
    $insert_ledger_data = $con->prepare($insert_ledger_sql);
    $insert_ledger_data->execute([
        ':code'             => $docno, 
        'txndate'           => $date,
        ':time'             => $time,
        ':type'             => $type,
        ':particular'       => $particulars,
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
}
?>