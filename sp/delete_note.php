<?php


	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM notes WHERE noteid = '$id'";
		if($con->query($sql)){
			$_SESSION['success'] = "<i class='icon fa fa-check'></i>Note deleted successfully";
		}
		else{
			$_SESSION['error'] = $con->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: index.php');
	

?>