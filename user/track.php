<?php
/* Database connection start */
$servername = "192.168.0.1";
$username = "root";
$password = "adminpw";
$dbname = "scc_doctrack";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

	0 => 'docno', 
	1 => 'txndate',
	2 => 'time',
	3 => 'particulars',
	4 => 'receiver',
	5 => 'origin',
	6 => 'destination',
	7 => 'status',
	8 => 'remarks'

);

// getting total number records without any search
$sql = "SELECT docno, txndate, time, particulars, receiver, origin, destination, status, remarks FROM tbl_ledger where txndate = now()";
$query=mysqli_query($conn, $sql) or die("track.php");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT docno, txndate, time, particulars, receiver, origin, destination, status, remarks";
$sql.=" FROM tbl_ledger WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( docno LIKE '%".$requestData['search']['value']."%' ";    
	$sql.=" OR txndate LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR time LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR particulars LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR receiver LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR origin LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR destination LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR status LIKE '%".$requestData['search']['value']."%' )";
}

// $sql. = " group by docno"
$query=mysqli_query($conn, $sql) or die("track.php");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY txndate,time DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("track.php");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["docno"];
	$nestedData[] = $row["txndate"];
	$nestedData[] = $row["time"];
	$nestedData[] = $row["particulars"];
	$nestedData[] = $row["receiver"];
	$nestedData[] = $row["origin"];
	$nestedData[] = $row["destination"];
	$nestedData[] = $row["status"];
	$nestedData[] = $row["remarks"];

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
