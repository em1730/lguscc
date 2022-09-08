<?php
/* Database connection start */
// $servername = "localhost";
// $username = "root";
// $password = "1234";
// $dbname = "scc_doctrack";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scc_doctrack";
//$office = $_POST['office'];

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

	0 => 'docno', 
	1 => 'type',
	2 => 'obrno',
	3 => 'dvno',
	4 => 'payee',
	5 => 'particulars',
	6 => 'amount',
	
	
);

// getting total number records without any search
//$sql = "SELECT docno, txndate, time, particulars, receiver, origin, destination, status, remarks FROM tbl_ledger WHERE 1=1 group by docno ORDER BY txndate DESC,time DESC";

$sql = "SELECT docno, obrno, dvno, payee, date, particulars, amount, type FROM tbl_documents WHERE 1=1 group by docno ORDER BY date DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
$query=mysqli_query($conn, $sql) or die("track.php");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

//$sql = "SELECT docno, txndate, time, particulars, receiver, origin, destination, status, remarks FROM tbl_ledger WHERE 1=1  group by docno";

$sql = "SELECT docno, obrno, dvno, payee, date, particulars, amount, type FROM tbl_documents WHERE 1=1 group by docno";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" having docno LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR obrno LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR dvno LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR payee LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR particulars LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR amount LIKE '%".$requestData['search']['value']."%' ";
	//$sql.=" OR status LIKE '%".$requestData['search']['value']."%' ";
}

// $sql. = " group by docno"
$query=mysqli_query($conn, $sql) or die("track.php");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY date DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("track.php");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["docno"];
	$nestedData[] = $row["type"];
	$nestedData[] = $row["obrno"];
	$nestedData[] = $row["dvno"];
	if ($row["payee"] == 'Please select...'){
	$nestedData[] = " ";
	}else{
	$nestedData[] = $row["payee"];
	}
	$nestedData[] = $row["particulars"];
	$nestedData[] = number_format($row["amount"],2);

	
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
