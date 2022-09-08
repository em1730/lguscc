<?php
    include 'includes/session.php';
    
	if(isset($_POST['edit'])){

   $id = $_POST['id'];
   $date_note = date('Y-m-d', strtotime($_POST['date_note']));
   $title_note = $_POST['title_note'];
   $content_note = $_POST['content_note'];

		$sql = "UPDATE notes SET title = '$title_note', content = '$content_note', date = '$date_note' WHERE noteid = '$id'";
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

	header('location:index.php');

?>