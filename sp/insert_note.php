<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
     
     $date_note = date('Y-m-d', strtotime($_POST['date_note']));
	 	 $title_note = $_POST['title_note'];
     $content_note = $_POST['content_note'];
        

		$sql = "INSERT INTO notes (date, title, content, user_id) VALUES ('$date_note', '$title_note', '$content_note', '$user_id')";
		if($con->query($sql)){
			$_SESSION['success'] = "<i class='icon fa fa-check'></i>New Note has been added!";
		}
		else{
			$_SESSION['error'] = $con->error;
		}


  
    }
    else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: index.php');


?>