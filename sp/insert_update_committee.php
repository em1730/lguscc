<?php
    include 'includes/session.php';
    
	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$committee = $_POST['committee'];
		$status= $_POST['status'];

		$sql = "UPDATE committee SET committee = '$committee', status = '$status' WHERE objid = '$id'";
		if($con->query($sql)){
			$_SESSION['success'] = "<i class='icon fa fa-check'></i>Committee updated successfully";
		}
		else{
			$_SESSION['error'] = $con->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:committee.php');

?>