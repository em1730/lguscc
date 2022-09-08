<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['docno'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$docno = $_POST['docno'];



//select * documents
$get_all_incoming_sql = "SELECT * FROM tbl_dv where docno = :doc";// and destination = '$department'";
$get_all_incoming_data = $con->prepare($get_all_incoming_sql);
$get_all_incoming_data->execute([':doc' => $docno]);  
while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
  $docno = $result['docno'];
  $date = $result['date'];
  $type = $result['type']; 
  $obr_no = $result['obrno'];
  $account = $result['acctype'];
  $dv_no = $result['dvno'];
  $account_no = $result['acctno'];
  $cheque_no = $result['chequeno'];
  $payee = $result['payee'];
  $particulars = $result['particulars']; 
  $origin= $result['origin']; 
  $amount= $result['amount'];
  $status = $result['status'];
  $remarks = $result['remarks'];

}



// $response = array(
//  'docno' => $docno,
//  'particulars' => $particulars

// );
$data = array(
    'date'        => $date,
    'type'        => $type,
    'obr_no'      => $obr_no,
    'account'     => $account,
    'dv_no'       => $dv_no,
    'account_no'  => $account_no,
    'cheque_no'   => $cheque_no,
    'payee'       => $payee,
    'particulars' => $particulars,
    'amount'      => $amount,
    'origin'      => $origin,
    'remarks'     => $remarks,

);
echo json_encode($data);
//echo $date, $particulars;
die();

}
?>