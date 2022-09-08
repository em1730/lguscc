<?php

// include('../config/db_config.php');


if (isset($_POST['upload_document'])) {

	// $uploaded_file = $_FILES['user_file']; // uploaded file

$table_success .='
	<table border="1" width="100%">
		<thead>
			<th>Firstname</th>
			<th>Middlename</th>
			<th>Lastname</th>
			<th>Email</th>
			<th>Contact Number</th>
			<th>Username</th>
			<th>Password</th>
		</thead>
		<tbody>
';

$table_error .='
	<table border="1" width="100%">
		<thead>
			<th>Firstname</th>
			<th>Middlename</th>
			<th>Lastname</th>
			<th>Email</th>
			<th>Contact Number</th>
			<th>Username</th>
			<th>Password</th>
		</thead>
		<tbody>
';

$table_preview_success .= ' 
    <div class="new-alert new-alert-success alert-dismissible">
        <i class="icon fa fa-success"></i>
        Data Preview to be inserted to Database.
    </div>     
';

$table_preview_error .= ' 
    <div class="new-alert new-alert-warning alert-dismissible">
        <i class="icon fa fa-warning"></i>
        Data Preview that has been removed. Already exist in our database.
    </div>     
';
	//filename of the uploaded file
	$filename  = $_FILES["user_file"]["tmp_name"];

	if ($_FILES["user_file"]["size"] > 0) { //if size is not equal to 0

		$file = fopen($filename, "r"); //READ the file

		$row = 1; //reading start at row 1

		//loop through the file
		while (($data = fgetcsv($file, 10000, ",")) !== FALSE) {

			//if true proceed to next row since the data that we
			//will fetch is the value not field names
			if ($row == 1) { 

				$row++;
				continue;
				
			}

			if (empty($data[0])) { // firstname == empty

			    $alert_msg .= ' 
			        <div class="new-alert new-alert-warning alert-dismissible">
			            <i class="icon fa fa-warning"></i>
			            Invalid Firstname.Please check Firstname column.
			        </div>     
			    ';

				
			}
			else {
				if (empty($data[1])) { //middlename ==empty
				    $alert_msg .= ' 
				        <div class="new-alert new-alert-warning alert-dismissible">
				            <i class="icon fa fa-warning"></i>
				            Invalid Middlename.Please check Middlename column.
				        </div>     
				    ';	

				}
				else {
					if (empty($data[2])) { //lastname == empty
					    $alert_msg .= ' 
					        <div class="new-alert new-alert-warning alert-dismissible">
					            <i class="icon fa fa-warning"></i>
					            Invalid Lastname.Please check Lastname column.
					        </div>     
					    ';	

					}
					else {
						if (empty($data[3])) { //email = empty
						    $alert_msg .= ' 
						        <div class="new-alert new-alert-warning alert-dismissible">
						            <i class="icon fa fa-warning"></i>
						            Invalid Email.Please check Email column. 
						        </div>     
						    ';			


						}
						else {
							if (empty($data[4])) { //contact number == empty
							    $alert_msg .= ' 
							        <div class="new-alert new-alert-warning alert-dismissible">
							            <i class="icon fa fa-warning"></i>
							            Invalid Contact Number.Please check Contact Number column.
							        </div>     
							    ';	

							}
							else {
								if (empty($data[5])) { //username
								    $alert_msg .= ' 
								        <div class="new-alert new-alert-warning alert-dismissible">
								            <i class="icon fa fa-warning"></i>
								            Invalid Username.Please check Username column.
								        </div>     
								    ';		
								}
								else {
									if (empty($data[6])) { //userpas
									    $alert_msg .= ' 
									        <div class="new-alert new-alert-warning alert-dismissible">
									            <i class="icon fa fa-warning"></i>
									            Invalid Password.Please check Password column.
									        </div>     
									    ';		
									}
									else {

										$first_name= $data[0];
										$middle_name= $data[1];
										$last_name= $data[2];
										$email= $data[3];
										$contact_number= $data[4];
										$user_name= $data[5];
										$user_pass= $data[6];

										$check_fullname_sql = "SELECT user_id FROM tbl_users WHERE first_name = :fname AND middle_name = :mname AND last_name = :lname";
										$check_fullname_data = $con->prepare($check_fullname_sql);
										$check_fullname_data->execute([':fname'=>$first_name, ':mname'=>$middle_name, ':lname'=>$last_name]);
										if ($check_fullname_data->rowCount() > 0) {

											$table_error .= '
												<tr>
													<td>'.$first_name.'</td>
													<td>'.$middle_name.'</td>
													<td>'.$last_name.'</td>
													<td>'.$email.'</td>
													<td>'.$contact_number.'</td>
													<td>'.$user_name.'</td>
													<td>'.$user_pass.'</td>
												</tr>
											';
										}
										else {
											$hidden_data_success .='
												<input type = "hidden" name ="all_firstname[]" value="'.$first_name.'">
												<input type = "hidden" name ="all_middlename[]" value="'.$middle_name.'">
												<input type = "hidden" name ="all_lastname[]" value="'.$last_name.'">
												<input type = "hidden" name ="all_email[]" value="'.$email.'">
												<input type = "hidden" name ="all_contact_number[]" value="'.$contact_number.'">
												<input type = "hidden" name ="all_username[]" value="'.$user_name.'">
												<input type = "hidden" name ="all_userpass[]" value="'.$user_pass.'">
											';

											$btnStatus = "enabled";
											$table_success .= '
												<tr>
													<td>'.$first_name.'</td>
													<td>'.$middle_name.'</td>
													<td>'.$last_name.'</td>
													<td>'.$email.'</td>
													<td>'.$contact_number.'</td>
													<td>'.$user_name.'</td>
													<td>'.$user_pass.'</td>
												</tr>

											';	
										}
									}
								}
							}
						}
					}
				}
			}
		    
		} //end while

		$table_success .= '
				</tbody>
			</table>
		';

		$table_error .= '
				</tbody>
			</table>
			<br>
			<hr>
		';
		
	}

}
else {

	if (isset($_POST['import'])) {

		// $firstname = $_POST['all_firstname'];
		$middlename = $_POST['all_middlename'];
		$lastname = $_POST['all_lastname'];
		$email = $_POST['all_email'];
		$contact_number = $_POST['all_contact_number'];
		$username = $_POST['all_username'];
		$userpass = $_POST['all_userpass'];

		foreach ($_POST['all_firstname'] as $index => $value) {

			$new_firstname = $value;
			$new_middlename = $middlename[$index];
			$new_lastname = $lastname[$index];
			$new_email = $email[$index];
			$new_contact_number = $contact_number[$index];
			$new_username = $username[$index];

          //hash password
          $hash_userpass = password_hash($userpass[$index], PASSWORD_DEFAULT);

          $insert_sql = "INSERT INTO tbl_users(first_name, middle_name, last_name, email, contact_number, username, userpass, account_type) VALUES(:fname, :mname, :lname, :email, :contact_number, :uname, :upass , :type)";

          $data = $con->prepare($insert_sql);
          $data->execute([':fname'=>$new_firstname, ':mname'=>$new_middlename, ':lname'=>$new_lastname, ':email'=>$new_email, ':contact_number'=>$new_contact_number, ':uname'=>$new_username, ':upass'=>$hash_userpass, ':type'=>'2']);
		}
		
	    $alert_msg .= ' 
	        <div class="new-alert new-alert-success alert-dismissible">
	            <i class="icon fa fa-success"></i>
	            Import Successful.
	        </div>     
	    ';	
	}
	
}

?>