<?php

	include ('../config/db_config.php');
	//include('import_pdf.php');
	
	$alert_msg = '';
	$alert_msg1 = '';

	if (isset($_POST['update_profile'])) {
	
		// 	echo "<pre>";
		// 	print_r($_POST);
		// echo "</pre>";
		$firstname 	= $_POST['FirstName'];
		$middlename = $_POST['MiddleName'];
		$lastname 	= $_POST['LastName'];
		$email 		= $_POST['Email'];
		$contactno 	= $_POST['ContactNo'];
		$position	= $_POST['Position'];
		$department	= $_POST['Department'];
	
	
		$update_user_sql = "UPDATE tbl_users SET 
                first_name     = :fname,
                middle_name    = :mname,
                last_name      = :lname,
                contact_no     = :contact_number,
                position       = :position,
                email          = :email,
				department	   = :department
                -- userpass       = :upass,
                -- account_type   => :account_type 
                WHERE user_id  = :id";
    
          $update_data = $con->prepare($update_user_sql);
          $update_data->execute([
                ':fname'          => $firstname,
                ':mname'          => $middlename,
                ':lname'          => $lastname,
                ':contact_number' => $contactno,
                ':position'       => $position,
                ':email'          => $email,
				':department'     => $department,

                ':id'             => $user_id
		 ]);
		//  header('location: profile2.php');
		$alert_msg .= ' 
		<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="icon fa fa-check"></i>
		User Profile has been updated!
		</div>     
		  ';
		 
		  }

 // ---------------------------------------------------------Profile Picture

if (isset($_POST['update_profile_picture'])) {

	if ($_FILES["myFiles"]["error"] == 4){

    $alert_msg .= ' 
          <div class="alert alert-danger alert-dismissible">
              <i class="icon fa fa-warning"></i>
              No Photo Detected!
          </div>     
      ';
    
     }else{

    $currentDir = getcwd();
    $uploadDirectory = "../dist/img/";

    $errors = [];

    $fileExtensions = ['png','jpg','jpeg'];

    $fileName = $_FILES['myFiles']['name'];
    $fileSize = $_FILES['myFiles']['size'];
    $fileTmpName = $_FILES['myFiles']['tmp_name'];
    $fileType = $_FILES['myFiles']['type'];
    $target_file = $uploadDirectory . basename($_FILES['myFiles']['name']);
    $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $uploadPath = $uploadDirectory . basename($fileName);

    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed.";
    }
    if (empty($errors)) {
        $dipUpload = move_uploaded_file($fileTmpName, $uploadPath);


        if ($dipUpload) {
            $alert_msg1 .= ' 
       <div class="table-bordered">
           <i class="icon fa fa-success"></i>
           File has been uploaded
       </div>     
   ';
           


        } else {
            $alert_msg1 .= ' 
       <div class="alert alert-warning alert-dismissible"">
           <i class="icon fa fa-warning"></i>
           An Error Occured;
       </div>     
   ';
         

            $btnStatus = 'disabled';
            $btnNew = 'disabled';
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";

        }
    }

	$update_profilepic = "UPDATE tbl_users SET location = '$fileName' WHERE user_id = '$user_id'";

			if($con->query($update_profilepic)){
			$_SESSION['success'] = "<i class='icon fa fa-check'></i>Profile Picture has been updated!";
		}		else{
			$_SESSION['error'] = $con->error;
		}
	  
	}
	
}


		 

	
	


?>