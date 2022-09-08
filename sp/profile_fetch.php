<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){

		$id = $_POST['id'];
		$get_id_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
    $get_id_data = $con->prepare($get_id_sql);
    $get_id_data->execute([':id'=>$id]);
    while ($result2 = $get_id_data->fetch(PDO::FETCH_ASSOC)) {

      $user_id  = $result2['user_id'];
      $username = $result2['username'];
      $userpass = $result2['userpass'];
}

$row = array(

  'user_id'         => $user_id,
  'username'        => $username,
  'userpass'        => $userpass,
);
		echo json_encode($row);
	}
?>