<?php
session_start();
/* Database connection start */
include('../config/db_config.php');

// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());


// $get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
// $get_user_data = $con->prepare($get_user_sql);
// $get_user_data->execute([':id'=>$user_id]);
// while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

// $user_name = $result['username'];
// $department = $result['department'];
// $db_first_name = $result['first_name'];
// $db_middle_name = $result['middle_name'];
// $db_last_name = $result['last_name'];
// $db_email_ad = $result['email'];
// $db_contact_number = $result['contact_no'];
// $db_user_name = $result['username'];
// }

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

0 => 'idno',
1 => 'controlno', 
2 => 'fullname',
3 => 'rate',
4 => 'office',

);


$getAllJobOrder = "SELECT * FROM tbl_joborder where status='Active' LIMIT " . $requestData['start'] . "," . $requestData['length'] . " ";
$getAllJobOrderData = $con->prepare($getAllJobOrder);
$getAllJobOrderData->execute();


$countNoFilter = "SELECT COUNT(idno) as id from tbl_joborder";
$getrecordstmt = $con->prepare($countNoFilter);
$getrecordstmt->execute() or die("track_joborder.php");
$getrecord = $getrecordstmt->fetch(PDO::FETCH_ASSOC);
$totalData = $getrecord['id'];

$totalFiltered = $totalData;

$getAllJobOrder = "SELECT * FROM tbl_joborder where ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$getAllJobOrder .=" (idno LIKE '%".$requestData['search']['value']."%' ";    
	$getAllJobOrder .=" OR objid LIKE '%".$requestData['search']['value']."%' ";
	$getAllJobOrder .=" OR controlno LIKE '%".$requestData['search']['value']."%' ";
	$getAllJobOrder .=" OR firstname LIKE '%".$requestData['search']['value']."%' ";
	$getAllJobOrder .=" OR middlename LIKE '%".$requestData['search']['value']."%' ";
	$getAllJobOrder .=" OR lastname LIKE '%".$requestData['search']['value']."%' ";
	$getAllJobOrder .=" OR rate LIKE '%".$requestData['search']['value']."%' ";
	$getAllJobOrder .=" OR department LIKE '%".$requestData['search']['value']."%' )";
	$getAllJobOrder .= " AND status ='Active' LIMIT " . $requestData['start'] . "," . $requestData['length'] . " ";
	$getAllJobOrderData = $con->prepare($getAllJobOrder);
	$getAllJobOrderData->execute();



	$countFilter = " SELECT COUNT(idno) as id from tbl_joborder where ";
	$countFilter .= " (idno LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR objid LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR controlno LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR firstname LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR middlename LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR lastname LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR rate LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR department LIKE '%" . $requestData['search']['value'] . "%' ) ";
	$countFilter .= " AND status ='Active' LIMIT " . $requestData['length'] . " ";



	$getrecordstmt = $con->prepare($countFilter);
	$getrecordstmt->execute() or die("track_joborder.php");
	$getrecord1 = $getrecordstmt->fetch(PDO::FETCH_ASSOC);
	$totalData = $getrecord['id'];
	$totalFiltered = $totalData;




	
}

$data = array();

while($row = $getAllJobOrderData->fetch(PDO::FETCH_ASSOC)) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["idno"];
	$nestedData[] = $row["controlno"];
	$nestedData[] = strtoupper($row["firstname"].' '.$row["middlename"].' '.$row["lastname"]);
	$nestedData[] = $row["rate"];
	$nestedData[] = $row["department"];

	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
