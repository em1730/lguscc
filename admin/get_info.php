<?php


session_start();

include('../config/db_config.php');

if (isset($_POST['docno'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$docno = $_POST['docno'];



//select * documents
$get_noofdocs_sql= "SELECT * FROM `tbl_documents` where docno = :docno";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute(['docno'=>$docno]);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
 $date =  $result1['date'];
 $type = $result1['type'];
 $particulars = $result1['particulars'];
 $origin = $result1['origin'];
 $remarks = $result1['remarks'];
}



// $response = array(
//  'docno' => $docno,
//  'particulars' => $particulars

// );
$data = array(
    'date'        => $date,
    'type'        => $type,
    'particulars' => $particulars,
    'origin'      => $origin,
    'remarks'     => $remarks,

);
echo json_encode($data);
//echo $date, $particulars;
die();

}
?>