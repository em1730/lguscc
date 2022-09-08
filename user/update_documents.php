 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_received'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
  
    
// if ($type!="DV"){
    $docno = $_POST['doc_no'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];
    $particulars = $_POST['particulars'];
    $origin = $_POST['origin'];
    $department = $_POST['department'];
   // $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
    $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $status = 'RECEIVED';
    $print = 0;

    $update_documents_sql = "UPDATE tbl_documents SET 
    status = :stat, 
    origin = :orig,
    destination = :dest,
    particulars = :part,
    remarks = :rem,
    print = :print
    where docno = :code";
            
    $update_documents_data = $con->prepare($update_documents_sql);
    $update_documents_data->execute([
        ':stat'             => $status,
        ':orig'             => $origin,
        ':dest'             => $department,
        ':part'             => $particulars,
        ':rem'              => $remarks,
        ':print'            => $print,
        ':code'             => $docno
       
        ]);
      
    
//     }elseif ($type=="DV"){
//     $docno = $_POST['doc_no'];
//     $date = date('Y-m-d', strtotime($_POST['date']));
//     $time =  date('H:i:s');
//     $type = $_POST['type'];
//     $obr_no = $_POST['obr_number'];
//     $account = $_POST['account'];
//     $dv_no = $_POST['dv_number'];
//     $cheque_no = $_POST['cheque_number'];
//     $acct_no = $_POST['acct_number'];
//     $amount =$_POST['amount'];
//     $payee= $_POST['payee'];
//     $particulars = $_POST['particulars'];
//     $origin = $_POST['origin'];
//     $department = $_POST['department'];
//    // $amount = $_POST['amount'];
//     $remarks = $_POST['remarks'];
//     $user_name = $_POST['username'];
//     $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
//     $status = 'RECEIVED';
//     $print = 0;
     
// $finalparticulars = 
// $obr_no.'
// '.$dv_no.'
// '.$acct_no.'
// '.$cheque_no.'
// '.$payee.'
// '.$particulars.'
// '.$amount;
       
       
//         $update_dv_sql = "UPDATE tbl_documents SET 
//         status = :stat, 
//         origin = :orig,
//         destination = :dest,
//         particulars = :part,
//         remarks = :rem,
//         print = :print
//         where docno = :code";
                
//         $update_dv_data = $con->prepare($update_dv_sql);
//         $update_dv_data->execute([
//             ':stat'             => $status,
//             ':orig'             => $origin,
//             ':dest'             => $department,
//             ':part'             => $finalparticulars,
//             ':rem'              => $remarks,
//             ':print'            => $print,
//             ':code'             => $docno
           
//             ]);

         
//     }





}

?>