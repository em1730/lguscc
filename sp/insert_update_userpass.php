<?php

     include 'includes/session.php'; 
	
	
	$alert_msg = '';
	$alert_msg1 = '';

	if (isset($_POST['edit'])) {
	
	
		$username 	= $_POST['newusername'];
		$newuserpass = $_POST['newpassword'];
		$olduserpass = $_POST['oldpassword'];

		//select old password users
		$oldpassword_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
		$oldpassword_data = $con->prepare($oldpassword_sql);
		$oldpassword_data->execute([':id'=>$user_id]);  
		while ($result = $oldpassword_data->fetch(PDO::FETCH_ASSOC)) {
			$oldpassword = $result['userpass'];
		}
		
		
		

		if (password_verify($olduserpass, $oldpassword )) {

		$hash_newpassword  = password_hash($newuserpass, PASSWORD_DEFAULT);

		$update_user_sql = "UPDATE tbl_users SET 
                username       = :username,
                userpass       = :userpass
               
                WHERE user_id  = :id";
    
          $update_data = $con->prepare($update_user_sql);
          $update_data->execute([
                ':username'          => $username,
                ':userpass'          => $hash_newpassword,

                ':id'                => $user_id
		 ]);
		 
		$_SESSION['success'] = "<i class='icon fa fa-check'></i>Username and Password Updated!";
		 
		  
		}else{

		$_SESSION['error'] = "<i class='icon fa fa-check'></i>Wrong Password!";

		  }
		}
		header('location: profile2.php');

?>