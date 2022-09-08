 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

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
    $obr_no = $_POST['obr_number'];
    $account = $_POST['account'];
    $dv_no = $_POST['dv_number'];
    $cheque_no = $_POST['cheque_number'];
    $acct_no = $_POST['acct_number'];
    $amount = doubleval($_POST['amount']);
    $payee= $_POST['payee'];
    $particulars = $_POST['particulars'];
    $origin = $_POST['origin'];
    $department = $_POST['department'];
   // $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $status = 'RECEIVED';
    $print = 0;
     
$finalparticulars = 
$obr_no.'
'.$dv_no.'
'.$acct_no.'
'.$cheque_no.'
'.$payee.'
'.$particulars.'
'.$amount;
       
       
        // $update_dv_sql = "UPDATE tbl_documents SET 
        // status = :stat, 
        // origin = :orig,
        // destination = :dest,
        // particulars = :part,
        // remarks = :rem,
        // print = :print
        // where docno = :code";
                
        // $update_dv_data = $con->prepare($update_dv_sql);
        // $update_dv_data->execute([
        //     ':stat'             => $status,
        //     ':orig'             => $origin,
        //     ':dest'             => $department,
        //     ':part'             => $finalparticulars,
        //     ':rem'              => $remarks,
        //     ':print'            => $print,
        //     ':code'             => $docno
           
        //     ]);

        $update_dv1_sql = "UPDATE tbl_documents SET 
        date = :date,
        type = :type,
        obrno           = :obrno,
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
            ':acctype'          =>$account,
            ':dvno'             =>$dv_no,
            ':acctno'           =>$acct_no,
            ':chequeno'         =>$cheque_no,
            ':payee'            =>$payee,
            ':particulars'      =>$particulars,
            ':amount'           =>$amount,
            ':stat'             =>$status,
            ':orig'             =>$origin,
            ':dest'             =>$department,
            ':rem'              =>$remarks,
            ':code'             =>$docno
         
           
            ]);
        
       
         
    





}

?>