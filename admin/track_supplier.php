<?php
session_start();
/* Database connection start */
$servername = "192.168.0.1";
$username = "root";
$password = "1234";
$dbname = "scc_doctrack";


$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());


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
0 => 'objid',
1 =>'code', 
2 => 'name_supplier',
3 => 'owner',
4 => 'address',
5 => 'contact_no',



);



// getting total number records without any search
$sql = "SELECT * FROM tbl_suppliers";
$query=mysqli_query($conn, $sql) or die("track_supplier.php");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * FROM tbl_suppliers where 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( code LIKE '%".$requestData['search']['value']."%' ";    
	$sql.=" OR name_supplier LIKE '%".$requestData['search']['value']."%' ";

	$sql.=" OR owner LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR address LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR contact_no LIKE '%".$requestData['search']['value']."%' ) ";
	// $sql.=" OR status LIKE '%".$requestData['search']['value']."%' )";
	
}
$query=mysqli_query($conn, $sql) or die("track_supplier.php");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY name_supplier, code LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("track_supplier.php");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	$nestedData[] = $row["objid"];
	$nestedData[] = $row["code"];
	$nestedData[] = $row["name_supplier"];
	$nestedData[] = $row["owner"];
	$nestedData[] = $row["address"];
	$nestedData[] = $row["contact_no"];
	


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
