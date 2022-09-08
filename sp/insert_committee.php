<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
        $objid = $_POST['codeno'];
		$committee = $_POST['committee'];
        $status = $_POST['status'];
        
    // check if committee number is available to avoid duplciation
    $check_committee_no_sql = "SELECT * FROM committee where objid = :objid";
    $committee_no_data = $con->prepare($check_committee_no_sql);
    $committee_no_data ->execute([
      ':objid' => $objid
    ]);

    if ($committee_no_data->rowCount() > 0){

        $_SESSION['error'] = "<i class='icon fa fa-warning'></i>Committee number already exist!";

     }else{

		$sql = "INSERT INTO committee (objid, committee, status) VALUES ('$objid', '$committee', '$status')";
		if($con->query($sql)){
			$_SESSION['success'] = "<i class='icon fa fa-check'></i>Committee added successfully";
		}
		else{
			$_SESSION['error'] = $con->error;
		}


  }
    }
    else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: committee.php');


?>