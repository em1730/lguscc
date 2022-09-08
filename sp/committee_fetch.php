<?php 
	include 'includes/session.php';
  
	if(isset($_POST['id'])){
    
		$id = $_POST['id'];
		$get_id_sql = "SELECT * FROM committee WHERE objid = :id";
    $get_id_data = $con->prepare($get_id_sql);
    $get_id_data->execute([':id'=>$id]);
    while ($result2 = $get_id_data->fetch(PDO::FETCH_ASSOC)) {

  $objid      = $result2['objid'];
  $committee  = $result2['committee'];
  $status     = $result2['status'];
  
}

$row = array(
  'objid'         => $objid,
  'committee'     => $committee,
  'status'        => $status,
);
    echo json_encode($row);
    
	}
?>