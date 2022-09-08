<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$get_id_sql = "SELECT * FROM sp_members WHERE objid = :id";
    $get_id_data = $con->prepare($get_id_sql);
    $get_id_data->execute([':id'=>$id]);
    while ($result2 = $get_id_data->fetch(PDO::FETCH_ASSOC)) {

  $objid = $result2['objid'];
  $fullname = $result2['fullname'];
  $contactno = $result2['contactno'];
  $email = $result2['email'];
  $committee = $result2['committee'];
  $subcommittee = $result2['subcommittee'];
  $location = $result2['location'];

  $new_committees = explode(' , ', $committee);
  $new_subcommittees = explode(' , ', $subcommittee);
}

$photo = (empty($location)) ? '../dist/pic/defaultphoto.jpg' : '../dist/pic/'.$location ;

$row = array(
  'objid'           => $objid,
  'fullname'        => $fullname,
  'contactno'       => $contactno,
  'email'           => $email,
  'committee'       => $new_committees,
  'subcommittee'    => $new_subcommittees,
  'location'        => $photo,
);
		echo json_encode($row);
	}
?>