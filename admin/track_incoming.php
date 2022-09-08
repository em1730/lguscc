<?php
session_start();
/* Database connection start */
// $servername = "localhost";
// $username = "root";
// $password = "1234";
// $dbname = "scc_doctrack";
// $office = $_POST['office'];

// $servername = "192.168.0.5";
// $username = "root";
// $password = "1234";
// $dbname = "scc_doctrack";
// $office = $_POST['office'];


include('../config/credentials.php');
// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

$office = $_POST['office'];
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
$requestData = $_REQUEST;


$columns = array(
	// datatable column index  => database column name
	0 => 'docno',
	1 => 'date',
	2 => 'type',
	3 => 'obrno',
	4 => 'dvno',
	5 => 'payee',
	6 => 'particulars',
	7 => 'amount',
	8 => 'origin',
);

// getting total number records without any search
$getAllIncomingDocuments = "SELECT docno, date, obrno, dvno, type, payee, particulars, amount, origin 
		FROM tbl_documents where status in ('CREATED', 'FORWARDED') and destination = 
		:office  ";

$getAllIncomingDocumentsData = $db_dts->prepare($getAllIncomingDocuments);
$getAllIncomingDocumentsData->execute([':office' =>$office]);


$countNoFilter = "SELECT COUNT(docno) as id from tbl_documents";
$getrecordstmt = $db_dts->prepare($countNoFilter);
$getrecordstmt->execute() or die("track_incoming.php");
$getrecord = $getrecordstmt->fetch(PDO::FETCH_ASSOC);
$totalData = $getrecord['id'];

$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.




$getAllIncomingDocuments = "SELECT docno, date, type, obrno, dvno, payee, particulars, amount, origin from tbl_documents
		where status in ('CREATED', 'FORWARDED') and destination = '$office'  ";

if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$getAllIncomingDocuments .= " AND ( docno LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR date LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR type LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR obrno LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR dvno LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR payee LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR particulars LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR amount LIKE '%" . $requestData['search']['value'] . "%' ";
	$getAllIncomingDocuments .= " OR origin LIKE '%" . $requestData['search']['value'] . "%'  ";
	$getAllIncomingDocuments .= " ORDER BY date DESC LIMIT 50 )";
	$getAllIncomingDocumentsData = $db_dts->prepare($getAllIncomingDocuments);
	$getAllIncomingDocumentsData->execute();

	$countFilter = " SELECT COUNT(docno) as id from tbl_documents  where ";
	$countFilter .= " (docno LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR date LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR type LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR obrno LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR dvno LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR payee LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR particulars LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR amount LIKE '%" . $requestData['search']['value'] . "%' ";
	$countFilter .= " OR origin LIKE '%" . $requestData['search']['value'] . "%' )";
	$countfilter .= "LIMIT " . $requestData['length'] . " ";

	$getrecordstmt = $db_dts->prepare($countfilter);
	$getrecordstmt->execute() or die("track_incoming.php");
	$getrecord1 = $getrecordstmt->fetch(PDO::FETCH_ASSOC);
	$totalData = $getrecord['id'];
	$totalFiltered = $totalData;
}


$data = array();

while ($row = $getAllIncomingDocumentsData->fetch(PDO::FETCH_ASSOC)) {
	$nestedData = array();

	$nestedData[] = $row["docno"];
	$nestedData[] = $row["date"];
	$nestedData[] = $row["type"];
	$nestedData[] = $row["obrno"];
	$nestedData[] = $row["dvno"];
	if ($row["payee"] == 'Please select...') {
		$nestedData[] = " ";
	} else {
		$nestedData[] = $row["payee"];
	}
	$nestedData[] = $row["particulars"];
	$nestedData[] = number_format($row["amount"], 2);
	$nestedData[] = $row["origin"];

	$data[] = $nestedData;
}


$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format



